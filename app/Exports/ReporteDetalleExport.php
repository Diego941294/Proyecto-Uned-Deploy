<?php

namespace App\Exports;

use App\Models\Reporte;
use Maatwebsite\Excel\Concerns\FromArray;

class ReporteDetalleExport implements FromArray
{
    protected $reporte;

    public function __construct(Reporte $reporte)
    {
        $this->reporte = $reporte;
    }

    public function array(): array
    {
        $this->reporte->load([
            'area',
            'usuario',
            'detalles.checkItem.infraestructura'
        ]);

        $rows = [
            ['REPORTE PREOPERACIONAL'],
            [],
            ['ID', $this->reporte->id],
            ['Área', $this->reporte->area?->nombre],
            ['Fecha', $this->reporte->fecha?->format('d/m/Y')],
            ['Estado', ucfirst($this->reporte->estado)],
            ['Supervisor', $this->reporte->usuario?->name],
            [],
            ['CHECKLIST'],
            ['Infraestructura', 'Elemento', 'Estado', 'Observación']
        ];

        foreach ($this->reporte->detalles as $detalle) {

            $rows[] = [
                $detalle->checkItem?->infraestructura?->nombre
                    ?? 'Sin infraestructura',

                $detalle->checkItem?->nombre
                    ?? 'Elemento no disponible',

                $detalle->estado,

                $detalle->observacion
                    ?? 'Sin observación'
            ];
        }

        $rows[] = [];
        $rows[] = ['OBSERVACIONES GENERALES'];
        $rows[] = [
            $this->reporte->observaciones
                ?? 'Sin observaciones generales.'
        ];

        return $rows;
    }
}