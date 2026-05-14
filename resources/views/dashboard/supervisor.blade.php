<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">Dashboard Supervisor</h2>
            <p class="gp-header-subtitle">Panel de control para registro de reportes preoperacionales.</p>
        </div>
    </x-slot>

    <div class="gp-dashboard-grid">
        <div class="gp-dashboard-card">
            <h3>Crear reporte</h3>
            <p>Registrar un nuevo reporte preoperacional por área.</p>
            <a href="#" class="gp-card-button">Nuevo reporte</a>
        </div>

        <div class="gp-dashboard-card">
            <h3>Reportes pendientes</h3>
            <p>Consultar reportes guardados pendientes de revisión.</p>
            <a href="#" class="gp-card-button">Ver pendientes</a>
        </div>

        <div class="gp-dashboard-card">
            <h3>Historial</h3>
            <p>Buscar reportes anteriores por fecha, área o estado.</p>
            <a href="#" class="gp-card-button">Consultar</a>
        </div>
    </div>
</x-app-layout>