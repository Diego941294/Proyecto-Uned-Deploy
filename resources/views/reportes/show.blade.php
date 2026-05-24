<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Detalle del Reporte #{{ $reporte->id }}
                </h2>

                <p class="gp-header-subtitle">
                    Revisión completa del reporte preoperacional.
                </p>
            </div>

            <div class="gp-header-actions">

                <a href="{{ route('reportes.index') }}"
                   class="gp-action-btn secondary">
                    ← Volver
                </a>

                <a href="{{ route('reportes.pdf', $reporte) }}"
                   class="gp-action-btn pdf">
                    📄 PDF
                </a>

                <a href="{{ route('reportes.excel-detalle', $reporte) }}"
                   class="gp-action-btn excel">
                    📊 Excel
                </a>

                @role('Administrador')

                    @if($reporte->estado != 'aprobado')
                        <form method="POST"
                              action="{{ route('reportes.aprobar', $reporte) }}">
                            @csrf

                            <button type="submit" class="gp-action-btn success">
                                ✓ Aprobar
                            </button>
                        </form>
                    @endif

                    @if($reporte->estado != 'rechazado')
                        <form method="POST"
                              action="{{ route('reportes.rechazar', $reporte) }}">
                            @csrf

                            <button type="submit" class="gp-action-btn danger">
                                ✕ Rechazar
                            </button>
                        </form>
                    @endif

                @endrole

            </div>

        </div>
    </section>

    <div class="gp-detail-panel">

        <div class="gp-detail-summary">

            <div class="gp-detail-card">
                <span>Área</span>
                <strong>{{ $reporte->area->nombre }}</strong>
            </div>

            <div class="gp-detail-card">
                <span>Supervisor</span>
                <strong>{{ $reporte->usuario->name }}</strong>
            </div>

            <div class="gp-detail-card">
                <span>Fecha</span>
                <strong>{{ $reporte->fecha->format('d/m/Y') }}</strong>
            </div>

            <div class="gp-detail-card">
                <span>Estado</span>

                @if($reporte->estado == 'aprobado')
                    <strong class="gp-text-success">Aprobado</strong>
                @elseif($reporte->estado == 'rechazado')
                    <strong class="gp-text-danger">Rechazado</strong>
                @else
                    <strong class="gp-text-secondary">Borrador</strong>
                @endif
            </div>

            @if($reporte->aprobado_por)

                <div class="gp-detail-card">
                    <span>Aprobado por</span>
                    <strong>
                        {{ \App\Models\User::find($reporte->aprobado_por)?->name }}
                    </strong>
                </div>

                <div class="gp-detail-card">
                    <span>Fecha aprobación</span>
                    <strong>
                        {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') }}
                    </strong>
                </div>

            @endif

        </div>

        <div class="gp-detail-section-title">
            <h3>Checklist registrado</h3>
            <p>Detalle de los elementos revisados en el reporte.</p>
        </div>

        <div class="gp-table-modern-wrap">

            <table class="gp-table-modern">

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

        <div class="gp-observation-box">
            <h3>Observaciones generales</h3>
            <p>{{ $reporte->observaciones ?? 'Sin observaciones generales.' }}</p>
        </div>

    </div>

</x-app-layout>