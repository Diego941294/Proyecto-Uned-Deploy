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

<div class="flex gap-4 mt-6 flex-wrap">

    @role('Administrador')

        @if($reporte->estado != 'aprobado')

            <form method="POST"
                  action="{{ route('reportes.aprobar', $reporte) }}">

                @csrf

                <button type="submit"
                        class="gp-table-button-success">

                    Aprobar Reporte

                </button>

            </form>

        @endif


        @if($reporte->estado != 'rechazado')

            <form method="POST"
                  action="{{ route('reportes.rechazar', $reporte) }}">

                @csrf

                <button type="submit"
                        class="gp-table-button-danger">

                    Rechazar Reporte

                </button>

            </form>

        @endif

    @endrole

    <a href="{{ route('reportes.index') }}"
       class="gp-secondary-button">

        Volver

    </a>

</div>
    </div>
</x-app-layout>