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

        return redirect()
            ->route('check-items.index')
            ->with('success', 'Check Item actualizado correctamente.');
    }

    public function destroy(CheckItem $checkItem)
    {
        $checkItem->update([
            'activo' => !$checkItem->activo
        ]);

        return redirect()
            ->route('check-items.index')
            ->with('success', 'Estado del Check Item actualizado.');
    }
}