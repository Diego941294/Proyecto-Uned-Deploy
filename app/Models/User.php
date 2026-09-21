<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Services\GmailService;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'id_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'firma',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reportes()
    {
        return $this->hasMany(
            Reporte::class,
            'id_users',
            'id_users'
        );
    }

    public function reportesAprobados()
    {
        return $this->hasMany(
            Reporte::class,
            'id_usuario_aprobador',
            'id_users'
        );
    }

    public function historialEstados()
    {
        return $this->hasMany(
            ReporteHistorialEstado::class,
            'id_users',
            'id_users'
        );
    }

    public function sendPasswordResetNotification($token): void
{
    $url = url(route('password.reset', [
        'token' => $token,
        'email' => $this->getEmailForPasswordReset(),
    ], false));

    $html = view('emails.recuperar-contrasena', [
        'url' => $url,
    ])->render();

    app(GmailService::class)->send(
        $this->getEmailForPasswordReset(),
        'Recuperación de contraseña - Guana Pollo',
        $html
    );
}
}
