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
                <a href="{{ route('infraestructuras.index') }}"
                    class="gp-action-card">

                    <div class="gp-action-icon orange">
                        🏢
                    </div>

                    <div class="gp-action-content">
                        <strong>Infraestructura</strong>
                        <p>Administrar secciones e infraestructura.</p>
                    </div>

                    <div class="gp-action-arrow">
                        →
                    </div>

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
    <style>
/* 🔹 El contenedor principal define el límite */
.gp-admin-dashboard-v2 {
    max-width: 1200px;   /* ajusta según tu diseño */
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
    overflow: hidden; /* 🔸 evita que el canvas se salga */
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
</style>


</x-app-layout>