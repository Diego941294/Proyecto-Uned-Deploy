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

    <div class="gp-superadmin-layout">

        <aside class="gp-superadmin-sidebar">

            <h3>Menú principal</h3>

            <a href="{{ route('super-admin.dashboard') }}" class="active">
                🏠 Panel general
            </a>

            <a href="#">
                👤 Mi perfil
            </a>

            <a href="#">
                👥 Usuarios del sistema
            </a>

            <a href="#">
                🛡 Roles y permisos
            </a>

            <a href="#">
                📊 Auditoría
            </a>

            <a href="#">
                ⚙️ Configuración
            </a>

        </aside>

        <main class="gp-superadmin-main">

            <div class="gp-superadmin-card green">
                <div>
                    <h3>Gestión de usuarios</h3>
                    <p>Crear usuarios del sistema y asignar roles.</p>
                </div>

                <a href="#" class="gp-mini-action">
                    Administrar
                </a>
            </div>

            <div class="gp-superadmin-card blue">
                <div>
                    <h3>Panel Administrador</h3>
                    <p>Acceso al control de reportes, áreas y check items.</p>
                </div>

                <a href="{{ route('administrador.dashboard') }}" class="gp-mini-action">
                    Entrar
                </a>
            </div>

            <div class="gp-superadmin-card cyan">
                <div>
                    <h3>Panel Supervisor</h3>
                    <p>Acceso al flujo operativo de creación de reportes.</p>
                </div>

                <a href="{{ route('supervisor.dashboard') }}" class="gp-mini-action">
                    Entrar
                </a>
            </div>

            <div class="gp-superadmin-card red">
                <div>
                    <h3>Control de roles</h3>
                    <p>Asignación de permisos según perfil de usuario.</p>
                </div>

                <a href="#" class="gp-mini-action">
                    Revisar
                </a>
            </div>

        </main>

        <aside class="gp-superadmin-chart">

            <h3>Distribución de accesos</h3>

            <div class="gp-superadmin-chart-box">
                <canvas id="superAdminChart"></canvas>
            </div>

            <div class="gp-superadmin-legend">
                <div><span class="green"></span> Super Administrador</div>
                <div><span class="blue"></span> Administrador</div>
                <div><span class="yellow"></span> Supervisor</div>
            </div>

        </aside>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const canvas = document.getElementById('superAdminChart');

            if (!canvas) return;

            new Chart(canvas, {
                type: 'pie',
                data: {
                    labels: [
                        'Super Administrador',
                        'Administrador',
                        'Supervisor'
                    ],
                    datasets: [{
                        data: [1, 1, 1],
                        backgroundColor: [
                            '#03700c',
                            '#0b31b1',
                            '#d8b90a'
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
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