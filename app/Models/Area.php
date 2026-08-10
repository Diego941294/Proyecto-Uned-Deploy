<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_areas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function reportes()
    {
        return $this->hasMany(
            Reporte::class,
            'id_areas',
            'id_areas'
        );
    }

    public function infraestructuras()
    {
        return $this->hasMany(
            Infraestructura::class,
            'id_areas',
            'id_areas'
        );
    }
}