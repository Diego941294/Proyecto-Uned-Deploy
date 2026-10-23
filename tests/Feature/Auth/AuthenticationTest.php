<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

 public function test_users_can_authenticate_using_the_login_screen(): void
{
    // Crear un usuario habilitado.
    $user = User::factory()->create([
        'activo' => true,
    ]);

    // Crear el rol si no existe en la base de datos de pruebas.
    \Spatie\Permission\Models\Role::findOrCreate('supervisor', 'web');

    // Asignar el rol al usuario.
    $user->assignRole('supervisor');

    // Intentar iniciar sesión.
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    // Comprobar que el usuario está autenticado.
    $this->assertAuthenticated();

    // Comprobar que se redirige al panel del supervisor.
    $response->assertRedirect(
        route('supervisor.dashboard')
    );
}

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
