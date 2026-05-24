<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ReportesExport;
use App\Exports\ReporteDetalleExport;
use Maatwebsite\Excel\Facades\Excel;


class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Reporte::with([
            'area',
            'usuario'
        ]);

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $reportes = $query
            ->latest()
            ->get();

        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('reportes.index', compact('reportes', 'areas'));
    }

    public function create()
    {
        $areas = Area::where('activo', true)
            ->with(['checkItems' => function ($query) {
                $query->where('activo', true)
                    ->orderBy('seccion')
                    ->orderBy('orden');
            }])
            ->orderBy('nombre')
            ->get();

        return view('reportes.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'fecha' => ['required', 'date'],
            'observaciones' => ['nullable', 'string'],
            'detalles' => ['required', 'array'],
        ]);

        $reporte = Reporte::create([
            'user_id' => Auth::id(),
            'area_id' => $validated['area_id'],
            'fecha' => $validated['fecha'],
            'semana' => now()->weekOfYear,
            'estado' => 'borrador',
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        foreach ($validated['detalles'] as $checkItemId => $detalle) {
            $reporte->detalles()->create([
                'check_item_id' => $checkItemId,
                'estado' => $detalle['estado'],
                'observacion' => $detalle['observacion'] ?? null,
            ]);
        }

        return redirect()
            ->route('reportes.index')
            ->with('success', 'Reporte creado.');
    }

    public function show(Reporte $reporte)
    {
        $reporte->load([
            'area',
            'usuario',
            'detalles.checkItem'
        ]);

        return view('reportes.show', compact('reporte'));
    }
    public function pdfGeneral()
    {
        $reportes = Reporte::with(['area', 'usuario'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('reportes.pdf-general', compact('reportes'));

        return $pdf->download('reportes-preoperacionales.pdf');
    }


    public function edit(Reporte $reporte)
    {
        //
    }

    public function update(Request $request, Reporte $reporte)
    {
        //
    }

    public function destroy(Reporte $reporte)
    {
        //
    }

    public function aprobar(Reporte $reporte)
    {
        $reporte->update([
            'estado' => 'aprobado',
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Reporte aprobado.');
    }

    public function rechazar(Reporte $reporte)
    {
        $reporte->update([
            'estado' => 'rechazado',
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Reporte rechazado.');
    }

    public function excel()
    {
        return Excel::download(
            new ReportesExport,
            'reportes.xlsx'
        );
    }

    public function excelDetalle(Reporte $reporte)
    {
        return Excel::download(
            new ReporteDetalleExport($reporte),
            'reporte-' . $reporte->id . '.xlsx'
        );
    }
    public function pdf(Reporte $reporte)
    {
        $reporte->load([
            'area',
            'usuario',
            'detalles.checkItem'
        ]);

        $pdf = Pdf::loadView('reportes.pdf', compact('reporte'));

        return $pdf->download('reporte-preoperacional-' . $reporte->id . '.pdf');
    }

    public function dashboardAdmin()
    {
        $totalReportes = Reporte::count();

        $aprobados = Reporte::where(
            'estado',
            'aprobado'
        )->count();

        $rechazados = Reporte::where(
            'estado',
            'rechazado'
        )->count();

        $borradores = Reporte::where(
            'estado',
            'borrador'
        )->count();

        return view(
            'dashboard.administrador',
            compact(
                'totalReportes',
                'aprobados',
                'rechazados',
                'borradores'
            )
        );
    }
}
