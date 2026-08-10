<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteDetalle extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_reporte_detalles';

    protected $fillable = [
        'id_reportes',
        'id_check_items',
        'estado',
        'observacion',
    ];

    public function reporte()
    {
        return $this->belongsTo(
            Reporte::class,
            'id_reportes',
            'id_reportes'
        );
    }

    public function checkItem()
    {
        return $this->belongsTo(
            CheckItem::class,
            'id_check_items',
            'id_check_items'
        );
    }
}