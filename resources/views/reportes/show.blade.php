<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">
                Detalle del Reporte #{{ $reporte->id }}
            </h2>

            <p class="gp-header-subtitle">
                Revisión completa del reporte preoperacional.
            </p>
        </div>
    </x-slot>

    <div class="gp-form-container">

        <div class="gp-dashboard-grid mb-6">
            <div class="gp-dashboard-card">
                <h3>Área</h3>
                <p>{{ $reporte->area->nombre }}</p>
            </div>

            <div class="gp-dashboard-card">
                <h3>Supervisor</h3>
                <p>{{ $reporte->usuario->name }}</p>
            </div>

            <div class="gp-dashboard-card">
                <h3>Fecha</h3>
                <p>{{ $reporte->fecha->format('d/m/Y') }}</p>
            </div>

            @if($reporte->aprobado_por)
                <div class="gp-dashboard-card">
                    <h3>Aprobado por</h3>
                    <p>{{ \App\Models\User::find($reporte->aprobado_por)?->name }}</p>
                </div>

                <div class="gp-dashboard-card">
                    <h3>Fecha aprobación</h3>
                    <p>{{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') }}</p>
                </div>
            @endif
        </div>

        <h3 class="gp-section-title">Checklist registrado</h3>

        <div class="gp-table-container">
            <table class="gp-table">
                <thead>
                    <tr>
                        <th>Sección</th>
                        <th>Elemento</th>
                        <th>Estado</th>
                        <th>Observación</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reporte->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->checkItem->seccion }}</td>
                            <td>{{ $detalle->checkItem->nombre }}</td>
                            <td>{{ $detalle->estado }}</td>
                            <td>{{ $detalle->observacion ?? 'Sin observación' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="gp-form-group mt-6">
            <label class="gp-label">Observaciones generales</label>
            <p>{{ $reporte->observaciones ?? 'Sin observaciones generales.' }}</p>
        </div>

        <div class="gp-report-actions">

            @role('Administrador')

                @if($reporte->estado != 'aprobado')
                    <form method="POST" action="{{ route('reportes.aprobar', $reporte) }}">
                        @csrf

                        <button type="submit" class="gp-action-btn success">
                            ✓ Aprobar
                        </button>
                    </form>
                @endif

                @if($reporte->estado != 'rechazado')
                    <form method="POST" action="{{ route('reportes.rechazar', $reporte) }}">
                        @csrf

                        <button type="submit" class="gp-action-btn danger">
                            ✕ Rechazar
                        </button>
                    </form>
                @endif

            @endrole

            <a href="{{ route('reportes.index') }}" class="gp-action-btn secondary">
                ← Volver
            </a>

            <a href="{{ route('reportes.pdf', $reporte) }}" class="gp-action-btn primary">
                📄 PDF
            </a>

            <a href="{{ route('reportes.excel-detalle', $reporte) }}" class="gp-action-btn excel">
                📊 Excel
            </a>

        </div>
    </div>
</x-app-layout>