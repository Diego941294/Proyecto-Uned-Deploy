<x-app-layout>
    <x-slot name="header">
        <div class="gp-admin-topbar">
            <a href="{{ url()->previous() }}" class="gp-back-button-light">← Volver</a>

            <div>
                <h2 class="gp-header-title">Dashboard Administrador</h2>
                <p class="gp-header-subtitle">Panel para revisión y control del sistema.</p>
            </div>

            <div class="gp-dark-toggle">
                <span>Modo oscuro</span>
                <button type="button">●</button>
            </div>
        </div>
    </x-slot>

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
                <div class="gp-kpi-icon">🗑</div>
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
                        <div><span class="orange"></span>Aprobados <strong>{{ $aprobados }}</strong></div>
                        <div><span class="yellow"></span>Rechazados <strong>{{ $rechazados }}</strong></div>
                        <div><span class="green"></span>Borradores <strong>{{ $borradores }}</strong></div>
                    </div>
                </div>
            </div>

           <div class="gp-action-list-v2">

    <a href="{{ route('reportes.index') }}" class="gp-action-card">
        <div class="gp-action-icon blue">
            📋
        </div>

        <div class="gp-action-content">
            <strong>Reportes</strong>
            <p>Consultar, aprobar y revisar reportes.</p>
        </div>

        <div class="gp-action-arrow">
            →
        </div>
    </a>

    <a href="{{ route('areas.index') }}" class="gp-action-card">
        <div class="gp-action-icon orange">
            🏭
        </div>

        <div class="gp-action-content">
            <strong>Áreas</strong>
            <p>Administrar áreas y secciones.</p>
        </div>

        <div class="gp-action-arrow">
            →
        </div>
    </a>

    <a href="{{ route('check-items.index') }}" class="gp-action-card">
        <div class="gp-action-icon green">
            ✅
        </div>

        <div class="gp-action-content">
            <strong>Check Items</strong>
            <p>Gestionar elementos de inspección.</p>
        </div>

        <div class="gp-action-arrow">
            →
        </div>
    </a>

    <a href="{{ route('reportes.excel') }}" class="gp-action-card">
        <div class="gp-action-icon purple">
            📊
        </div>

        <div class="gp-action-content">
            <strong>Exportar Excel</strong>
            <p>Descargar reporte consolidado.</p>
        </div>

        <div class="gp-action-arrow">
            ↓
        </div>
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

                borderRadius: 8,
                borderSkipped: false,
                barThickness: 30
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
                        precision: 0
                    }
                }
            }
        }
    });

});
</script>
</x-app-layout>