<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporte_id',
        'check_item_id',
        'estado',
        'observacion',
    ];

    public function reporte()
    {
        return $this->belongsTo(Reporte::class);
    }

    public function checkItem()
    {
        return $this->belongsTo(CheckItem::class);
    }
}