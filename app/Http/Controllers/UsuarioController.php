<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')
            ->orderBy('name')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'name'),
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $usuario = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(
                    $validated['password']
                ),
            ]);

            // El nuevo usuario queda habilitado.
            // Se asigna el estado explícitamente para no
            // depender de que "activo" esté en $fillable.
            $usuario->activo = true;
            $usuario->save();

            // Cada usuario tiene un único rol.
            $usuario->assignRole($validated['role']);
        });

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario creado correctamente.'
            );
    }

    public function edit(User $usuario)
    {
        $roles = Role::orderBy('name')->get();

        return view(
            'usuarios.edit',
            compact('usuario', 'roles')
        );
    }

    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore(
                        $usuario->getKey(),
                        $usuario->getKeyName()
                    ),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'name'),
            ],
        ]);

        DB::transaction(function () use (
            $usuario,
            $validated
        ) {
            // Bloquea las filas de los superadministradores
            // durante la comprobación y actualización.
            $superAdminsActivos = User::role(
                'Super Administrador'
            )
                ->where('activo', true)
                ->lockForUpdate()
                ->get();

            $esSuperAdminActivo =
                (bool) $usuario->activo &&
                $usuario->hasRole('Super Administrador');

            $quitaRolSuperAdmin =
                $validated['role'] !==
                'Super Administrador';

            if (
                $esSuperAdminActivo &&
                $quitaRolSuperAdmin &&
                $superAdminsActivos->count() <= 1
            ) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'role' =>
                        'No puede quitar el rol al último Super Administrador activo.',
                ]);
            }

            $usuario->name = $validated['name'];
            $usuario->email = $validated['email'];

            if (!empty($validated['password'])) {
                $usuario->password = Hash::make(
                    $validated['password']
                );
            }

            $usuario->save();

            // Solo se modifica el rol cuando se edita
            // expresamente el usuario, nunca al deshabilitarlo.
            $usuario->syncRoles([
                $validated['role'],
            ]);
        });

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario actualizado correctamente.'
            );
    }

    /**
     * Deshabilita al usuario sin eliminarlo
     * ni quitarle su rol.
     */
    public function destroy(User $usuario)
    {
        if (
            (string) Auth::id() ===
            (string) $usuario->getKey()
        ) {
            return back()->with(
                'error',
                'No puede deshabilitar su propia cuenta.'
            );
        }

        if (!$usuario->activo) {
            return back()->with(
                'error',
                'Este usuario ya está deshabilitado.'
            );
        }

        DB::transaction(function () use ($usuario) {
            // Bloquea la cuenta que se va a modificar.
            $usuario = User::query()
                ->lockForUpdate()
                ->findOrFail($usuario->getKey());

            if (!$usuario->activo) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'usuario' =>
                        'Este usuario ya está deshabilitado.',
                ]);
            }

            if ($usuario->hasRole('Super Administrador')) {
                $superAdminsActivos = User::role(
                    'Super Administrador'
                )
                    ->where('activo', true)
                    ->lockForUpdate()
                    ->get();

                if ($superAdminsActivos->count() <= 1) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'usuario' =>
                            'No puede deshabilitar al último Super Administrador activo.',
                    ]);
                }
            }

            // No se elimina el usuario.
            // No se modifica model_has_roles.
            $usuario->activo = false;
            $usuario->save();
        });

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario deshabilitado.'
            );
    }

    /**
     * Reactiva la cuenta y conserva
     * el rol que tenía asignado.
     */
    public function habilitar(User $usuario)
    {
        if ($usuario->activo) {
            return back()->with(
                'error',
                'Este usuario ya está habilitado.'
            );
        }

        $usuario->activo = true;
        $usuario->save();

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                'Usuario habilitado correctamente. Conserva su rol anterior.'
            );
    }
}