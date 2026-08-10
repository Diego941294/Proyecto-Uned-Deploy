<?php

namespace App\Http\Controllers;

use App\Models\CheckItem;
use App\Models\Infraestructura;
use Illuminate\Http\Request;

class CheckItemController extends Controller
{
    public function index()
    {
        $checkItems = CheckItem::with('infraestructura.area')
            ->orderBy('id_infraestructuras')
            ->orderBy('orden')
            ->get();

        return view('check-items.index', compact('checkItems'));
    }

    public function create()
    {
        $infraestructuras = Infraestructura::with('area')
            ->where('activo', true)
            ->whereHas('area', function ($query) {
                $query->where('activo', true);
            })
            ->orderBy('id_areas')
            ->orderBy('nombre')
            ->get();

        return view(
            'check-items.create',
            compact('infraestructuras')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_infraestructuras' => [
                'required',
                'exists:infraestructuras,id_infraestructuras'
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

        $existe = CheckItem::where(
            'id_infraestructuras',
            $validated['id_infraestructuras']
        )
            ->where('nombre', $validated['nombre'])
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ya existe un Check Item con ese nombre dentro de la infraestructura seleccionada.'
                );
        }

        $ultimoOrden = CheckItem::where(
            'id_infraestructuras',
            $validated['id_infraestructuras']
        )->max('orden');

        $validated['orden'] = ($ultimoOrden ?? 0) + 1;

        CheckItem::create($validated);

        return redirect()
            ->route('check-items.index')
            ->with(
                'success',
                'Check Item creado correctamente.'
            );
    }

    public function edit(CheckItem $checkItem)
    {
        $infraestructuras = Infraestructura::with('area')
            ->where('activo', true)
            ->whereHas('area', function ($query) {
                $query->where('activo', true);
            })
            ->orderBy('id_areas')
            ->orderBy('nombre')
            ->get();

        return view(
            'check-items.edit',
            compact('checkItem', 'infraestructuras')
        );
    }

    public function update(
        Request $request,
        CheckItem $checkItem
    ) {
        $validated = $request->validate([
            'id_infraestructuras' => [
                'required',
                'exists:infraestructuras,id_infraestructuras'
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

        $existe = CheckItem::where(
            'id_infraestructuras',
            $validated['id_infraestructuras']
        )
            ->where('nombre', $validated['nombre'])
            ->where(
                'id_check_items',
                '!=',
                $checkItem->id_check_items
            )
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ya existe otro Check Item con ese nombre dentro de la infraestructura seleccionada.'
                );
        }

        $checkItem->update($validated);

        return redirect()
            ->route('check-items.index')
            ->with(
                'success',
                'Check Item actualizado correctamente.'
            );
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
            ->with(
                'success',
                'Check Item eliminado correctamente.'
            );
    }
}