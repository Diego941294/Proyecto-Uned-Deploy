<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteAccionCorrectiva extends Model
{
    protected $table = 'reporte_accion_correctiva';

    protected $primaryKey = 'id_reporte_accion_correctiva';

    protected $fillable = [
        'id_reportes',
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
        return $this->belongsTo(
            Reporte::class,
            'id_reportes',
            'id_reportes'
        );
    }
}