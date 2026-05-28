<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">Dashboard Supervisor</h2>

            <p class="gp-header-subtitle">
                Panel de control para registro de reportes preoperacionales.
            </p>
        </div>
    </x-slot>

    <div class="gp-dashboard-grid">

        <div class="gp-dashboard-card">

            <h3>Crear reporte</h3>

            <p>
                Registrar un nuevo reporte preoperacional por área.
            </p>

            <a href="{{ route('reportes.create') }}"
               class="gp-card-button">

                Nuevo reporte

            </a>

        </div>

        <div class="gp-dashboard-card">

            <h3>Reportes pendientes</h3>

            <p>
                Consultar reportes guardados pendientes de revisión.
            </p>

            <a href="{{ route('reportes.index') }}"
               class="gp-card-button">

                Ver pendientes

            </a>

        </div>

        <div class="gp-dashboard-card">

            <h3>Historial</h3>

            <p>
                Buscar reportes anteriores por fecha, área o estado.
            </p>

            <a href="{{ route('reportes.index') }}"
               class="gp-card-button">

                Consultar

            </a>

        </div>

        

    </div>
    <div class="gp-dashboard-card" style="margin-top:30px;">
    <h3>Informe diario</h3>

    <div class="gp-alert-grid">
        {{-- Área Caliente --}}
        <div class="gp-alert {{ $reporteCaliente ? 'gp-alert-success' : 'gp-alert-warning' }}">
            <span class="gp-alert-icon">🔥</span>
            @if($reporteCaliente)
                <span>Área Caliente: ✅ Reporte registrado hoy</span>
            @else
                <span>Área Caliente: ⚠️ Falta el reporte de hoy</span>
            @endif
        </div>

        {{-- Área Fría --}}
        <div class="gp-alert {{ $reporteFrio ? 'gp-alert-success' : 'gp-alert-warning' }}">
            <span class="gp-alert-icon">❄️</span>
            @if($reporteFrio)
                <span>Área Fría: ✅ Reporte registrado hoy</span>
            @else
                <span>Área Fría: ⚠️ Falta el reporte de hoy</span>
            @endif
        </div>
    </div>
</div>

</x-app-layout>