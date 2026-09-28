<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CheckItem;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReporteHistorialEstado;
use Illuminate\Support\Facades\DB;
use App\Services\ReporteSnapshotService;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\ReportesExport;
use App\Exports\ReporteDetalleExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{


    private function puedeConsultarReporte(Reporte $reporte): bool
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return false;
        }

        // Ambos administradores pueden consultar todos los reportes.
        if ($usuario->hasAnyRole(['administrador', 'super-admin'])) {
            return true;
        }

        // El Supervisor solo puede consultar sus propios reportes.
        if ($usuario->hasRole('supervisor')) {
            return (string) $reporte->id_users
                === (string) $usuario->id_users;
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | LISTADO DE REPORTES
    |--------------------------------------------------------------------------
    */


    public function index(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario?->hasAnyRole([
            'supervisor',
            'administrador',
            'super-admin',
        ])) {
            return redirect()
                ->route('dashboard')
                ->with('warning', 'No tienes permiso para consultar reportes.');
        }

        $query = Reporte::with(['area', 'usuario']);

        if (
            $usuario->hasRole('supervisor')
            && !$usuario->hasAnyRole(['administrador', 'super-admin'])
        ) {
            $query->where('id_users', $usuario->id_users);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('id_areas')) {
            $query->where('id_areas', $request->id_areas);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $reportes = $query
            ->orderByDesc('fecha')
            ->orderByDesc('id_reportes')
            ->get();

        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('reportes.index', compact('reportes', 'areas'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $user = Auth::user();

        if (blank($user->firma)) {
            return redirect()
                ->route('supervisor.dashboard')
                ->with(
                    'warning',
                    'Para crear un reporte, primero debes registrar tu firma en tu perfil.'
                );
        }

        $areas = Area::where('activo', true)
            ->with([
                'infraestructuras' => function ($query) {
                    $query->where('activo', true)
                        ->orderBy('nombre');
                },
                'infraestructuras.checkItems' => function ($query) {
                    $query->where('activo', true)
                        ->orderBy('orden');
                },
            ])
            ->orderBy('nombre')
            ->get();

        return view('reportes.create', compact('areas'));
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = Auth::user();

        if (blank($user->firma)) {
            return redirect()
                ->route('supervisor.dashboard')
                ->with(
                    'warning',
                    'No se puede guardar el reporte porque no tienes una firma registrada. Agrégala en tu perfil e inténtalo nuevamente.'
                );
        }
        $validated = $request->validate([
            'id_areas' => [
                'required',
                'exists:areas,id_areas'
            ],

            'fecha' => [
                'required',
                'date'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],

            'detalles' => [
                'required',
                'array'
            ],

            'detalles.*.estado' => [
                'required',
                'in:A,NC,NA,NFR'
            ],

            'detalles.*.observacion' => [
                'nullable',
                'string'
            ],
        ]);


        /*
    |--------------------------------------------------------------------------
    | VALIDAR CHECK ITEMS
    |--------------------------------------------------------------------------
    |
    | CheckItem
    |      ↓
    | Infraestructura
    |      ↓
    | Área
    |
    */

        $checkItemIds = array_keys(
            $validated['detalles']
        );


        $cantidadItemsValidos = CheckItem::whereIn(
            'id_check_items',
            $checkItemIds
        )
            ->whereHas(
                'infraestructura',
                function ($query) use ($validated) {

                    $query->where(
                        'id_areas',
                        $validated['id_areas']
                    );
                }
            )
            ->count();


        if (
            $cantidadItemsValidos
            !== count($checkItemIds)
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Uno o más elementos seleccionados no pertenecen al área indicada.'
                );
        }


        /*
    |--------------------------------------------------------------------------
    | CREAR REPORTE + DETALLES + HISTORIAL
    |--------------------------------------------------------------------------
    */

        DB::transaction(function () use ($validated) {

            /*
        |--------------------------------------------------------------------------
        | CREAR REPORTE
        |--------------------------------------------------------------------------
        */

            $reporte = Reporte::create([
                'id_users' => Auth::id(),

                'id_areas' =>
                $validated['id_areas'],

                'fecha' =>
                $validated['fecha'],

                'semana' =>
                now()->weekOfYear,

                'estado' =>
                'borrador',

                'observaciones' =>
                $validated['observaciones']
                    ?? null,
            ]);


            /*
        |--------------------------------------------------------------------------
        | CREAR DETALLES
        |--------------------------------------------------------------------------
        */

            foreach (
                $validated['detalles']
                as $checkItemId => $detalle
            ) {
                $reporte
                    ->detalles()
                    ->create([
                        'id_check_items' =>
                        $checkItemId,

                        'estado' =>
                        $detalle['estado'],

                        'observacion' =>
                        $detalle['observacion']
                            ?? null,
                    ]);
            }


            /*
        |--------------------------------------------------------------------------
        | REGISTRAR ESTADO INICIAL
        |--------------------------------------------------------------------------
        */

            ReporteHistorialEstado::create([
                'id_reportes' =>
                $reporte->id_reportes,

                'id_users' =>
                Auth::id(),

                'estado_anterior' =>
                null,

                'estado_nuevo' =>
                'borrador',

                'comentario' =>
                'Reporte creado.',
            ]);
        });


        return redirect()
            ->route('reportes.index')
            ->with(
                'success',
                'Reporte creado correctamente.'
            );
    }


    /*
|--------------------------------------------------------------------------
| MOSTRAR REPORTE
|--------------------------------------------------------------------------
*/


    public function show(Reporte $reporte)
    {
        if (!$this->puedeConsultarReporte($reporte)) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para visualizar este reporte.'
                );
        }

        $reporte->load([
            'area',
            'usuario',
            'aprobador',
            'detalles.checkItem.infraestructura',
            'snapshot',
        ]);

        return view('reportes.show', compact('reporte'));
    }

    /*
    |--------------------------------------------------------------------------
    | PDF GENERAL
    |--------------------------------------------------------------------------
    */


    public function pdfGeneral()
    {
        if (!Auth::user()?->hasAnyRole(['administrador', 'super-admin'])) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para descargar el listado general.'
                );
        }

        $reportes = Reporte::with([
            'area',
            'usuario',
        ])
            ->latest()
            ->get();

        $pdf = Pdf::loadView(
            'reportes.pdf-general',
            compact('reportes')
        );

        return $pdf->download(
            'reportes-preoperacionales.pdf'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | EDIT / UPDATE / DELETE
    |--------------------------------------------------------------------------
    */

    public function edit(Reporte $reporte)
    {
        //
    }

    public function update(
        Request $request,
        Reporte $reporte
    ) {
        //
    }

    public function destroy(Reporte $reporte)
    {
        //
    }


    /**
     * Enviar un borrador para revisión.
     */
    public function enviar(Reporte $reporte)
    {
        $usuario = Auth::user();

        $esSuperAdmin = $usuario->hasRole('super-admin');

        $resultado = DB::transaction(function () use ($reporte, $usuario, $esSuperAdmin) {

            $reporte = Reporte::query()
                ->whereKey($reporte->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            // Solo el propietario o el Superadministrador pueden enviarlo.
            $esPropietario = (string) $reporte->id_users
                === (string) $usuario->id_users;

            if (!$esSuperAdmin && !$esPropietario) {
                return 'otro_usuario';
            }

            // Únicamente se pueden enviar borradores.
            if ($reporte->estado !== 'borrador') {
                return 'estado_invalido';
            }

            if (!$reporte->detalles()->exists()) {
                return 'sin_detalles';
            }

            // La firma histórica pertenece al creador del reporte,
            // no necesariamente a la persona que pulsa Enviar.
            $supervisor = $reporte->usuario;

            if (!$supervisor || blank($supervisor->firma)) {
                return 'sin_firma_supervisor';
            }

            $disk = Storage::disk('public');

            if (!$disk->exists($supervisor->firma)) {
                return 'archivo_firma_supervisor_no_encontrado';
            }

            $extension = pathinfo(
                $supervisor->firma,
                PATHINFO_EXTENSION
            );

            $extension = $extension
                ? strtolower($extension)
                : 'png';

            $firmaHistorica = 'snapshots/reportes/' .
                $reporte->id_reportes .
                '/supervisor.' .
                $extension;

            if (!$disk->exists($firmaHistorica)) {
                $copiada = $disk->copy(
                    $supervisor->firma,
                    $firmaHistorica
                );

                if (!$copiada) {
                    return 'error_copia_firma_supervisor';
                }
            }

            $reporte->update([
                'estado' => 'enviado',
                'firma_supervisor_snapshot' => $firmaHistorica,
                'nombre_supervisor_snapshot' => $supervisor->name,
            ]);

            ReporteHistorialEstado::create([
                'id_reportes' => $reporte->id_reportes,
                'id_users' => $usuario->id_users,
                'estado_anterior' => 'borrador',
                'estado_nuevo' => 'enviado',
                'comentario' => $esSuperAdmin
                    ? 'Reporte enviado para revisión por el Superadministrador.'
                    : 'Reporte enviado para revisión.',
            ]);

            return 'enviado';
        });

        if ($resultado === 'otro_usuario') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with('warning', 'No tienes permiso para enviar este reporte.');
        }

        if ($resultado === 'estado_invalido') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with('warning', 'Solo se pueden enviar reportes en estado borrador.');
        }

        if ($resultado === 'sin_detalles') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with('warning', 'El reporte debe contener elementos de inspección.');
        }

        if ($resultado === 'sin_firma_supervisor') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with(
                    'warning',
                    'El supervisor que creó el reporte debe registrar su firma antes del envío.'
                );
        }
        if ($resultado === 'archivo_firma_supervisor_no_encontrado') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with(
                    'warning',
                    'No se encontró el archivo de firma del supervisor. Debe volver a registrar su firma antes de enviar el reporte.'
                );
        }

        if ($resultado === 'error_copia_firma_supervisor') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with(
                    'warning',
                    'No fue posible conservar la firma histórica del supervisor. Intenta nuevamente.'
                );
        }

        return redirect()
            ->route('reportes.show', $reporte)
            ->with('success', 'Reporte enviado correctamente para revisión.');
    }


    /*
    |--------------------------------------------------------------------------
    | APROBAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function aprobar(Reporte $reporte)
    {

        if (blank(Auth::user()?->firma)) {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with(
                    'warning',
                    'Para aprobar este reporte, primero debes registrar tu firma en tu perfil.'
                );
        }
        $resultado = DB::transaction(function () use ($reporte) {

            $reporte = Reporte::query()
                ->whereKey($reporte->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            // Se pueden aprobar borradores y reportes enviados.
            // Nunca reportes ya aprobados o rechazados.
            if ($reporte->estado !== 'enviado') {
                return false;
            }

            $estadoAnterior = $reporte->estado;

            $reporte->update([
                'estado' => 'aprobado',
                'id_usuario_aprobador' => Auth::id(),
                'fecha_aprobacion' => now(),
                'motivo_rechazo' => null,
            ]);
            ReporteHistorialEstado::create([
                'id_reportes' => $reporte->id_reportes,
                'id_users' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'aprobado',
                'comentario' => 'Reporte aprobado.',
            ]);

            app(ReporteSnapshotService::class)->crear($reporte);

            return true;
        });

        if (!$resultado) {
            return redirect()
                ->route('administrador.dashboard')
                ->with(
                    'warning',
                    'Este reporte ya fue aprobado o rechazado y no puede volver a modificarse.'
                );
        }

        return redirect()
            ->route('administrador.dashboard')
            ->with('success', 'Reporte aprobado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | RECHAZAR REPORTE
    |--------------------------------------------------------------------------
    */
    public function rechazar(Request $request, Reporte $reporte)
    {

        if (blank(Auth::user()?->firma)) {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with(
                    'warning',
                    'Para rechazar este reporte, primero debes registrar tu firma en tu perfil.'
                );
        }
        $validated = $request->validate(
            [
                'motivo_rechazo' => ['required', 'string', 'max:1000'],
            ],
            [
                'motivo_rechazo.required' => 'Debe digitar el motivo del rechazo.',
                'motivo_rechazo.string' => 'El motivo del rechazo debe ser un texto.',
                'motivo_rechazo.max' => 'El motivo del rechazo no puede superar los 1000 caracteres.',
            ]
        );

        $resultado = DB::transaction(function () use ($reporte, $validated) {

            $reporte = Reporte::query()
                ->whereKey($reporte->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            // Solo se pueden rechazar borradores o reportes enviados.
            if ($reporte->estado !== 'enviado') {
                return false;
            }

            $estadoAnterior = $reporte->estado;

            $reporte->update([
                'estado' => 'rechazado',
                'id_usuario_aprobador' => Auth::id(),
                'fecha_aprobacion' => null,
                'motivo_rechazo' => $validated['motivo_rechazo'],
            ]);

            ReporteHistorialEstado::create([
                'id_reportes' => $reporte->id_reportes,
                'id_users' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'rechazado',
                'comentario' => 'Reporte rechazado.',
            ]);
            app(ReporteSnapshotService::class)->crear($reporte);
            return true;
        });

        if (!$resultado) {
            return redirect()
                ->route('administrador.dashboard')
                ->with(
                    'warning',
                    'Este reporte ya fue aprobado o rechazado y no puede volver a modificarse.'
                );
        }

        return redirect()
            ->route('administrador.dashboard')
            ->with('success', 'Reporte rechazado correctamente.');
    }





    /*
    |--------------------------------------------------------------------------
    | EXCEL GENERAL
    |--------------------------------------------------------------------------
    */




    public function excel()
    {
        if (!Auth::user()?->hasAnyRole(['administrador', 'super-admin'])) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para descargar el listado general.'
                );
        }

        return Excel::download(
            new ReportesExport,
            'reportes.xlsx'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | EXCEL INDIVIDUAL
    |--------------------------------------------------------------------------
    */


    public function excelDetalle(Reporte $reporte)
    {
        if (!$this->puedeConsultarReporte($reporte)) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para descargar este reporte.'
                );
        }

        return Excel::download(
            new ReporteDetalleExport($reporte),
            'reporte-' . $reporte->id_reportes . '.xlsx'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | PDF INDIVIDUAL
    |--------------------------------------------------------------------------
    */


    public function pdf(Reporte $reporte)
    {
        if (!$this->puedeConsultarReporte($reporte)) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para descargar este reporte.'
                );
        }

        $reporte->load([
            'area',
            'usuario',
            'aprobador',
            'detalles.checkItem.infraestructura',
            'snapshot',
        ]);

        $pdf = Pdf::loadView(
            'reportes.pdf',
            compact('reporte')
        );

        return $pdf->download(
            'reporte-preoperacional-' .
                $reporte->id_reportes . '.pdf'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMINISTRADOR
    |--------------------------------------------------------------------------
    */

    public function dashboardAdmin()
    {
        $totalReportes =
            Reporte::count();

        $aprobados =
            Reporte::where(
                'estado',
                'aprobado'
            )->count();

        $rechazados =
            Reporte::where(
                'estado',
                'rechazado'
            )->count();

        $borradores =
            Reporte::where(
                'estado',
                'borrador'
            )->count();

        $pendientes = Reporte::where('estado', 'enviado')->count();

        return view(
            'dashboard.administrador',
            compact(
                'totalReportes',
                'aprobados',
                'rechazados',
                'borradores',
                'pendientes'
            )
        );
    }


    /*
|--------------------------------------------------------------------------
| GUARDAR FIRMAS
|--------------------------------------------------------------------------
*/


    public function guardarFirmas(
        Request $request,
        Reporte $reporte
    ) {
        $usuario = Auth::user();

        $esSuperAdmin = $usuario?->hasRole('super-admin');

        $esSupervisorPropietario =
            $usuario?->hasRole('supervisor') &&
            (string) $reporte->id_users ===
            (string) $usuario->id_users;

        if (!$esSuperAdmin && !$esSupervisorPropietario) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para modificar las firmas de este reporte.'
                );
        }

        if ($reporte->estado !== 'borrador') {
            return redirect()
                ->route('reportes.show', $reporte)
                ->with(
                    'warning',
                    'No se pueden modificar las firmas de un reporte enviado, aprobado o rechazado.'
                );
        }

        $validated = $request->validate([
            'inspector_calidad' => [
                'nullable',
                'string',
                'max:255',
            ],
            'firma_inspector' => [
                'nullable',
                'string',
            ],
            'verificador_calidad' => [
                'nullable',
                'string',
                'max:255',
            ],
            'firma_verificador' => [
                'nullable',
                'string',
            ],
        ]);

        $reporte->update($validated);

        return redirect()
            ->route('reportes.show', $reporte)
            ->with(
                'success',
                'Se han guardado las firmas correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD SUPERVISOR
    |--------------------------------------------------------------------------
    */

    public function dashboardSupervisor()
    {
        $user = Auth::user();

        if (!$user?->hasAnyRole(['supervisor', 'super-admin'])) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'No tienes permiso para acceder a este panel.'
                );
        }

        $hoy = now()->toDateString();

        $queryBase = Reporte::query();

        if ($user->hasRole('supervisor')) {
            $queryBase->where('id_users', $user->id_users);
        }

        $reporteCaliente = (clone $queryBase)
            ->whereDate('fecha', $hoy)
            ->whereHas('area', function ($query) {
                $query->where('nombre', 'like', '%Caliente%');
            })
            ->where('estado', '!=', 'rechazado')
            ->exists();

        $reporteFrio = (clone $queryBase)
            ->whereDate('fecha', $hoy)
            ->whereHas('area', function ($query) {
                $query->where('nombre', 'like', '%Fría%')
                    ->orWhere('nombre', 'like', '%Fria%');
            })
            ->where('estado', '!=', 'rechazado')
            ->exists();

        // Se mantiene el listado de borradores que utiliza
        // actualmente el dashboard del Supervisor.
        $reportes = (clone $queryBase)
            ->with(['area', 'usuario'])
            ->where('estado', 'borrador')
            ->orderByDesc('fecha')
            ->get();

        $aprobados = (clone $queryBase)
            ->where('estado', 'aprobado')
            ->count();

        $rechazados = (clone $queryBase)
            ->where('estado', 'rechazado')
            ->count();

        $borradores = (clone $queryBase)
            ->where('estado', 'borrador')
            ->count();

        return view(
            'dashboard.supervisor',
            compact(
                'reportes',
                'aprobados',
                'rechazados',
                'borradores'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MIS REPORTES
    |--------------------------------------------------------------------------
    */

    public function misReportes()
    {
        $userId = Auth::id();

        $reportes = Reporte::with('area')
            ->where(
                'id_users',
                $userId
            )
            ->orderBy(
                'fecha',
                'desc'
            )
            ->get();

        return view(
            'supervisor.mis_reportes',
            compact('reportes')
        );
    }
}
