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

                <p>
                    Consulta y administra las áreas disponibles del sistema.
                </p>
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

                        <td>
                            #{{ $area->id_areas }}
                        </td>

                        <td>
                            <strong>
                                {{ $area->nombre }}
                            </strong>
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

                                <a
                                    href="{{ route('areas.edit', $area) }}"
                                    class="gp-view-button">
                                    ✏️ Editar
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('areas.toggle-activo', $area) }}"
                                    @if($area->activo)
                                    onsubmit="return confirm('¿Está seguro de desactivar esta área?');"
                                    @else
                                    onsubmit="return confirm('¿Está seguro de activar esta área?');"
                                    @endif
                                    >
                                    @csrf
                                    @method('PATCH')

                                    @if($area->activo)

                                    <button
                                        type="submit"
                                        class="gp-delete-button">
                                        ⏸ Desactivar
                                    </button>

                                    @else

                                    <button
                                        type="submit"
                                        class="gp-activate-button">
                                        ✓ Activar
                                    </button>

                                    @endif

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="5"
                            class="gp-empty-table">
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
        .gp-delete-button,
        .gp-activate-button {
            min-width: 105px;
        }

        .gp-activate-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            background: #dcfce7;
            color: #166534;
        }

        .gp-activate-button:hover {
            background: #bbf7d0;
        }
    </style>

</x-app-layout>