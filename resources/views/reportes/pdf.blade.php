<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>
        Reporte Preoperacional
    </title>

    <style>
        @page {
            margin: 30px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
        }




        .subtitle {
            margin-top: 4px;
            font-size: 14px;
            color: #475569;
        }

        .info-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .info-table td {
            width: 50%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }

        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            page-break-inside: auto;
        }

        .checklist-table thead {
            display: table-header-group;
        }

        .checklist-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .checklist-table th {
            padding: 9px 7px;
            border: 1px solid #cbd5e1;
            background: #1e3a8a;
            color: #ffffff;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
        }

        .checklist-table td {
            padding: 7px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .checklist-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #1e3a8a;
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            page-break-after: avoid;
        }

        .text-center {
            text-align: center;
        }

        .observation-id {
            font-weight: bold;
            color: #1e3a8a;
            white-space: nowrap;
        }

        .empty-value {
            color: #64748b;
        }

        .footer {
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            font-size: 10px;
            color: #64748b;
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
                #{{ $reporte->id }}
            </td>

            <td>
                <strong>Área:</strong>
                {{ $reporte->area->nombre }}
            </td>

        </tr>

        <tr>

            <td>
                <strong>Supervisor:</strong>
                {{ $reporte->usuario->name }}
            </td>

            <td>
                <strong>Fecha:</strong>
                {{ $reporte->fecha->format('d/m/Y') }}
            </td>

        </tr>

        <tr>

            <td>
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

        <th style="width: 22%;">Sección</th>
        <th style="width: 48%;">Elemento</th>
        <th style="width: 14%;">Estado</th>
        <th style="width: 16%;">ID Obs.</th>

        <tbody>

            @foreach($reporte->detalles as $detalle)

            @php
            $indiceObservacion = $observacionesDetalle->search(
            fn ($observacion) => $observacion->id === $detalle->id
            );

            $codigoObservacion = $indiceObservacion !== false
            ? 'OBS-' . str_pad($indiceObservacion + 1, 2, '0', STR_PAD_LEFT)
            : null;
            @endphp

            <tr>

                <td>
                    {{ $detalle->checkItem->seccion }}
                </td>

                <td>
                    {{ $detalle->checkItem->nombre }}
                </td>

                <td>
                    {{ $detalle->estado }}
                </td>

                <td style="text-align: center;">
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

        <th style="width: 13%;">ID</th>
        <th style="width: 20%;">Sección</th>
        <th style="width: 27%;">Elemento</th>
        <th style="width: 40%;">Observación</th>

        <tbody>

            @foreach($observacionesDetalle as $indice => $detalle)

            <tr>

                <td style="text-align: center;">
                    OBS-{{ str_pad($indice + 1, 2, '0', STR_PAD_LEFT) }}
                </td>

                <td>
                    {{ $detalle->checkItem->seccion }}
                </td>

                <td>
                    {{ $detalle->checkItem->nombre }}
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