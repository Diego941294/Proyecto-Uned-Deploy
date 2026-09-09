<x-app-layout>

    <div class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">
                    Infraestructuras
                </h2>

                <p class="gp-header-subtitle">
                    Administración de secciones e infraestructura.
                </p>
            </div>

            <a href="{{ route('infraestructuras.create') }}" class="gp-action-btn primary">
                + Nueva Infraestructura
            </a>
        </div>
    </div>

    <div class="gp-reports-panel">

        <div class="gp-table-modern-wrap">

            <table class="gp-table-modern">

                <thead>
                    <tr>
                        <th>Área</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($infraestructuras as $infraestructura)

                        <tr>

                            <td data-label="Área">
                                {{ $infraestructura->area?->nombre ?? 'Área no disponible' }}
                            </td>

                            <td data-label="Nombre">
                                {{ $infraestructura->nombre }}
                            </td>

                            <td data-label="Código">
                                {{ $infraestructura->codigo ?? '-' }}
                            </td>

                            <td data-label="Estado">

                                @if($infraestructura->activo)

                                    <span class="gp-badge-success">
                                        Activo
                                    </span>

                                @else

                                    <span class="gp-badge-danger">
                                        Inactivo
                                    </span>

                                @endif

                            </td>

                            <td data-label="Acciones" class="text-center">

                                <div class="gp-action-group">

                                    <a href="{{ route('infraestructuras.edit', $infraestructura) }}" class="gp-view-button">
                                        Editar
                                    </a>


                                    <form method="POST"
                                        action="{{ route('infraestructuras.toggle-activo', $infraestructura) }}"
                                        @if($infraestructura->activo)
                                        onsubmit="return confirm('¿Está seguro de desactivar esta infraestructura?');" @else
                                        onsubmit="return confirm('¿Está seguro de activar esta infraestructura?');" @endif>

                                        @csrf
                                        @method('PATCH')


                                        @if($infraestructura->activo)

                                            <button type="submit" class="gp-delete-button">
                                                Desactivar
                                            </button>

                                        @else

                                            <button type="submit" class="gp-activate-button">
                                                Activar
                                            </button>

                                        @endif

                                    </form>
                                </div>


                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="gp-empty-table">
                                No existen infraestructuras registradas.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>



</x-app-layout>