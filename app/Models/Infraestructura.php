<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infraestructura extends Model
{
    protected $fillable = [
        'area_id',
        'nombre',
        'codigo',
        'activo',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function checkItems()
    {
        return $this->hasMany(CheckItem::class);
    }
}
