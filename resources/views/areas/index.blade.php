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
                        
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($areas as $area)

                    <tr>

                       

                        <td data-label="Nombre">
                            <strong>
                                {{ $area->nombre }}
                            </strong>
                        </td>

                        <td data-label="Descripción">
                            {{ $area->descripcion ?? 'Sin descripción' }}
                        </td>

                        <td data-label="Estado">

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

                        <td data-label="Acciones"  class="text-center">

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


s

</x-app-layout>