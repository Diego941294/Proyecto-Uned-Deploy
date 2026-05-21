<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\ReporteDetalle;

class CheckItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'seccion',
        'nombre',
        'orden',
        'activo',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function reporteDetalles()
    {
        return $this->hasMany(ReporteDetalle::class);
    }

    public function detalles()
{
    return $this->hasMany(ReporteDetalle::class);
}
}