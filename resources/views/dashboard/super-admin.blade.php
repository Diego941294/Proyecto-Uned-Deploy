<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">
                    Dashboard Super Administrador
                </h2>

                <p class="gp-header-subtitle">
                    Administración general de usuarios, roles y accesos del sistema.
                </p>
            </div>
        </div>
    </section>

    @php
    $roles = [
    [
    'nombre' => 'Super Administrador',
    'cantidad' => $distribucion['superAdministradores'],
    'color' => '#03700c',
    ],
    [
    'nombre' => 'Administrador',
    'cantidad' => $distribucion['administradores'],
    'color' => '#0b31b1',
    ],
    [
    'nombre' => 'Supervisor',
    'cantidad' => $distribucion['supervisores'],
    'color' => '#d8b90a',
    ],
    ];

    $totalUsuarios = array_sum(
    array_column($roles, 'cantidad')
    );
    @endphp

    <div class="gp-superadmin-layout">

        <main class="gp-superadmin-main">

            <div class="gp-superadmin-card green">
                <div>
                    <h3>Gestión de usuarios</h3>
                    <p>Crear usuarios del sistema y asignar roles.</p>
                </div>

                <a
                    href="{{ route('usuarios.index') }}"
                    class="gp-mini-action">
                    Administrar
                </a>
            </div>

            <div class="gp-superadmin-card blue">
                <div>
                    <h3>Panel Administrador</h3>
                    <p>
                        Acceso al control de reportes,
                        áreas y check items.
                    </p>
                </div>

                <a
                    href="{{ route('administrador.dashboard') }}"
                    class="gp-mini-action">
                    Entrar
                </a>
            </div>

            <div class="gp-superadmin-card cyan">
                <div>
                    <h3>Panel Supervisor</h3>
                    <p>
                        Acceso al flujo operativo de
                        creación de reportes.
                    </p>
                </div>

                <a
                    href="{{ route('supervisor.dashboard') }}"
                    class="gp-mini-action">
                    Entrar
                </a>
            </div>

        </main>

        <aside class="gp-superadmin-chart">

            <h3>Distribución de accesos</h3>

            <p class="gp-chart-total">
                Total de usuarios con rol:
                <strong>{{ $totalUsuarios }}</strong>
            </p>

            <div class="gp-superadmin-chart-box">

                @if ($totalUsuarios > 0)

                <canvas
                    id="superAdminChart"
                    data-superadmin="{{ $distribucion['superAdministradores'] }}"
                    data-admin="{{ $distribucion['administradores'] }}"
                    data-supervisor="{{ $distribucion['supervisores'] }}"
                    aria-label="Distribución de usuarios por rol"
                    role="img"></canvas>

                @else

                <p class="gp-chart-empty">
                    No hay usuarios con roles asignados.
                </p>

                @endif

            </div>

            <div class="gp-superadmin-legend">

                <div class="gp-legend-item">
                    <span class="gp-legend-color gp-color-superadmin"></span>
                    <span class="gp-legend-name">Super Administrador</span>
                    <strong class="gp-legend-count">
                        {{ $distribucion['superAdministradores'] }}
                    </strong>
                </div>

                <div class="gp-legend-item">
                    <span class="gp-legend-color gp-color-admin"></span>
                    <span class="gp-legend-name">Administrador</span>
                    <strong class="gp-legend-count">
                        {{ $distribucion['administradores'] }}
                    </strong>
                </div>

                <div class="gp-legend-item">
                    <span class="gp-legend-color gp-color-supervisor"></span>
                    <span class="gp-legend-name">Supervisor</span>
                    <strong class="gp-legend-count">
                        {{ $distribucion['supervisores'] }}
                    </strong>
                </div>

            </div>

        </aside>

    </div>

    @if ($totalUsuarios > 0)

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('superAdminChart');

    if (!canvas || typeof Chart === 'undefined') {
    return;
    }

    const cantidades = [
    Number(canvas.dataset.superadmin),
    Number(canvas.dataset.admin),
    Number(canvas.dataset.supervisor)
    ];

    new Chart(canvas, {
    type: 'pie',

    data: {
    labels: [
    'Super Administrador',
    'Administrador',
    'Supervisor'
    ],

    datasets: [{
    data: cantidades,

    backgroundColor: [
    '#03700c',
    '#0b31b1',
    '#d8b90a'
    ],

    borderColor: '#ffffff',
    borderWidth: 3,
    hoverOffset: 8
    }]
    },

    options: {
    responsive: true,
    maintainAspectRatio: false,

    plugins: {
    legend: {
    display: false
    },

    tooltip: {
    callbacks: {
    label: function (context) {

    const total = context.dataset.data.reduce(
    (sum, value) => sum + Number(value),
    0
    );

    const cantidad = Number(context.raw);

    const porcentaje = total > 0
    ? ((cantidad / total) * 100).toFixed(1)
    : '0.0';

    return context.label + ': ' +
    cantidad + ' (' + porcentaje + '%)';
    }
    }
    }
    }
    }
    });

    });

    @endif

    <style>
        .gp-color-superadmin {
            background-color: #03700c;
        }

        .gp-color-admin {
            background-color: #0b31b1;
        }

        .gp-color-supervisor {
            background-color: #d8b90a;
        }

        .gp-superadmin-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .gp-superadmin-main {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            width: 100%;
            box-sizing: border-box;
            align-content: start;
        }

        .gp-superadmin-card {
            padding: 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow:
                0 2px 8px rgba(15, 47, 95, 0.10);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .gp-superadmin-card h3 {
            margin-bottom: 8px;
        }

        .gp-superadmin-card p {
            margin-bottom: 0;
        }

        .gp-superadmin-chart {
            background: #ffffff;
            border: 1px solid #dbe8f3;
            border-radius: 12px;
            padding: 16px;
            box-sizing: border-box;
            min-width: 0;
        }

        .gp-superadmin-chart h3 {
            margin: 0;
        }

        .gp-chart-total {
            margin: 8px 0 16px;
            color: #526782;
            font-size: 14px;
        }

        .gp-chart-total strong {
            color: #17365d;
        }

        .gp-superadmin-chart-box {
            width: 100%;
            height: 250px;
            position: relative;
            overflow: hidden;
        }

        #superAdminChart {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }

        .gp-superadmin-legend {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .gp-legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #17365d;
            font-size: 14px;
        }

        .gp-legend-color {
            display: inline-block;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .gp-legend-name {
            flex: 1;
        }

        .gp-legend-count {
            margin-left: auto;
            font-variant-numeric: tabular-nums;
        }

        .gp-chart-empty {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
            color: #64748b;
        }

        /* 🔹 Responsive: apilar en pantallas pequeñas */
        @media (max-width: 1024px) {
            .gp-superadmin-layout {
                grid-template-columns: 1fr;
                /* 🔸 todo en una sola columna */
            }

            .gp-superadmin-main {
                grid-template-columns: 1fr;
                /* 🔸 cards apiladas */
            }

            .gp-superadmin-chart {
                margin-top: 20px;
                /* 🔸 se coloca debajo */
            }
        }
    </style>

</x-app-layout>