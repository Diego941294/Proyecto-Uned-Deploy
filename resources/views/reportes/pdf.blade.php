<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <style>

        @page {
            margin: 28px 32px 42px 32px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1f2937;
            margin: 0;
            padding: 0;
            line-height: 1.35;
        }

        .header {
            width: 100%;
            text-align: center;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 2px solid #1d4f91;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #163f73;
            letter-spacing: 0.5px;
        }

        .subtitle {
            margin-top: 4px;
            font-size: 10px;
            color: #64748b;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
        }

        .info-table td {
            width: 50%;
            padding: 7px 9px;
            vertical-align: top;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        .section-title {
            margin-top: 15px;
            margin-bottom: 7px;
            padding: 7px 9px;
            background: #163f73;
            color: #ffffff;
            font-weight: bold;
            font-size: 11px;
            border-radius: 2px;
        }

        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 15px;
        }

        .checklist-table thead {
            display: table-header-group;
        }

        .checklist-table tr {
            page-break-inside: avoid;
        }

        .checklist-table th {
            background: #eaf2fb;
            color: #163f73;
            font-weight: bold;
            padding: 7px 6px;
            border: 1px solid #b9c9dc;
            text-align: left;
            vertical-align: middle;
        }

        .checklist-table td {
            padding: 6px;
            border: 1px solid #d6dee8;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .checklist-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .observation-id {
            font-weight: bold;
            color: #163f73;
        }

        p {
            margin: 0;
            padding: 7px 2px;
        }

        .footer {
            position: fixed;
            bottom: -24px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #64748b;
            border-top: 1px solid #d1d5db;
            padding-top: 6px;
        }

    </style>

</head>


<body>


<div class="header">

    <div class="title">
        REPORTE PREOPERACIONAL
    </div>

    <div class="subtitle">
        Sistema Preoperacional Guana Pollo
    </div>

</div>


<table class="info-table">

    <tr>

        <td>
            <strong>Reporte:</strong>
            #{{ $reporte->id_reportes }}
        </td>

        <td>
            <strong>Área:</strong>
            {{ $reporte->area?->nombre ?? 'Área no disponible' }}
        </td>

    </tr>

    <tr>

        <td>
            <strong>Supervisor:</strong>
            {{ $reporte->usuario?->name ?? 'No registrado' }}
        </td>

        <td>
            <strong>Fecha:</strong>
            {{ $reporte->fecha?->format('d/m/Y') ?? 'No registrada' }}
        </td>

    </tr>

    <tr>

        <td colspan="2">
            <strong>Estado:</strong>
            {{ ucfirst($reporte->estado) }}
        </td>

    </tr>

</table>


@php
    $observacionesDetalle = $reporte->detalles
        ->filter(fn ($detalle) => filled($detalle->observacion))
        ->values();
@endphp


<div class="section-title">
    Checklist registrado
</div>


<table class="checklist-table">

    <thead>

        <tr>
            <th style="width: 24%;">Infraestructura</th>
            <th style="width: 46%;">Elemento</th>
            <th style="width: 12%;" class="text-center">Estado</th>
            <th style="width: 18%;" class="text-center">ID Obs.</th>
        </tr>

    </thead>


    <tbody>

        @foreach($reporte->detalles as $detalle)

            @php
                $indiceObservacion = $observacionesDetalle->search(
                    fn ($observacion) =>
                        $observacion->id_reporte_detalles
                        === $detalle->id_reporte_detalles
                );

                $codigoObservacion =
                    $indiceObservacion !== false
                        ? 'OBS-' . str_pad(
                            $indiceObservacion + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        )
                        : null;
            @endphp


            <tr>

                <td>
                    {{ $detalle->checkItem?->infraestructura?->nombre ?? 'Sin infraestructura' }}
                </td>

                <td>
                    {{ $detalle->checkItem?->nombre ?? 'Elemento no disponible' }}
                </td>

                <td class="text-center">
                    {{ $detalle->estado }}
                </td>

                <td class="text-center observation-id">
                    {{ $codigoObservacion ?? '—' }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>



@if($observacionesDetalle->isNotEmpty())

    <div class="section-title">
        Detalle de observaciones
    </div>


    <table class="checklist-table">

        <thead>

            <tr>
                <th style="width: 12%;" class="text-center">ID</th>
                <th style="width: 23%;">Infraestructura</th>
                <th style="width: 25%;">Elemento</th>
                <th style="width: 40%;">Observación</th>
            </tr>

        </thead>


        <tbody>

            @foreach($observacionesDetalle as $indice => $detalle)

                <tr>

                    <td class="text-center observation-id">

                        OBS-{{ str_pad(
                            $indice + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}

                    </td>

                    <td>
                        {{ $detalle->checkItem?->infraestructura?->nombre ?? 'Sin infraestructura' }}
                    </td>

                    <td>
                        {{ $detalle->checkItem?->nombre ?? 'Elemento no disponible' }}
                    </td>

                    <td>
                        {{ $detalle->observacion }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

@endif



<div class="section-title">
    Observaciones Generales
</div>


<p>
    {{ $reporte->observaciones ?? 'Sin observaciones generales.' }}
</p>



<div class="footer">

    Documento generado automáticamente por el sistema
    preoperacional Guana Pollo.

</div>


</body>

</html>