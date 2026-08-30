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

        .category-title {
            padding: 7px 8px;
            background: #dbeafe;
            color: #163f73;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #b9c9dc;
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

        .category-block {
            page-break-inside: avoid;
            margin-bottom: 10px;
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

            <td>
                <strong>Administrador:</strong>
                {{ $reporte->aprobador?->name ?? 'Pendiente de revisión' }}
            </td>

            <td>
                <strong>Estado:</strong>
                {{ ucfirst($reporte->estado) }}
            </td>

        </tr>

    </table>


    @php

        /*
        |--------------------------------------------------------------------------
        | OBSERVACIONES
        |--------------------------------------------------------------------------
        */

        $observacionesDetalle = $reporte->detalles
            ->filter(
                fn ($detalle) =>
                    filled($detalle->observacion)
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | AGRUPAR DETALLES POR INFRAESTRUCTURA / CATEGORÍA
        |--------------------------------------------------------------------------
        */

        $detallesAgrupados = $reporte->detalles
            ->groupBy(
                fn ($detalle) =>
                    $detalle->checkItem?->infraestructura?->nombre
                    ?? 'Sin infraestructura'
            );

    @endphp



    <div class="section-title">
        Checklist registrado
    </div>


    @foreach($detallesAgrupados as $infraestructura => $detalles)


        <div class="category-block">

            <table class="checklist-table">

                <thead>

                    <tr>
                        <th
                            colspan="3"
                            class="category-title"
                        >
                            {{ $infraestructura }}
                        </th>
                    </tr>


                    <tr>

                        <th style="width: 65%;">
                            Elemento
                        </th>

                        <th
                            style="width: 15%;"
                            class="text-center"
                        >
                            Estado
                        </th>

                        <th
                            style="width: 20%;"
                            class="text-center"
                        >
                            ID Obs.
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($detalles as $detalle)


                        @php

                            $indiceObservacion =
                                $observacionesDetalle->search(
                                    fn ($observacion) =>
                                        $observacion->id_reporte_detalles
                                        ===
                                        $detalle->id_reporte_detalles
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

        </div>


    @endforeach



    @if($observacionesDetalle->isNotEmpty())


        <div class="section-title">
            Detalle de observaciones
        </div>


        @php

            $observacionesAgrupadas =
                $observacionesDetalle->groupBy(

                    fn ($detalle) =>
                        $detalle->checkItem?->infraestructura?->nombre
                        ?? 'Sin infraestructura'

                );

        @endphp



        @foreach($observacionesAgrupadas as $infraestructura => $observaciones)


            <div class="category-block">


                <table class="checklist-table">


                    <thead>


                        <tr>

                            <th
                                colspan="3"
                                class="category-title"
                            >
                                {{ $infraestructura }}
                            </th>

                        </tr>


                        <tr>

                            <th
                                style="width: 13%;"
                                class="text-center"
                            >
                                ID
                            </th>

                            <th style="width: 32%;">
                                Elemento
                            </th>

                            <th style="width: 55%;">
                                Observación
                            </th>

                        </tr>


                    </thead>


                    <tbody>


                        @foreach($observaciones as $detalle)


                            @php

                                $indiceGeneral =
                                    $observacionesDetalle->search(

                                        fn ($observacion) =>
                                            $observacion->id_reporte_detalles
                                            ===
                                            $detalle->id_reporte_detalles

                                    );

                            @endphp


                            <tr>


                                <td class="text-center observation-id">

                                    OBS-{{ str_pad(
                                        $indiceGeneral + 1,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </td>


                                <td>

                                    {{ $detalle->checkItem?->nombre
                                        ?? 'Elemento no disponible' }}

                                </td>


                                <td>

                                    {{ $detalle->observacion }}

                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


        @endforeach


    @endif



    <div class="section-title">
        Observaciones Generales
    </div>


    <p>
        {{ $reporte->observaciones ?? 'Sin observaciones generales.' }}
    </p>



    @if(
        $reporte->estado === 'rechazado' &&
        filled($reporte->motivo_rechazo)
    )

        <div class="section-title">
            Motivo del rechazo
        </div>

        <p>
            {{ $reporte->motivo_rechazo }}
        </p>

    @endif



    <div class="footer">
    Generado el {{ now()->format('d/m/Y H:i:s') }}
    

    </div>


</body>

</html>