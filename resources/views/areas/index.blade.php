<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    🏭 Gestión de Áreas
                </h2>

                <p class="gp-header-subtitle">
                    Administración de áreas preoperacionales del sistema.
                </p>
            </div>

            <div class="gp-header-actions">
                <a href="{{ route('administrador.dashboard') }}"
                    class="gp-action-btn secondary">
                    ← Volver
                </a>

                <a href="{{ route('areas.create') }}"
                    class="gp-action-btn primary">
                    + Nueva Área
                </a>
            </div>

        </div>
    </section>

    <div class="gp-reports-panel">

        <div class="gp-reports-toolbar">
            <div>
                <h3>
                    Áreas registradas ({{ $areas->count() }})
                </h3>
                <p>Consulta y administra las áreas disponibles del sistema.</p>
            </div>
        </div>

        <div class="gp-table-modern-wrap">

            <table class="gp-table-modern">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($areas as $area)

                    <tr>
                        <td>#{{ $area->id }}</td>

                        <td>
                            <strong>{{ $area->nombre }}</strong>
                        </td>

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

                        <td class="text-center">

                            <div class="gp-action-group">

                                <a href="{{ route('areas.edit', $area) }}"
                                    class="gp-view-button">

                                    ✏️ Editar

                                </a>

                                <form method="POST"
                                    action="{{ route('areas.destroy', $area) }}"
                                    onsubmit="return confirm(
                '¿Está seguro de eliminar esta área? Esta acción no se puede deshacer.'
              );">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="gp-delete-button">

                                        🗑 Eliminar

                                    </button>

                                </form>

                            </div>

                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="gp-empty-table">
                            No hay áreas registradas.
                        </td>
                    </tr>

                    @endforelse
                </tbody>

            </table>

        </div>

    </div>



    <style>
        .gp-table-modern td:nth-child(3) {
            max-width: 350px;
            white-space: normal;
            line-height: 1.5;
        }

        .gp-table-modern td:nth-child(4) {
            text-align: center;
        }

        .gp-action-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .gp-view-button,
        .gp-delete-button {
            min-width: 90px;
        }
    </style>


</x-app-layout>