<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteNoConformidad extends Model
{
    protected $fillable = [
        'reporte_id',
        'fecha',
        'referencia',
        'causa_raiz',
        'hora_causa',
        'accion_correctiva',
        'hora_accion',
        'verificacion',
        'coordinador_area',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_causa' => 'datetime:H:i',
        'hora_accion' => 'datetime:H:i',
    ];

    public function reporte()
    {
        return $this->belongsTo(Reporte::class);
    }
}