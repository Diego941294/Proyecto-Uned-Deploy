<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CheckItem;
use App\Models\Infraestructura;
use Illuminate\Http\Request;

class CheckItemController extends Controller
{
    public function index()
    {
        $checkItems = CheckItem::with(['area', 'infraestructura'])
            ->orderBy('area_id')
            ->orderBy('infraestructura_id')
            ->orderBy('orden')
            ->get();

        return view('check-items.index', compact('checkItems'));
    }

    public function create()
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $infraestructuras = Infraestructura::with('area')
            ->where('activo', true)
            ->orderBy('area_id')
            ->orderBy('nombre')
            ->get();

        return view('check-items.create', compact('areas', 'infraestructuras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'infraestructura_id' => ['required', 'exists:infraestructuras,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'orden' => ['required', 'integer'],
            'activo' => ['required', 'boolean'],
        ]);

        $infraestructura = Infraestructura::findOrFail($validated['infraestructura_id']);

        if ($infraestructura->area_id != $validated['area_id']) {
            return back()
                ->withInput()
                ->with('error', 'La infraestructura seleccionada no pertenece al área indicada.');
        }

        $validated['seccion'] = $infraestructura->nombre;

        $existe = CheckItem::where('area_id', $validated['area_id'])
            ->where('infraestructura_id', $validated['infraestructura_id'])
            ->where('nombre', $validated['nombre'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe un Check Item con la misma área, infraestructura y nombre.');
        }

        CheckItem::create($validated);

        return redirect()
            ->route('check-items.index')
            ->with('success', 'Check Item creado correctamente.');
    }

    public function edit(CheckItem $checkItem)
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $infraestructuras = Infraestructura::with('area')
            ->where('activo', true)
            ->orderBy('area_id')
            ->orderBy('nombre')
            ->get();

        return view('check-items.edit', compact('checkItem', 'areas', 'infraestructuras'));
    }

    public function update(Request $request, CheckItem $checkItem)
    {
        $validated = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'infraestructura_id' => ['required', 'exists:infraestructuras,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'orden' => ['required', 'integer'],
            'activo' => ['required', 'boolean'],
        ]);

        $infraestructura = Infraestructura::findOrFail($validated['infraestructura_id']);

        if ($infraestructura->area_id != $validated['area_id']) {
            return back()
                ->withInput()
                ->with('error', 'La infraestructura seleccionada no pertenece al área indicada.');
        }

        $validated['seccion'] = $infraestructura->nombre;

        $existe = CheckItem::where('area_id', $validated['area_id'])
            ->where('infraestructura_id', $validated['infraestructura_id'])
            ->where('nombre', $validated['nombre'])
            ->where('id', '!=', $checkItem->id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe otro Check Item con la misma área, infraestructura y nombre.');
        }

        $checkItem->update($validated);

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