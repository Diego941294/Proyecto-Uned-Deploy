<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function checkItems()
    {
        return $this->hasMany(CheckItem::class);
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}