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

     
        <main class="gp-superadmin-main">


            <div class="gp-superadmin-card green">
                <div>
                    <h3>Gestión de usuarios</h3>
                    <p>Crear usuarios del sistema y asignar roles.</p>
                </div>

                <a href="{{ route('usuarios.index') }}" class="gp-mini-action">
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
        document.addEventListener('DOMContentLoaded', function() {
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

 <style>
    /* 🔹 Contenedor principal */
.gp-superadmin-layout {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 320px;
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}

/* 🔹 Sidebar */
.gp-superadmin-sidebar {
    background: #fff;
    border: 1px solid #dbe8f3;
    border-radius: 12px;
    padding: 16px;
    box-sizing: border-box;
}

/* 🔹 Main */
.gp-superadmin-main {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    width: 100%;
    box-sizing: border-box;
}

/* 🔹 Cards */
.gp-superadmin-card {
    padding: 20px;
    border-radius: 10px;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(15, 47, 95, 0.10);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* 🔹 Chart */
.gp-superadmin-chart {
    background: #fff;
    border: 1px solid #dbe8f3;
    border-radius: 12px;
    padding: 16px;
    box-sizing: border-box;
}

.gp-superadmin-chart-box {
    width: 100%;
    max-width: 100%;
    height: 250px;
    position: relative;
    overflow: hidden; /* 🔸 evita que el canvas se salga */
}

#superAdminChart {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    display: block;
}

/* 🔹 Leyenda */
.gp-superadmin-legend {
    margin-top: 12px;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

/* 🔹 Responsive: apilar en pantallas pequeñas */
@media (max-width: 1024px) {
    .gp-superadmin-layout {
        grid-template-columns: 1fr; /* 🔸 todo en una sola columna */
    }

    .gp-superadmin-main {
        grid-template-columns: 1fr; /* 🔸 cards apiladas */
    }

    .gp-superadmin-chart {
        margin-top: 20px; /* 🔸 se coloca debajo */
    }
}

    </style>

    

</x-app-layout>