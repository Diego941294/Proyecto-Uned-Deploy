<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_check_items';

    protected $fillable = [
        'id_infraestructuras',
        'nombre',
        'orden',
        'activo',
    ];

    public function infraestructura()
    {
        return $this->belongsTo(
            Infraestructura::class,
            'id_infraestructuras',
            'id_infraestructuras'
        );
    }

    public function detalles()
    {
        return $this->hasMany(
            ReporteDetalle::class,
            'id_check_items',
            'id_check_items'
        );
    }
}