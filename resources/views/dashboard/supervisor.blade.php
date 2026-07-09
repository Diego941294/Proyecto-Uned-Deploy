<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">Dashboard Supervisor</h2>

            <p class="gp-header-subtitle">
                Panel de control para registro de reportes preoperacionales.
            </p>
        </div>
    </x-slot>

    <div class="gp-dashboard-grid">

        <div class="gp-dashboard-card">

            <h3>Crear reporte</h3>

            <p>
                Registrar un nuevo reporte preoperacional por área.
            </p>

            <a href="{{ route('reportes.create') }}" class="gp-card-button">

                Nuevo reporte

            </a>

        </div>


        <div class="gp-dashboard-card">

            <h3>Historial</h3>

            <p>
                Buscar reportes anteriores por fecha, área o estado.
            </p>

            <a href="{{ route('supervisor.mis_reportes') }}" class="gp-card-button">

                Consultar

            </a>

        </div>



        <div class="gp-dashboard-card">


            <h3>Gráfico de mis reportes</h3>
            <canvas id="graficoReportes"></canvas>


            <style>
                #graficoReportes {

                    height: 120px !important;
                    /* alto fijo */
                    margin: 0
                }
            </style>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const dataReportes = @json([$aprobados, $rechazados, $borradores]);

                const ctx = document.getElementById('graficoReportes').getContext('2d');
                new Chart(ctx, {
                    type: 'bar', // 🔸 gráfico de barras
                    data: {
                        labels: ['Aprobados', 'Rechazados', 'Borradores'],
                        datasets: [{
                            label: 'Cantidad',
                            data: dataReportes,
                            backgroundColor: ['#22c55e', '#ef4444', '#f59e0b'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,          // 🔸 evita que se estire
                        maintainAspectRatio: false, // 🔸 respeta el tamaño CSS
                        plugins: {
                            legend: { display: false },
                            title: {
                                display: true,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                });
            </script>


        </div>


    </div>

    <div class="gp-dashboard-card" style="margin-top:30px;">
        @if($reportes->isEmpty())
            <p style="color:#991b1b; font-weight:600;">❌ No hay reportes en estado Borrador.</p>
        @else
            <div class="gp-table-wrapper">
                <table class="gp-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Área</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportes as $reporte)
                            <tr>
                                <td>#{{ $reporte->id }}</td>
                                <td>{{ $reporte->area->nombre }}</td>
                                <td>{{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('reportes.edit', $reporte->id) }}" class="gp-action-link">✏️ Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>


    <style>
        .gp-dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            /* 🔸 se adapta automáticamente */
            gap: 15px;
        }

        /* Estilo base de cada tarjeta */
        .gp-dashboard-card {
            padding: 20px;
            border: 1px solid #f97316;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        //uh


        .gp-table-wrapper {
            width: 100%;
            overflow-x: auto;
            /* 🔸 scroll horizontal solo dentro de la tarjeta */
        }

        .gp-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
            /* 🔸 asegura que no se rompa en escritorio */
        }

        .gp-table th,
        .gp-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        /* 🔸 En pantallas pequeñas, la tabla ocupa todo el ancho de la tarjeta */
        @media (max-width: 768px) {
            .gp-table {
                min-width: 100%;
                /* se ajusta al ancho de la tarjeta */
            }
        }

        @media (max-width: 400px) {
            .gp-table {
                min-width: 100%;
                /* 🔸 ocupa todo el ancho de la tarjeta */
                font-size: 14px;
                /* 🔸 reduce tipografía para que quepa */
            }

            .gp-table th,
            .gp-table td {
                padding: 6px;
                /* 🔸 menos padding */
            }
        }


        //color

        .gp-table {
            background-color: #fff;
            /* fondo fijo blanco */
            color: #333;
            /* texto gris oscuro */
        }

        .gp-table th {
            background-color: #f97316;
            /* naranja en encabezados */
            color: #fff;
        }

    </style>


</x-app-layout>