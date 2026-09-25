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
            ->orderBy('id_areas')
            ->orderBy('nombre')
            ->get();

        return view(
            'infraestructuras.index',
            compact('infraestructuras')
        );
    }


    public function create()
    {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $ultimo = Infraestructura::whereNotNull('codigo')
            ->orderBy('id_infraestructuras', 'desc')
            ->first();

        $siguienteNumero = 1;

        if (
            $ultimo &&
            preg_match(
                '/INF-(\d+)/',
                $ultimo->codigo,
                $matches
            )
        ) {
            $siguienteNumero =
                ((int) $matches[1]) + 1;
        }

        $codigoSugerido =
            'INF-' .
            str_pad(
                $siguienteNumero,
                2,
                '0',
                STR_PAD_LEFT
            );

        return view(
            'infraestructuras.create',
            compact(
                'areas',
                'codigoSugerido'
            )
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_areas' => [
                'required',
                'exists:areas,id_areas'
            ],

            'nombre' => [
                'required',
                'string',
                'max:255'
            ],

            'activo' => [
                'required',
                'boolean'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generar código automático
        |--------------------------------------------------------------------------
        */

       $ultimo = Infraestructura::whereNotNull('codigo')
    ->orderBy('id_infraestructuras', 'desc')
    ->first();

        $siguienteNumero = 1;

        if (
            $ultimo &&
            preg_match(
                '/INF-(\d+)/',
                $ultimo->codigo,
                $matches
            )
        ) {
            $siguienteNumero =
                ((int) $matches[1]) + 1;
        }

        $validated['codigo'] =
            'INF-' .
            str_pad(
                $siguienteNumero,
                2,
                '0',
                STR_PAD_LEFT
            );


        /*
        |--------------------------------------------------------------------------
        | Evitar duplicados por área
        |--------------------------------------------------------------------------
        */

        $existe = Infraestructura::where(
            'id_areas',
            $validated['id_areas']
        )
            ->where(
                'nombre',
                $validated['nombre']
            )
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ya existe una infraestructura/sección con ese nombre para el área seleccionada.'
                );
        }


        Infraestructura::create($validated);

        return redirect()
            ->route('infraestructuras.index')
            ->with(
                'success',
                'Infraestructura creada correctamente.'
            );
    }


    public function edit(
        Infraestructura $infraestructura
    ) {
        $areas = Area::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view(
            'infraestructuras.edit',
            compact(
                'infraestructura',
                'areas'
            )
        );
    }


    public function update(
        Request $request,
        Infraestructura $infraestructura
    ) {
        $validated = $request->validate([
            'id_areas' => [
                'required',
                'exists:areas,id_areas'
            ],

            'nombre' => [
                'required',
                'string',
                'max:255'
            ],

            'activo' => [
                'required',
                'boolean'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Evitar duplicados
        |--------------------------------------------------------------------------
        */

        $existe = Infraestructura::where(
            'id_areas',
            $validated['id_areas']
        )
            ->where(
                'nombre',
                $validated['nombre']
            )
            ->where(
                'id_infraestructuras',
                '!=',
                $infraestructura->id_infraestructuras
            )
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ya existe otra infraestructura/sección con ese nombre para el área seleccionada.'
                );
        }


        $infraestructura->update(
            $validated
        );

        return redirect()
            ->route('infraestructuras.index')
            ->with(
                'success',
                'Infraestructura actualizada correctamente.'
            );
    }


    public function destroy(
        Infraestructura $infraestructura
    ) {
        /*
        |--------------------------------------------------------------------------
        | Desactivar infraestructura
        |--------------------------------------------------------------------------
        |
        | No se elimina físicamente para conservar los registros históricos
        | y las relaciones con los Check Items existentes.
        |
        */

        $infraestructura->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('infraestructuras.index')
            ->with(
                'success',
                'Infraestructura desactivada correctamente.'
            );
    }


    public function toggleActivo(
        Infraestructura $infraestructura
    ) {
        /*
        |--------------------------------------------------------------------------
        | Activar / Desactivar infraestructura
        |--------------------------------------------------------------------------
        */

        $infraestructura->update([
            'activo' => !$infraestructura->activo,
        ]);


        return redirect()
            ->route('infraestructuras.index')
            ->with(
                'success',
                $infraestructura->activo
                    ? 'Infraestructura activada correctamente.'
                    : 'Infraestructura desactivada correctamente.'
            );
    }
}