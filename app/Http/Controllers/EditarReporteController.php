<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Area;
use Illuminate\Http\Request;

class EditarReporteController extends Controller
{
    /**
     * Método actual: mostrar reportes del día en estado "Borrador"
     * Vista: supervisor.edit_supervisor
     */
    public function editHoy()
    {
        // Fecha de hoy como objeto Carbon
        $hoy = \Carbon\Carbon::today();

        // Reportes del día actual en estado "Borrador"
        $reportes = Reporte::with(['area','usuario'])
            ->whereDate('fecha', $hoy)
            ->whereRaw('LOWER(estado) = ?', ['borrador'])
            ->get();

        // Pasar los reportes a la vista del supervisor
       return redirect()->route('supervisor.dashboard');

    }

    /**
     * Nuevo: mostrar formulario de edición de un reporte específico
     * Vista: supervisor.reporte_edit
     */
    public function edit(Reporte $reporte)
    {
        $areas = Area::all();
        return view('supervisor.reporte_edit', compact('reporte', 'areas'));
    }

    /**
     * Nuevo: guardar cambios en el reporte editado
     */
    public function update(Request $request, Reporte $reporte)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'fecha' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        // Actualiza los datos principales
        $reporte->update($request->only('area_id', 'fecha', 'observaciones'));

        // Actualiza los detalles (checklist)
        if ($request->has('detalles')) {
            foreach ($request->detalles as $itemId => $detalle) {
                $reporte->detalles()->updateOrCreate(
                    ['check_item_id' => $itemId],
                    [
                        'estado' => $detalle['estado'] ?? null,
                        'observacion' => $detalle['observacion'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('supervisor.edit_supervisor')
                         ->with('success', 'Reporte actualizado correctamente');
    }
}

