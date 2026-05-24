<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes Preoperacionales</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #0f172a;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            color: #0f2f5f;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-bottom: 25px;
            color: #475569;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #0f2f5f;
            color: white;
            padding: 9px;
            border: 1px solid #cbd5e1;
        }

        td {
            padding: 8px;
            border: 1px solid #cbd5e1;
        }
    </style>
</head>

<body>

    <h1>Reportes Preoperacionales</h1>
    <p>Listado general de reportes registrados</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Área</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Supervisor</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reportes as $reporte)
                <tr>
                    <td>#{{ $reporte->id }}</td>
                    <td>{{ $reporte->area->nombre }}</td>
                    <td>{{ $reporte->fecha->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($reporte->estado) }}</td>
                    <td>{{ $reporte->usuario->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>