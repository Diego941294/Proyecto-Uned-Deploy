<x-app-layout>

    @if (session('warning'))
    <div class="gp-warning-alert" role="alert">
        <strong>Atención:</strong>
        {{ session('warning') }}
    </div>
    @endif

    @if (session('success'))
    <div class="gp-success-alert" role="status">
        {{ session('success') }}
    </div>
    @endif

    <style>
        .gp-warning-alert {
            margin: 20px 0;
            padding: 15px 20px;
            border: 1px solid #f0c36d;
            border-left: 5px solid #d97706;
            border-radius: 8px;
            background: #fffbeb;
            color: #78350f;
        }

        .gp-success-alert {
            margin: 20px 0;
            padding: 15px 20px;
            border: 1px solid #86efac;
            border-left: 5px solid #16a34a;
            border-radius: 8px;
            background: #f0fdf4;
            color: #166534;
        }
    </style>
    <div class="gp-admin-dashboard-v2">

        <div class="gp-kpi-grid-v2">

            <div class="gp-kpi-v2 blue">
                <div class="gp-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 32 32"><title>Base document set</title>
  <path d="M24,30c-3.3,0-6-2.7-6-6s2.7-6,6-6,6,2.7,6,6-2.7,6-6,6ZM24,20c-2.2,0-4,1.8-4,4s1.8,4,4,4,4-1.8,4-4-1.8-4-4-4ZM16,28h-4V4h8v6c0,1.1.9,2,2,2h6v4h2v-6c0-.3-.1-.5-.3-.7l-7-7c-.2-.2-.4-.3-.7-.3h-10c-1.1,0-2,.9-2,2v24c0,1.1.9,2,2,2h4s0-2,0-2ZM22,4.4l5.6,5.6h-5.6v-5.6ZM4,7h-2v20h2V7ZM8,4h-2v24h2V4Z"/>
  </svg></div>
                <div>
                    <span>Total Reportes</span>
                    <strong>{{ $totalReportes }}</strong>
                    <small>Reportes generados</small>
                </div>
            </div>

            <div class="gp-kpi-v2 blue">
                <div class="gp-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Document unknown</title>
  <title>document--unknown</title>
  <circle cx="8.9999" cy="28.5" r="1.5"/>
  <path d="M10,25H8V21h2a2,2,0,0,0,0-4H8a2.0023,2.0023,0,0,0-2,2v.5H4V19a4.0045,4.0045,0,0,1,4-4h2a4,4,0,0,1,0,8Z"/>
  <path d="M27.7,9.3l-7-7A.9085.9085,0,0,0,20,2H10A2.0058,2.0058,0,0,0,8,4v8h2V4h8v6a2.0058,2.0058,0,0,0,2,2h6V28H14v2H26a2.0058,2.0058,0,0,0,2-2V10A.9092.9092,0,0,0,27.7,9.3ZM20,10V4.4L25.6,10Z"/>
  </svg></div>
                <div>
                    <span>Pendientes de revisión</span>
                    <strong>{{ $pendientes }}</strong>
                    <small>Reportes enviados por supervisores</small>
                </div>
            </div>

            <div class="gp-kpi-v2 green">
                <div class="gp-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Document tasks</title>
  <polygon points="22 27.18 19.41 24.59 18 26 22 30 30 22 28.59 20.59 22 27.18"/>
  <path d="M15,28H8V4h8v6a2.0058,2.0058,0,0,0,2,2h6v6h2V10a.9092.9092,0,0,0-.3-.7l-7-7A.9087.9087,0,0,0,18,2H8A2.0058,2.0058,0,0,0,6,4V28a2.0058,2.0058,0,0,0,2,2h7ZM18,4.4,23.6,10H18Z"/>
  </svg></div>
                <div>
                    <span>Aprobados</span>
                    <strong>{{ $aprobados }}</strong>
                    <small>Aprobaciones</small>
                </div>
            </div>

            <div class="gp-kpi-v2 red">
                <div class="gp-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>File X</title>
  <path d="M18,30h-10c-1.103,0-2-.8975-2-2V4c0-1.103.897-2,2-2h10c.2656,0,.5195.1055.707.293l7,7c.1875.1875.293.4419.293.707v8h-2v-6h-6c-1.103,0-2-.897-2-2v-6h-8v24h10v2ZM18,4.4141v5.5859h5.5859l-5.5859-5.5859ZM28.293,29.707l-3.293-3.293-3.293,3.293-1.4141-1.4141,3.293-3.293-3.293-3.293,1.4141-1.4141,3.293,3.293,3.293-3.293,1.4141,1.4141-3.293,3.293,3.293,3.293-1.4141,1.4141Z"/>
  </svg></div>
                <div>
                    <span>Rechazados</span>
                    <strong>{{ $rechazados }}</strong>
                    <small>Rechazos</small>
                </div>
            </div>

        </div>

        <div class="gp-admin-main-grid">

            <div class="gp-chart-card-v2">
                <h3>Estado General de Reportes</h3>

                <div class="gp-chart-content-v2">

                    <div class="gp-chart-wrapper-v2">
                        <canvas id="reportesChart"></canvas>
                    </div>

                    <div class="gp-chart-legend-v2">

                        <div>
                            <span class="orange"></span>
                            <p>Aprobados</p>
                            <strong>{{ $aprobados }}</strong>
                        </div>

                        <div>
                            <span class="yellow"></span>
                            <p>Rechazados</p>
                            <strong>{{ $rechazados }}</strong>
                        </div>

                        <div>
                            <span class="green"></span>
                            <p>Enviados</p>
                            <strong>{{ $pendientes }}</strong>
                        </div>

                    </div>

                </div>
            </div>

            <div class="gp-action-list-v2">

                <a href="{{ route('reportes.index') }}" class="gp-action-card">
                    <div class="gp-action-icon blue"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><title>Report</title><title>report--alt</title><rect x="10" y="18" width="8" height="2"/><rect x="10" y="13" width="12" height="2"/><rect x="10" y="23" width="5" height="2"/><path d="M25,5H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2H25a2,2,0,0,0,2-2V7A2,2,0,0,0,25,5ZM12,4h8V8H12ZM25,28H7V7h3v3H22V7h3Z"/></svg></div>
                    <div class="gp-action-content">
                        <strong>Reportes</strong>
                        <p>Consultar, aprobar y revisar reportes.</p>
                    </div>
                    <div class="gp-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow right</title>
  <polygon points="18 6 16.57 7.393 24.15 15 4 15 4 17 24.15 17 16.57 24.573 18 26 28 16 18 6"/>
  </svg></div>
                </a>

                <a href="{{ route('areas.index') }}" class="gp-action-card">
                    <div class="gp-action-icon orange"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><title>Categories</title><title>categories</title><path d="M6.76,6l.45.89L7.76,8H12v5H4V6H6.76m.62-2H3A1,1,0,0,0,2,5v9a1,1,0,0,0,1,1H13a1,1,0,0,0,1-1V7a1,1,0,0,0-1-1H9L8.28,4.55A1,1,0,0,0,7.38,4Z" transform="translate(0 0)"/><path d="M22.76,6l.45.89L23.76,8H28v5H20V6h2.76m.62-2H19a1,1,0,0,0-1,1v9a1,1,0,0,0,1,1H29a1,1,0,0,0,1-1V7a1,1,0,0,0-1-1H25l-.72-1.45a1,1,0,0,0-.9-.55Z" transform="translate(0 0)"/><path d="M6.76,19l.45.89L7.76,21H12v5H4V19H6.76m.62-2H3a1,1,0,0,0-1,1v9a1,1,0,0,0,1,1H13a1,1,0,0,0,1-1V20a1,1,0,0,0-1-1H9l-.72-1.45a1,1,0,0,0-.9-.55Z" transform="translate(0 0)"/><path d="M22.76,19l.45.89L23.76,21H28v5H20V19h2.76m.62-2H19a1,1,0,0,0-1,1v9a1,1,0,0,0,1,1H29a1,1,0,0,0,1-1V20a1,1,0,0,0-1-1H25l-.72-1.45a1,1,0,0,0-.9-.55Z" transform="translate(0 0)"/></svg></div>
                    <div class="gp-action-content">
                        <strong>Áreas</strong>
                        <p>Administrar áreas y secciones.</p>
                    </div>
                    <div class="gp-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow right</title>
  <polygon points="18 6 16.57 7.393 24.15 15 4 15 4 17 24.15 17 16.57 24.573 18 26 28 16 18 6"/>
  </svg></div>
                </a>
                <a href="{{ route('infraestructuras.index') }}"
                    class="gp-action-card">

                    <div class="gp-action-icon orange"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Building</title><title>building</title><path d="M28,2H16a2.002,2.002,0,0,0-2,2V14H4a2.002,2.002,0,0,0-2,2V30H30V4A2.0023,2.0023,0,0,0,28,2ZM9,28V21h4v7Zm19,0H15V20a1,1,0,0,0-1-1H8a1,1,0,0,0-1,1v8H4V16H16V4H28Z"/><rect x="18" y="8" width="2" height="2"/><rect x="24" y="8" width="2" height="2"/><rect x="18" y="14" width="2" height="2"/><rect x="24" y="14" width="2" height="2"/><rect x="18" y="19.9996" width="2" height="2"/><rect x="24" y="19.9996" width="2" height="2"/></svg></div>

                    <div class="gp-action-content">
                        <strong>Infraestructura</strong>
                        <p>Administrar secciones e infraestructura.</p>
                    </div>

                    <div class="gp-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow right</title>
  <polygon points="18 6 16.57 7.393 24.15 15 4 15 4 17 24.15 17 16.57 24.573 18 26 28 16 18 6"/>
  </svg></div>

                </a>

                <a href="{{ route('check-items.index') }}" class="gp-action-card">
                    <div class="gp-action-icon green"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><title>Task</title><title>task</title><polygon points="14 20.18 10.41 16.59 9 18 14 23 23 14 21.59 12.58 14 20.18"/><path d="M25,5H22V4a2,2,0,0,0-2-2H12a2,2,0,0,0-2,2V5H7A2,2,0,0,0,5,7V28a2,2,0,0,0,2,2H25a2,2,0,0,0,2-2V7A2,2,0,0,0,25,5ZM12,4h8V8H12ZM25,28H7V7h3v3H22V7h3Z" transform="translate(0 0)"/></svg></div>
                    <div class="gp-action-content">
                        <strong>Check Items</strong>
                        <p>Gestionar elementos de inspección.</p>
                    </div>
                    <div class="gp-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow right</title>
  <polygon points="18 6 16.57 7.393 24.15 15 4 15 4 17 24.15 17 16.57 24.573 18 26 28 16 18 6"/>
  </svg></div>
                </a>

                <a href="{{ route('reportes.excel') }}" class="gp-action-card">
                    <div class="gp-action-icon purple"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Document download</title>
  <title>document--download</title>
  <polygon points="30 25 28.586 23.586 26 26.172 26 18 24 18 24 26.172 21.414 23.586 20 25 25 30 30 25"/>
  <path d="M18,28H8V4h8v6a2.0058,2.0058,0,0,0,2,2h6v3l2,0V10a.9092.9092,0,0,0-.3-.7l-7-7A.9087.9087,0,0,0,18,2H8A2.0058,2.0058,0,0,0,6,4V28a2.0058,2.0058,0,0,0,2,2H18ZM18,4.4,23.6,10H18Z"/>
  </svg></div>
                    <div class="gp-action-content">
                        <strong>Exportar Excel</strong>
                        <p>Descargar reporte consolidado.</p>
                    </div>
                    <div class="gp-action-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow down</title>
  <polygon points="24.59 16.59 17 24.17 17 4 15 4 15 24.17 7.41 16.59 6 18 16 28 26 18 24.59 16.59"/>
  </svg></div>
                </a>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('reportesChart');

            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',


                data: {
                    labels: [
                        'Aprobados',
                        'Rechazados',
                        'Enviados'
                    ],

                    datasets: [{
                        data: [
                            Number("{{ $aprobados }}"),
                            Number("{{ $rechazados }}"),
                            Number("{{ $pendientes }}")
                        ],

                        backgroundColor: [
                            '#fb923c',
                            '#facc15',
                            '#86c96f'
                        ],

                        borderColor: '#ffffff',
                        borderWidth: 4,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '58%',

                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    <style>
        /* 🔹 El contenedor principal define el límite */
        .gp-admin-dashboard-v2 {
            max-width: 1200px;
            /* ajusta según tu diseño */
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        /* 🔹 El grid nunca más ancho que el contenedor */
        .gp-admin-main-grid {
            display: grid;
            grid-template-columns: 1.35fr 0.85fr;
            gap: 20px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* 🔹 Tarjeta del gráfico */
        .gp-chart-card-v2 {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow: hidden;
            /* 🔸 evita que el canvas se salga */
        }

        /* 🔹 Wrapper del gráfico */
        .gp-chart-wrapper-v2 {
            width: 100%;
            max-width: 100%;
            height: 250px;
            position: relative;
            box-sizing: border-box;
        }

        /* 🔹 Canvas limitado */
        #reportesChart {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            display: block;
        }

        /* 🔹 Leyenda también limitada */
        .gp-chart-legend-v2 {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        /* 🔹 Responsive: apilar gráfico y leyenda en pantallas pequeñas */
        @media (max-width: 1024px) {
            .gp-admin-main-grid {
                grid-template-columns: 1fr;
            }

            .gp-chart-content-v2 {
                display: flex;
                flex-direction: column;
                gap: 18px;
            }
        }
.gp-action-icon svg {
    width: 32px;
    height: 32px;
}
.gp-kpi-icon svg {
    width: 50px;
    height: 50px;
}


    </style>


</x-app-layout>