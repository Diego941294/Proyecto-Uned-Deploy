<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CheckItem;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReporteHistorialEstado;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\ReportesExport;
use App\Exports\ReporteDetalleExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE REPORTES
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Reporte::with([
            'area',
            'usuario'
        ]);

        if ($request->filled('fecha')) {
            $query->whereDate(
                'fecha',
                $request->fecha
            );
        }

        if ($request->filled('id_areas')) {
            $query->where(
                'id_areas',
                $request->id_areas
            );
        }

        if ($request->filled('estado')) {
            $query->where(
                'estado',
                $request->estado
            );
        }

        $reportes = $query
            ->latest()
            ->get();

        $areas = Area::where(
            'activo',
            true
        )
            ->orderBy('nombre')
            ->get();

        return view(
            'reportes.index',
            compact(
                'reportes',
                'areas'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $hoy = \Carbon\Carbon::today()
            ->format('Y-m-d');

        $areas = Area::where(
            'activo',
            true
        )
            ->with([
                'infraestructuras' => function ($query) {
                    $query->where(
                        'activo',
                        true
                    )
                        ->orderBy('nombre');
                },

                'infraestructuras.checkItems' => function ($query) {
                    $query->where(
                        'activo',
                        true
                    )
                        ->orderBy('orden');
                }
            ])
            ->orderBy('nombre')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ÁREAS DISPONIBLES
        |--------------------------------------------------------------------------
        |
        | Se permite crear un reporte si:
        |
        | 1. No existe un reporte del área para hoy.
        | 2. Todos los reportes existentes del día están rechazados.
        |
        */

        $areas = $areas->filter(
            function ($area) use ($hoy) {

                $reportesHoy = Reporte::where(
                    'id_areas',
                    $area->id_areas
                )
                    ->whereDate(
                        'fecha',
                        $hoy
                    )
                    ->get();

                if ($reportesHoy->isEmpty()) {
                    return true;
                }

                return $reportesHoy->every(
                    function ($reporte) {
                        return $reporte->estado === 'rechazado';
                    }
                );
            }
        );

        return view(
            'reportes.create',
            compact('areas')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
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
        $reporte->load([
            'area',
            'usuario',
            'aprobador',
            'detalles.checkItem.infraestructura'
        ]);

        return view(
            'reportes.show',
            compact('reporte')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PDF GENERAL
    |--------------------------------------------------------------------------
    */

    public function pdfGeneral()
    {
        $reportes = Reporte::with([
            'area',
            'usuario'
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


    /*
    |--------------------------------------------------------------------------
    | APROBAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function aprobar(Reporte $reporte)
    {
        DB::transaction(function () use ($reporte) {

            $estadoAnterior = $reporte->estado;

            $reporte->update([
                'estado' => 'aprobado',
                'id_usuario_aprobador' => Auth::id(),
                'fecha_aprobacion' => now(),
            ]);

            ReporteHistorialEstado::create([
                'id_reportes' => $reporte->id_reportes,
                'id_users' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'aprobado',
                'comentario' => 'Reporte aprobado.',
            ]);
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Reporte aprobado.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | RECHAZAR REPORTE
    |--------------------------------------------------------------------------
    */

    public function rechazar(Reporte $reporte)
    {
        DB::transaction(function () use ($reporte) {

            $estadoAnterior = $reporte->estado;

            $reporte->update([
                'estado' => 'rechazado',
                'id_usuario_aprobador' => Auth::id(),
                'fecha_aprobacion' => null,
            ]);

            ReporteHistorialEstado::create([
                'id_reportes' => $reporte->id_reportes,
                'id_users' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'rechazado',
                'comentario' => 'Reporte rechazado.',
            ]);
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Reporte rechazado.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EXCEL GENERAL
    |--------------------------------------------------------------------------
    */

    public function excel()
    {
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

    public function excelDetalle(
        Reporte $reporte
    ) {
        return Excel::download(
            new ReporteDetalleExport(
                $reporte
            ),

            'reporte-'
                . $reporte->id_reportes
                . '.xlsx'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PDF INDIVIDUAL
    |--------------------------------------------------------------------------
    */

    public function pdf(Reporte $reporte)
    {
        $reporte->load([
            'area',
            'usuario',
            'aprobador',
            'detalles.checkItem.infraestructura'
        ]);

        $pdf = Pdf::loadView(
            'reportes.pdf',
            compact('reporte')
        );

        return $pdf->download(
            'reporte-preoperacional-'
                . $reporte->id_reportes
                . '.pdf'
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

        $pendientes = $borradores;

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
        $validated = $request->validate([
            'inspector_calidad' => [
                'nullable',
                'string',
                'max:255'
            ],

            'firma_inspector' => [
                'nullable',
                'string'
            ],

            'verificador_calidad' => [
                'nullable',
                'string',
                'max:255'
            ],

            'firma_verificador' => [
                'nullable',
                'string'
            ],
        ]);

        $reporte->update(
            $validated
        );

        return redirect()
            ->route(
                'reportes.show',
                $reporte
            )
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
        $hoy = now()->toDateString();

        $reporteCaliente =
            Reporte::whereDate(
                'fecha',
                $hoy
            )
            ->whereHas(
                'area',
                fn($q) =>
                $q->where(
                    'nombre',
                    'like',
                    '%Caliente%'
                )
            )
            ->where(
                'estado',
                '!=',
                'rechazado'
            )
            ->exists();

        $reporteFrio =
            Reporte::whereDate(
                'fecha',
                $hoy
            )
            ->whereHas(
                'area',
                fn($q) =>
                $q->where(
                    'nombre',
                    'like',
                    '%Fría%'
                )
                    ->orWhere(
                        'nombre',
                        'like',
                        '%Fria%'
                    )
            )
            ->where(
                'estado',
                '!=',
                'rechazado'
            )
            ->exists();

        $reportes = Reporte::with('area')
            ->where(
                'id_users',
                Auth::id()
            )
            ->where(
                'estado',
                '!=',
                'rechazado'
            )
            ->orderBy(
                'fecha',
                'desc'
            )
            ->get();

        $aprobados = Reporte::where(
            'id_users',
            Auth::id()
        )
            ->where(
                'estado',
                'aprobado'
            )
            ->count();

        $rechazados = Reporte::where(
            'id_users',
            Auth::id()
        )
            ->where(
                'estado',
                'rechazado'
            )
            ->count();

        $borradores = Reporte::where(
            'id_users',
            Auth::id()
        )
            ->where(
                'estado',
                'borrador'
            )
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
