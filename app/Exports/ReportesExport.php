<?php

namespace App\Exports;

use App\Models\Reporte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Reporte::with([
            'area',
            'usuario'
        ])
        ->get()
        ->map(function ($reporte) {

            return [

                'ID' => $reporte->id_reportes,

                'Área' => $reporte->area?->nombre,

                'Fecha' => $reporte->fecha?->format('d/m/Y'),

                'Estado' => ucfirst($reporte->estado),

                'Supervisor' => $reporte->usuario?->name,

                'Observaciones' => $reporte->observaciones
                    ?? 'Sin observaciones',

            ];
        });
    }

    public function headings(): array
    {
        return [

            'ID',
            'Área',
            'Fecha',
            'Estado',
            'Supervisor',
            'Observaciones'

        ];
    }
}