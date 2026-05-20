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
            'detalles.checkItem'
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
            ['Sección', 'Elemento', 'Estado', 'Observación']

        ];

        foreach ($this->reporte->detalles as $detalle) {

            $rows[] = [

                $detalle->checkItem?->seccion,
                $detalle->checkItem?->nombre,
                $detalle->estado,
                $detalle->observacion

            ];
        }

        $rows[] = [];
        $rows[] = ['OBSERVACIONES GENERALES'];
        $rows[] = [$this->reporte->observaciones];

        return $rows;
    }
}