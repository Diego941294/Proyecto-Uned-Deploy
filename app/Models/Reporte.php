<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\ReporteDetalle;
use App\Models\User;

class Reporte extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_reportes';

    protected $fillable = [
        'id_users',
        'id_areas',
        'fecha',
        'semana',
        'estado',
        'observaciones',
        'id_usuario_aprobador',
        'fecha_aprobacion',
        'inspector_calidad',
        'firma_inspector',
        'verificador_calidad',
        'firma_verificador',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_aprobacion' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'id_users',
            'id_users'
        );
    }

    public function area()
    {
        return $this->belongsTo(
            Area::class,
            'id_areas',
            'id_areas'
        );
    }

    public function detalles()
    {
        return $this->hasMany(
            ReporteDetalle::class,
            'id_reportes',
            'id_reportes'
        );
    }
    public function accionesCorrectivas()
{
    return $this->hasMany(
        ReporteAccionCorrectiva::class,
        'id_reportes',
        'id_reportes'
    );
}

    public function aprobador()
    {
        return $this->belongsTo(
            User::class,
            'id_usuario_aprobador',
            'id_users'
        );
    }
}