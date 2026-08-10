<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraestructura extends Model
{
    protected $primaryKey = 'id_infraestructuras';

    protected $fillable = [
        'id_areas',
        'nombre',
        'codigo',
        'activo',
    ];

    public function area()
    {
        return $this->belongsTo(
            Area::class,
            'id_areas',
            'id_areas'
        );
    }

    public function checkItems()
    {
        return $this->hasMany(
            CheckItem::class,
            'id_infraestructuras',
            'id_infraestructuras'
        );
    }
}