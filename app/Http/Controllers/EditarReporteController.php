<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;

class EditarReporteController extends Controller
{
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
        return view('supervisor.edit_supervisor', compact('reportes'));
    }
}
