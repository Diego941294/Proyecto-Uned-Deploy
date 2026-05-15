<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function index()
    {
        $reportes = Reporte::with([
                'area',
                'usuario'
            ])
            ->latest()
            ->get();

        return view('reportes.index', compact('reportes'));
    }

    public function create()
    {
        $areas = Area::where('activo', true)
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
        ]);

        Reporte::create([
            'user_id' => Auth::id(),
            'area_id' => $validated['area_id'],
            'fecha' => $validated['fecha'],
            'semana' => now()->weekOfYear,
            'estado' => 'borrador',
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        return redirect()
            ->route('reportes.index')
            ->with('success', 'Reporte creado correctamente.');
    }

    public function show(Reporte $reporte)
    {
        //
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
}