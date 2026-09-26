<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CheckItem;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EditarReporteController extends Controller
{
    /**
     * Redirigir al dashboard del supervisor.
     *
     * El dashboard debe mostrar únicamente los borradores
     * disponibles para edición. Los reportes rechazados
     * son definitivos y no se pueden modificar.
     */
    public function editHoy()
    {
        return redirect()
            ->route('supervisor.dashboard');
    }

    /**
     * Mostrar el formulario de edición de un reporte.
     */
    public function edit(Reporte $reporte)
    {
        // Solo el propietario puede editar el reporte.

        if ((string) $reporte->id_users !== (string) Auth::id()) {
            return redirect()
                ->route('supervisor.dashboard')
                ->with(
                    'warning',
                    'No puedes editar este reporte porque pertenece a otro usuario.'
                );
        }

        // Únicamente se pueden editar borradores.
        if ($reporte->estado !== 'borrador') {
            return redirect()
                ->route('supervisor.dashboard')
                ->with(
                    'warning',
                    'Este reporte no se puede editar porque ya fue enviado, aprobado o rechazado. Solo se pueden modificar reportes en estado borrador.'
                );
        }

        $reporte->load([
            'area',
            'detalles.checkItem.infraestructura',
        ]);

        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'supervisor.reporte_edit',
            compact('reporte', 'areas')
        );
    }

    /**
     * Guardar los cambios de un reporte en estado borrador.
     */
    public function update(
        Request $request,
        Reporte $reporte
    ) {
        /*
        |--------------------------------------------------------------------------
        | 1. VERIFICAR PROPIETARIO Y ESTADO
        |--------------------------------------------------------------------------
        */

        if ((string) $reporte->id_users !== (string) Auth::id()) {
            abort(
                403,
                'No tiene permiso para modificar este reporte.'
            );
        }

        if ($reporte->estado !== 'borrador') {
            abort(
                403,
                'Este reporte ya no se puede modificar.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. VALIDAR LOS DATOS RECIBIDOS
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'id_areas' => [
                'required',
                'exists:areas,id_areas',
            ],

            'fecha' => [
                'required',
                'date',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],

            'detalles' => [
                'nullable',
                'array',
            ],

            'detalles.*.estado' => [
                'required',
                'in:A,NC,NA,NFR',
            ],

            'detalles.*.observacion' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. VALIDAR QUE LOS CHECK ITEMS PERTENEZCAN AL ÁREA
        |--------------------------------------------------------------------------
        */

        $detalles = $validated['detalles'] ?? [];

        $checkItemIds = array_keys($detalles);

        if (!empty($checkItemIds)) {
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

            if ($cantidadItemsValidos !== count($checkItemIds)) {
                throw ValidationException::withMessages([
                    'detalles' =>
                    'Uno o más elementos seleccionados no pertenecen al área indicada.',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. ACTUALIZAR EL REPORTE DENTRO DE UNA TRANSACCIÓN
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $reporte,
            $validated,
            $detalles
        ) {
            // Bloquear el reporte mientras se actualiza.
            $reporte = Reporte::query()
                ->whereKey($reporte->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | COMPROBAR NUEVAMENTE LOS PERMISOS
            |--------------------------------------------------------------------------
            */

            if ((string) $reporte->id_users !== (string) Auth::id()) {
                abort(
                    403,
                    'No tiene permiso para modificar este reporte.'
                );
            }

            if ($reporte->estado !== 'borrador') {
                abort(
                    403,
                    'Este reporte ya no se puede modificar.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR DATOS PRINCIPALES
            |--------------------------------------------------------------------------
            */

            $reporte->update([
                'id_areas' => $validated['id_areas'],

                'fecha' => $validated['fecha'],

                'observaciones' =>
                $validated['observaciones'] ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR LOS DETALLES
            |--------------------------------------------------------------------------
            */

            foreach ($detalles as $itemId => $detalle) {
                $reporte->detalles()->updateOrCreate(
                    [
                        'id_check_items' => $itemId,
                    ],
                    [
                        'estado' => $detalle['estado'],

                        'observacion' =>
                        $detalle['observacion'] ?? null,
                    ]
                );
            }
        });

        /*
        |--------------------------------------------------------------------------
        | 5. CONFIRMAR LA ACTUALIZACIÓN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('supervisor.edit_supervisor')
            ->with(
                'success',
                'Reporte actualizado correctamente.'
            );
    }
}
