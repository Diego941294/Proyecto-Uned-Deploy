<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CheckItem;
use Illuminate\Http\Request;

class CheckItemController extends Controller
{
    public function index()
    {
        $checkItems = CheckItem::with('area')
            ->orderBy('area_id')
            ->orderBy('orden')
            ->get();

        return view('check-items.index', compact('checkItems'));
    }

    public function create()
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('check-items.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'seccion' => ['required', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'orden' => ['required', 'integer'],
            'activo' => ['required', 'boolean'],
        ]);

        CheckItem::create($validated);

        $existe = CheckItem::where('area_id', $validated['area_id'])
            ->where('seccion', $validated['seccion'])
            ->where('nombre', $validated['nombre'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe un Check Item con la misma área, sección y nombre.');
        }

        return redirect()
            ->route('check-items.index')
            ->with('success', 'Check Item creado correctamente.');
    }







    public function edit(CheckItem $checkItem)
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('check-items.edit', compact('checkItem', 'areas'));
    }

    public function update(Request $request, CheckItem $checkItem)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'seccion' => ['required', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'orden' => ['required', 'integer'],
            'activo' => ['required', 'boolean'],
        ]);

        $checkItem->update($validated);


        $existe = CheckItem::where('area_id', $validated['area_id'])
            ->where('seccion', $validated['seccion'])
            ->where('nombre', $validated['nombre'])
            ->where('id', '!=', $checkItem->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe otro Check Item con la misma área, sección y nombre.');
        }

        return redirect()
            ->route('check-items.index')
            ->with('success', 'Check Item actualizado correctamente.');
    }

    public function destroy(CheckItem $checkItem)
    {
        if ($checkItem->detalles()->exists()) {
            return redirect()
                ->route('check-items.index')
                ->with(
                    'error',
                    'No se puede eliminar este Check Item porque ya está asociado a uno o más reportes.'
                );
        }

        $checkItem->delete();

        return redirect()
            ->route('check-items.index')
            ->with('success', 'Check Item eliminado correctamente.');
    }
}
