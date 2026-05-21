<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('id')->get();

        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:areas,nombre'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['required', 'boolean'],
        ]);

        Area::create($validated);

        return redirect()
            ->route('areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:areas,nombre,' . $area->id],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['required', 'boolean'],
        ]);

        $area->update($validated);

        return redirect()
            ->route('areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        if ($area->checkItems()->exists()) {

            return back()->with(
                'error',
                'No se puede eliminar un área que tiene Check Items asociados.'
            );
        }

        $area->delete();

        return redirect()
            ->route('areas.index')
            ->with(
                'success',
                'Área eliminada correctamente.'
            );
    }
}
