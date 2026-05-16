<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="gp-header-title">
                Gestión de Áreas
            </h2>

            <p class="gp-header-subtitle">
                Administración de áreas preoperacionales del sistema.
            </p>
        </div>

    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h3 class="text-xl font-bold text-slate-700">
            Áreas registradas
        </h3>

        <a href="{{ route('areas.create') }}"
           class="gp-card-button">

            Nueva Área

        </a>

    </div>

    <div class="gp-table-container">

        <table class="gp-table">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse($areas as $area)

                    <tr>

                        <td>{{ $area->id }}</td>

                        <td>{{ $area->nombre }}</td>

                        <td>
                            {{ $area->descripcion ?? 'Sin descripción' }}
                        </td>

                        <td>

                            @if($area->activo)

                                <span class="gp-badge-success">
                                    Activa
                                </span>

                            @else

                                <span class="gp-badge-danger">
                                    Inactiva
                                </span>

                            @endif

                        </td>

                        <td class="flex gap-2">

                            <a href="{{ route('areas.edit', $area) }}"
                               class="gp-table-button">

                                Editar

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-6">

                            No hay áreas registradas.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-app-layout>