<?php

namespace App\Exports;

use App\Models\Reporte;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteDetalleExport implements FromArray, WithStyles, ShouldAutoSize
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
            'aprobador',
            'detalles.checkItem.infraestructura'
        ]);

        $rows = [

            ['REPORTE PREOPERACIONAL'],
            [],

            ['ID', $this->reporte->id_reportes],

            ['Área', $this->reporte->area?->nombre
                ?? 'Área no disponible'],

            ['Fecha', $this->reporte->fecha?->format('d/m/Y')
                ?? 'No registrada'],

            ['Estado', ucfirst($this->reporte->estado)],

            ['Supervisor', $this->reporte->usuario?->name
                ?? 'No registrado'],

            ['Administrador', $this->reporte->aprobador?->name
                ?? 'Pendiente de revisión'],

            [],

            ['CHECKLIST'],

        ];


        /*
        |--------------------------------------------------------------------------
        | AGRUPAR POR INFRAESTRUCTURA
        |--------------------------------------------------------------------------
        */

        $detallesAgrupados = $this->reporte->detalles->groupBy(
            fn ($detalle) =>
                $detalle->checkItem?->infraestructura?->nombre
                ?? 'Sin infraestructura'
        );


        foreach ($detallesAgrupados as $infraestructura => $detalles) {

            /*
            |--------------------------------------------------------------------------
            | NOMBRE DE LA CATEGORÍA
            |--------------------------------------------------------------------------
            */

            $rows[] = [
                $infraestructura
            ];


            /*
            |--------------------------------------------------------------------------
            | ENCABEZADOS DEL GRUPO
            |--------------------------------------------------------------------------
            */

            $rows[] = [
                'Elemento',
                'Estado',
                'Observación'
            ];


            /*
            |--------------------------------------------------------------------------
            | ELEMENTOS
            |--------------------------------------------------------------------------
            */

            foreach ($detalles as $detalle) {

                $rows[] = [

                    $detalle->checkItem?->nombre
                        ?? 'Elemento no disponible',

                    $detalle->estado,

                    filled($detalle->observacion)
                        ? $detalle->observacion
                        : 'Sin observación',

                ];
            }


            /*
            |--------------------------------------------------------------------------
            | ESPACIO ENTRE CATEGORÍAS
            |--------------------------------------------------------------------------
            */

            $rows[] = [];

        }


        /*
        |--------------------------------------------------------------------------
        | OBSERVACIONES GENERALES
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'OBSERVACIONES GENERALES'
        ];

        $rows[] = [
            $this->reporte->observaciones
                ?? 'Sin observaciones generales.'
        ];


        /*
        |--------------------------------------------------------------------------
        | MOTIVO DE RECHAZO
        |--------------------------------------------------------------------------
        */

        if (
            $this->reporte->estado === 'rechazado'
            && filled($this->reporte->motivo_rechazo)
        ) {

            $rows[] = [];

            $rows[] = [
                'MOTIVO DEL RECHAZO'
            ];

            $rows[] = [
                $this->reporte->motivo_rechazo
            ];
        }


        return $rows;
    }


    public function styles(Worksheet $sheet)
    {
        /*
        |--------------------------------------------------------------------------
        | TÍTULO PRINCIPAL
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A1')
            ->getFont()
            ->setBold(true)
            ->setSize(16);


        /*
        |--------------------------------------------------------------------------
        | DATOS GENERALES
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A3:A8')
            ->getFont()
            ->setBold(true);


        /*
        |--------------------------------------------------------------------------
        | AJUSTAR TEXTO
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            'A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow()
        )
        ->getAlignment()
        ->setWrapText(true)
        ->setVertical('top');


        /*
        |--------------------------------------------------------------------------
        | ENCABEZADO CHECKLIST
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A10')
            ->getFont()
            ->setBold(true)
            ->setSize(12);


        /*
        |--------------------------------------------------------------------------
        | BORDES Y ENCABEZADOS DE CATEGORÍAS
        |--------------------------------------------------------------------------
        */

        $highestRow = $sheet->getHighestRow();

        for ($row = 1; $row <= $highestRow; $row++) {

            $valueA = $sheet->getCell("A{$row}")->getValue();
            $valueB = $sheet->getCell("B{$row}")->getValue();
            $valueC = $sheet->getCell("C{$row}")->getValue();


            /*
            |--------------------------------------------------------------------------
            | FILAS DE ENCABEZADO
            |--------------------------------------------------------------------------
            */

            if (
                $valueA === 'Elemento'
                && $valueB === 'Estado'
                && $valueC === 'Observación'
            ) {

                $sheet->getStyle("A{$row}:C{$row}")
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle("A{$row}:C{$row}")
                    ->getBorders()
                    ->getBottom()
                    ->setBorderStyle(
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | TÍTULOS ESPECIALES
            |--------------------------------------------------------------------------
            */

            if (
                $valueA === 'OBSERVACIONES GENERALES'
                || $valueA === 'MOTIVO DEL RECHAZO'
            ) {

                $sheet->getStyle("A{$row}")
                    ->getFont()
                    ->setBold(true)
                    ->setSize(11);
            }

        }


        /*
        |--------------------------------------------------------------------------
        | ANCHOS
        |--------------------------------------------------------------------------
        */

        $sheet->getColumnDimension('A')
            ->setWidth(42);

        $sheet->getColumnDimension('B')
            ->setWidth(16);

        $sheet->getColumnDimension('C')
            ->setWidth(60);


        return [];
    }
}