<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteSnapshot extends Model
{
    protected $table = 'reporte_snapshots';

    protected $primaryKey = 'id_reporte_snapshots';

    protected $fillable = [
        'id_reportes',
        'estado_final',
        'datos',
        'fecha_snapshot',
    ];

    protected $casts = [
        'datos' => 'array',
        'fecha_snapshot' => 'datetime',
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