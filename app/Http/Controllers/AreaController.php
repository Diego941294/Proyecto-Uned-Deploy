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
        | Desactivar área
        |--------------------------------------------------------------------------
        |
        | No se elimina físicamente para conservar las relaciones con
        | infraestructuras, Check Items y reportes históricos.
        |
        */

        $area->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('areas.index')
            ->with(
                'success',
                'Área desactivada correctamente.'
            );
    }


    public function toggleActivo(Area $area)
    {
        /*
        |--------------------------------------------------------------------------
        | Activar / Desactivar área
        |--------------------------------------------------------------------------
        */

        $area->update([
            'activo' => !$area->activo,
        ]);

        return redirect()
            ->route('areas.index')
            ->with(
                'success',
                $area->activo
                    ? 'Área activada correctamente.'
                    : 'Área desactivada correctamente.'
            );
    }
}