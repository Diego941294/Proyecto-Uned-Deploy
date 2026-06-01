<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Infraestructura;
use Illuminate\Http\Request;

class InfraestructuraController extends Controller
{
    public function index()
    {
        $infraestructuras = Infraestructura::with('area')
            ->orderBy('area_id')
            ->orderBy('nombre')
            ->get();

        return view('infraestructuras.index', compact('infraestructuras'));
    }

    public function create()
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $ultimo = Infraestructura::whereNotNull('codigo')
            ->orderBy('id', 'desc')
            ->first();

        $siguienteNumero = 1;

        if ($ultimo && preg_match('/INF-(\d+)/', $ultimo->codigo, $matches)) {
            $siguienteNumero = ((int) $matches[1]) + 1;
        }

        $codigoSugerido = 'INF-' . str_pad($siguienteNumero, 2, '0', STR_PAD_LEFT);

        return view('infraestructuras.create', compact('areas', 'codigoSugerido'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'codigo' => ['nullable', 'string', 'max:50'],
            'activo' => ['required', 'boolean'],
        ]);

        $ultimo = Infraestructura::where('area_id', $validated['area_id'])
            ->whereNotNull('codigo')
            ->orderBy('id', 'desc')
            ->first();

        $siguienteNumero = 1;

        if ($ultimo && preg_match('/INF-(\d+)/', $ultimo->codigo, $matches)) {
            $siguienteNumero = ((int) $matches[1]) + 1;
        }

        $validated['codigo'] = 'INF-' . str_pad($siguienteNumero, 2, '0', STR_PAD_LEFT);


        $existe = Infraestructura::where('area_id', $validated['area_id'])
            ->where('nombre', $validated['nombre'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe una infraestructura/sección con ese nombre para el área seleccionada.');
        }

        Infraestructura::create($validated);

        return redirect()
            ->route('infraestructuras.index')
            ->with('success', 'Infraestructura creada correctamente.');
    }

    public function edit(Infraestructura $infraestructura)
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('infraestructuras.edit', compact('infraestructura', 'areas'));
    }

    public function update(Request $request, Infraestructura $infraestructura)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'nombre' => ['required', 'string', 'max:255'],

            'activo' => ['required', 'boolean'],
        ]);

        $existe = Infraestructura::where('area_id', $validated['area_id'])
            ->where('nombre', $validated['nombre'])
            ->where('id', '!=', $infraestructura->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe otra infraestructura/sección con ese nombre para el área seleccionada.');
        }

        $infraestructura->update($validated);

        return redirect()
            ->route('infraestructuras.index')
            ->with('success', 'Infraestructura actualizada correctamente.');
    }



    public function destroy(Infraestructura $infraestructura)
    {
        $infraestructura->delete();

        return redirect()
            ->route('infraestructuras.index')
            ->with('success', 'Infraestructura eliminada correctamente.');
    }
}
