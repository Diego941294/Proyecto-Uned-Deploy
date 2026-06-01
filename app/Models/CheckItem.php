<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'infraestructura_id',
        'seccion',
        'nombre',
        'orden',
        'activo',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function infraestructura()
    {
        return $this->belongsTo(Infraestructura::class);
    }

    public function detalles()
    {
        return $this->hasMany(ReporteDetalle::class);
    }
}