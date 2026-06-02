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

   protected $fillable = [
    'user_id',
    'area_id',
    'fecha',
    'estado',
    'observaciones',
    'aprobado_por',
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function detalles()
    {
        return $this->hasMany(ReporteDetalle::class);
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
}
