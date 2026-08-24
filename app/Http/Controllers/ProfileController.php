<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Evitar asignar archivos directamente con fill()
        |--------------------------------------------------------------------------
        */

        unset(
            $validated['photo'],
            $validated['firma']
        );

        $user->fill($validated);


        /*
        |--------------------------------------------------------------------------
        | FOTO DE PERFIL
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')
                    ->delete($user->photo);
            }

            $photoPath = $request
                ->file('photo')
                ->store(
                    'perfiles',
                    'public'
                );

            $user->photo = $photoPath;
        }


        /*
        |--------------------------------------------------------------------------
        | FIRMA
        |--------------------------------------------------------------------------
        |
        | La imagen se almacena como archivo.
        | En la base de datos únicamente se guarda la ruta.
        |
        */

        if ($request->hasFile('firma')) {

            if ($user->firma) {
                Storage::disk('public')
                    ->delete($user->firma);
            }

            $firmaPath = $request
                ->file('firma')
                ->store(
                    'firmas',
                    'public'
                );

            $user->firma = $firmaPath;
        }


        /*
        |--------------------------------------------------------------------------
        | EMAIL
        |--------------------------------------------------------------------------
        */

 

        $user->save();


        return Redirect::route('profile.edit')
            ->with(
                'status',
                'profile-updated'
            )
            ->with(
                'success',
                'Perfil actualizado correctamente.'
            );
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        abort(
            403,
            'No está permitido eliminar la cuenta desde el perfil.'
        );
    }
}