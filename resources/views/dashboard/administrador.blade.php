<x-app-layout>

    <div class="gp-admin-dashboard-v2">

        <div class="gp-kpi-grid-v2">

            <div class="gp-kpi-v2 blue">
                <div class="gp-kpi-icon">📄</div>
                <div>
                    <span>Total Reportes</span>
                    <strong>{{ $totalReportes }}</strong>
                    <small>Reportes generados</small>
                </div>
            </div>

            <div class="gp-kpi-v2 green">
                <div class="gp-kpi-icon">✓</div>
                <div>
                    <span>Aprobados</span>
                    <strong>{{ $aprobados }}</strong>
                    <small>Aprobaciones</small>
                </div>
            </div>

            <div class="gp-kpi-v2 red">
                <div class="gp-kpi-icon">✕</div>
                <div>
                    <span>Rechazados</span>
                    <strong>{{ $rechazados }}</strong>
                    <small>Rechazos</small>
                </div>
            </div>

            <div class="gp-kpi-v2 gray">
                <div class="gp-kpi-icon">📝</div>
                <div>
                    <span>Borradores</span>
                    <strong>{{ $borradores }}</strong>
                    <small>En borrador</small>
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
                            <p>Borradores</p>
                            <strong>{{ $borradores }}</strong>
                        </div>

                    </div>

                </div>
            </div>

            <div class="gp-action-list-v2">

                <a href="{{ route('reportes.index') }}" class="gp-action-card">
                    <div class="gp-action-icon blue">📋</div>
                    <div class="gp-action-content">
                        <strong>Reportes</strong>
                        <p>Consultar, aprobar y revisar reportes.</p>
                    </div>
                    <div class="gp-action-arrow">→</div>
                </a>

                <a href="{{ route('areas.index') }}" class="gp-action-card">
                    <div class="gp-action-icon orange">🏭</div>
                    <div class="gp-action-content">
                        <strong>Áreas</strong>
                        <p>Administrar áreas y secciones.</p>
                    </div>
                    <div class="gp-action-arrow">→</div>
                </a>

                <a href="{{ route('check-items.index') }}" class="gp-action-card">
                    <div class="gp-action-icon green">✅</div>
                    <div class="gp-action-content">
                        <strong>Check Items</strong>
                        <p>Gestionar elementos de inspección.</p>
                    </div>
                    <div class="gp-action-arrow">→</div>
                </a>

                <a href="{{ route('reportes.excel') }}" class="gp-action-card">
                    <div class="gp-action-icon purple">📊</div>
                    <div class="gp-action-content">
                        <strong>Exportar Excel</strong>
                        <p>Descargar reporte consolidado.</p>
                    </div>
                    <div class="gp-action-arrow">↓</div>
                </a>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('reportesChart');

            if (!canvas) return;

            const ctx = canvas.getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',

                data: {
                    labels: [
                        'Aprobados',
                        'Rechazados',
                        'Borradores'
                    ],

                    datasets: [{
                        data: [
                            Number("{{ $aprobados }}"),
                            Number("{{ $rechazados }}"),
                            Number("{{ $borradores }}")
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

</x-app-layout>