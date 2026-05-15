<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">
                Check Items
            </h2>

            <p class="gp-header-subtitle">
                Administración de elementos de verificación.
            </p>
        </div>
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h3 class="text-xl font-bold text-slate-700">
            Elementos registrados
        </h3>

        <a href="{{ route('check-items.create') }}"
           class="gp-card-button">
            Nuevo Item
        </a>

    </div>

    <div class="gp-table-container">

        <table class="gp-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Sección</th>
                    <th>Nombre</th>
                    <th>Orden</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($checkItems as $item)

                    <tr>

                        <td>{{ $item->id }}</td>

                        <td>{{ $item->area->nombre }}</td>

                        <td>{{ $item->seccion }}</td>

                        <td>{{ $item->nombre }}</td>

                        <td>{{ $item->orden }}</td>

                        <td>

                            @if($item->activo)

                                <span class="gp-badge-success">
                                    Activo
                                </span>

                            @else

                                <span class="gp-badge-danger">
                                    Inactivo
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('check-items.edit', $item) }}"
                               class="gp-table-button">
                                Editar
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-6">

                            No hay items registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</x-app-layout>