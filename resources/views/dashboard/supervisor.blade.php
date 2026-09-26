<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">Dashboard Supervisor</h2>

            <p class="gp-header-subtitle">
                Panel de control para registro de reportes preoperacionales.
            </p>
        </div>

    </x-slot>

    @if (session('warning'))
    <div class="gp-warning-alert" role="alert">
        <span class="gp-warning-icon">!</span>

        <div>
            <strong>Acceso restringido</strong>
            <p>{{ session('warning') }}</p>
        </div>
    </div>
    @endif


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
                    margin: 0;
                }
            </style>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    const canvas = document.getElementById('graficoReportes');

                    if (!canvas) return;

                    const dataReportes = [
                        Number("{{ $aprobados }}"),
                        Number("{{ $rechazados }}"),
                        Number("{{ $borradores }}")
                    ];

                    new Chart(canvas, {
                        type: 'bar',

                        data: {
                            labels: [
                                'Aprobados',
                                'Rechazados',
                                'Borradores'
                            ],

                            datasets: [{
                                label: 'Cantidad',

                                data: dataReportes,

                                backgroundColor: [
                                    '#22c55e',
                                    '#ef4444',
                                    '#f59e0b'
                                ],

                                borderWidth: 1
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },

                            scales: {
                                y: {
                                    beginAtZero: true,

                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        </div>

    </div>


    <div
        class="gp-dashboard-card"
        style="margin-top:30px;">

        @if($reportes->isEmpty())

        <p style="color:#991b1b; font-weight:600;">
            No hay reportes en estado Borrador.
        </p>

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

                        <td>
                            #{{ $reporte->id_reportes }}
                        </td>

                        <td>
                            {{ $reporte->area?->nombre ?? 'Área no disponible' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}
                        </td>


                        <td>
                            <div class="gp-report-actions">

                                <a
                                    href="{{ route('reportes.edit', $reporte->id_reportes) }}"
                                    class="gp-action-link">
                                    Editar
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('reportes.enviar', $reporte->id_reportes) }}"
                                    onsubmit="return confirm('¿Desea enviar este reporte? Una vez enviado, ya no podrá editarlo.');">

                                    @csrf

                                    <button type="submit" class="gp-send-button">
                                        Enviar reporte
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @endif

    </div>

    <style>
        .gp-report-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .gp-report-actions form {
            margin: 0;
        }

        .gp-send-button {
            padding: 9px 14px;
            border: none;
            border-radius: 5px;
            background: #62d29e;
            color: white;
            font-weight: 700;
            cursor: pointer;
        }

        .gp-send-button:hover {
            background: #105735;
        }

        .gp-dashboard-grid {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
        }

        /* ===============================
           TARJETAS SUPERVISOR
        =============================== */

        .gp-dashboard-card {
            padding: 20px;

            border: 1px solid #8ec5f4;

            border-radius: 8px;

            background: #ffffff;

            box-shadow:
                0 2px 8px rgba(15, 47, 95, 0.10);
        }

        .gp-dashboard-card h3 {
            color: #0b63d8;
        }

        /* ===============================
           BOTONES
        =============================== */

        .gp-card-button {
            display: inline-block;

            margin-top: 16px;

            padding: 11px 16px;

            border-radius: 4px;

            background:
                linear-gradient(135deg,
                    #178bff,
                    #0b63d8);

            color: #ffffff;

            font-weight: 800;

            text-decoration: none;

            text-align: center;

            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .gp-card-button:hover {
            transform: translateY(-1px);

            background:
                linear-gradient(135deg,
                    #0b73e0,
                    #084fae);

            box-shadow:
                0 8px 20px rgba(11, 99, 216, .22);
        }

        /* ===============================
           TABLA
        =============================== */

        .gp-table-wrapper {
            width: 100%;
            overflow-x: hidden;
        }

        .gp-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%;
            background-color: #ffffff;
            color: #333333;
        }


        .gp-table th,
        .gp-table td {
            padding: 10px;

            border-bottom:
                1px solid #dbe8f3;

            text-align: left;
        }

        .gp-table th {
            background:
                linear-gradient(135deg,
                    #0b63d8,
                    #0f2f5f);

            color: #ffffff;
        }

        .gp-table tbody tr:hover {
            background: #f1f7ff;
        }

        /* ===============================
           DARK MODE
        =============================== */

        body.dark-mode .gp-dashboard-card {
            background: #0f1d33;

            border-color:
                rgba(99, 170, 255, .25);
        }

        body.dark-mode .gp-dashboard-card h3 {
            color: #ffffff;
        }

        body.dark-mode .gp-table {
            background: #0d192d;
            color: #eaf3ff;
        }

        body.dark-mode .gp-table td {
            background: #0d192d;
            color: #eaf3ff;
        }

        /* ===============================
           RESPONSIVE
        =============================== */

        @media (max-width: 768px) {

            .gp-table th,
            .gp-table td {
                padding: 6px;
                font-size: 14px;
                word-wrap: break-word;
                white-space: normal;
            }
        }


        @media (max-width: 400px) {

            .gp-table {
                min-width: 100%;
                font-size: 14px;
            }

            .gp-table th,
            .gp-table td {
                padding: 6px;
            }

        }
    </style>



</x-app-layout>