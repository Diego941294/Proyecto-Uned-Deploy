<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteHistorialEstado extends Model
{
    protected $table = 'reporte_historial_estados';

    protected $primaryKey = 'id_reporte_historial_estados';

    protected $fillable = [
        'id_reportes',
        'id_users',
        'estado_anterior',
        'estado_nuevo',
        'comentario',
    ];

    public function reporte()
    {
        return $this->belongsTo(
            Reporte::class,
            'id_reportes',
            'id_reportes'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            User::class,
            'id_users',
            'id_users'
        );
    }
}