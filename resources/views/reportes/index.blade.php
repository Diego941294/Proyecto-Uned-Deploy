<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">
                Reportes Preoperacionales
            </h2>

            <p class="gp-header-subtitle">
                Gestión de reportes del sistema.
            </p>
        </div>
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h3 class="text-xl font-bold text-slate-700">
            Reportes registrados
        </h3>

        <a href="{{ route('reportes.create') }}"
           class="gp-card-button">

            Nuevo Reporte

        </a>

    </div>

    <div class="gp-table-container">

        <table class="gp-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Supervisor</th>
                    <th>Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($reportes as $reporte)

                    <tr>

                        <td>{{ $reporte->id }}</td>

                        <td>{{ $reporte->area->nombre }}</td>

                        <td>{{ $reporte->fecha->format('d/m/Y') }}</td>

                        <td>

                            @if($reporte->estado == 'aprobado')

                                <span class="gp-badge-success">
                                    Aprobado
                                </span>

                            @elseif($reporte->estado == 'rechazado')

                                <span class="gp-badge-danger">
                                    Rechazado
                                </span>

                            @else

                                <span class="gp-badge-warning">
                                    {{ ucfirst($reporte->estado) }}
                                </span>

                            @endif

                        </td>

                        <td>{{ $reporte->usuario->name }}</td>

                        <td>

                            <a href="#"
                               class="gp-table-button">

                                Ver

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-6">

                            No hay reportes registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-app-layout>