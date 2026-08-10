<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Area;
use Illuminate\Http\Request;

class EditarReporteController extends Controller
{
    /**
     * Mostrar reportes del día en estado borrador.
     */
    public function editHoy()
    {
        $hoy = \Carbon\Carbon::today();

        $reportes = Reporte::with([
            'area',
            'usuario'
        ])
            ->whereDate('fecha', $hoy)
            ->whereRaw('LOWER(estado) = ?', ['borrador'])
            ->get();

        return redirect()
            ->route('supervisor.dashboard');
    }

    /**
     * Mostrar formulario de edición
     * de un reporte específico.
     */
    public function edit(Reporte $reporte)
    {
        $reporte->load([
            'area',
            'detalles.checkItem.infraestructura'
        ]);

        $areas = Area::all();

        return view(
            'supervisor.reporte_edit',
            compact('reporte', 'areas')
        );
    }

    /**
     * Guardar cambios del reporte.
     */
    public function update(
        Request $request,
        Reporte $reporte
    ) {
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
                'nullable',
                'array'
            ],

            'detalles.*.estado' => [
                'nullable',
                'in:A,NC,NA,NFR'
            ],

            'detalles.*.observacion' => [
                'nullable',
                'string'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Actualizar datos principales
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
        | Actualizar detalles
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['detalles'])) {

            foreach (
                $validated['detalles']
                as $itemId => $detalle
            ) {

                $reporte->detalles()->updateOrCreate(
                    [
                        'id_check_items' => $itemId
                    ],
                    [
                        'estado' =>
                            $detalle['estado'] ?? null,

                        'observacion' =>
                            $detalle['observacion'] ?? null,
                    ]
                );
            }
        }

        return redirect()
            ->route('supervisor.edit_supervisor')
            ->with(
                'success',
                'Reporte actualizado correctamente.'
            );
    }
}