<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('id_areas')->get();

        return view('areas.index', compact('areas'));
    }


    public function create()
    {
        return view('areas.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:areas,nombre'
            ],

            'descripcion' => [
                'nullable',
                'string'
            ],

            'activo' => [
                'required',
                'boolean'
            ],
        ]);

        Area::create($validated);

        return redirect()
            ->route('areas.index')
            ->with(
                'success',
                'Área creada correctamente.'
            );
    }


    public function edit(Area $area)
    {
        return view(
            'areas.edit',
            compact('area')
        );
    }


    public function update(
        Request $request,
        Area $area
    ) {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:areas,nombre,' .
                $area->id_areas .
                ',id_areas'
            ],

            'descripcion' => [
                'nullable',
                'string'
            ],

            'activo' => [
                'required',
                'boolean'
            ],
        ]);

        $area->update($validated);

        return redirect()
            ->route('areas.index')
            ->with(
                'success',
                'Área actualizada correctamente.'
            );
    }


    public function destroy(Area $area)
    {
        /*
        |--------------------------------------------------------------------------
        | Verificar Check Items asociados
        |--------------------------------------------------------------------------
        |
        | El área ya no tiene Check Items directamente.
        |
        | Área
        |   ↓
        | Infraestructura
        |   ↓
        | Check Items
        |
        */

        $tieneCheckItems = $area
            ->infraestructuras()
            ->whereHas('checkItems')
            ->exists();

        if ($tieneCheckItems) {
            return redirect()
                ->route('areas.index')
                ->with(
                    'error',
                    'No se puede eliminar esta área porque tiene Check Items asociados mediante sus infraestructuras.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Verificar reportes asociados
        |--------------------------------------------------------------------------
        */

        if ($area->reportes()->exists()) {
            return redirect()
                ->route('areas.index')
                ->with(
                    'error',
                    'No se puede eliminar esta área porque tiene reportes asociados.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Verificar infraestructuras asociadas
        |--------------------------------------------------------------------------
        */

        if ($area->infraestructuras()->exists()) {
            return redirect()
                ->route('areas.index')
                ->with(
                    'error',
                    'No se puede eliminar esta área porque tiene infraestructuras asociadas.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Eliminar área
        |--------------------------------------------------------------------------
        */

        $area->delete();

        return redirect()
            ->route('areas.index')
            ->with(
                'success',
                'Área eliminada correctamente.'
            );
    }
}