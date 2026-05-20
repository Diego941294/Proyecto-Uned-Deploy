<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>
        Reporte Preoperacional
    </title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1e293b;
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
            font-size: 14px;
            color: #475569;
        }

        .info-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 10px;
            border: 1px solid #cbd5e1;
        }

        .checklist-table {
            width: 100%;
            border-collapse: collapse;
        }

        .checklist-table th {
            background: #1e3a8a;
            color: white;
            padding: 10px;
            border: 1px solid #cbd5e1;
        }

        .checklist-table td {
            padding: 8px;
            border: 1px solid #cbd5e1;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
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

            <td>
                <strong>Semana:</strong>
                {{ $reporte->semana }}
            </td>

        </tr>

    </table>

    <div class="section-title">
        Checklist registrado
    </div>

    <table class="checklist-table">

        <thead>

            <tr>

                <th>Sección</th>
                <th>Elemento</th>
                <th>Estado</th>
                <th>Observación</th>

            </tr>

        </thead>

        <tbody>

            @foreach($reporte->detalles as $detalle)

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

                    <td>
                        {{ $detalle->observacion ?? 'Sin observación' }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

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