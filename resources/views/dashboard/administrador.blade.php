<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">Dashboard Administrador</h2>
            <p class="gp-header-subtitle">Panel para revisión, aprobación y control de reportes.</p>
        </div>
    </x-slot>

    <div class="gp-dashboard-grid">
        <div class="gp-dashboard-card">
            <h3>Reportes por aprobar</h3>
            <p>Revisar reportes enviados por Supervisores de Calidad.</p>
            <a href="#" class="gp-card-button">Revisar</a>
        </div>

        <div class="gp-dashboard-card">
            <h3>Historial general</h3>
            <p>Consultar reportes aprobados, rechazados o pendientes.</p>
            <a href="#" class="gp-card-button">Ver historial</a>
        </div>

        <div class="gp-dashboard-card">
            <h3>Gestión del sistema</h3>
            <p>Administrar usuarios, roles y configuración del sistema.</p>
            <a href="#" class="gp-card-button">Gestionar</a>
        </div>
    </div>
</x-app-layout>