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

            <a href="{{ route('infraestructuras.create') }}"
               class="gp-action-btn primary">
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
                            <td>{{ $infraestructura->area->nombre }}</td>

                            <td>{{ $infraestructura->nombre }}</td>

                            <td>{{ $infraestructura->codigo ?? '-' }}</td>

                            <td>
                                @if($infraestructura->activo)
                                    <span class="gp-badge-success">Activo</span>
                                @else
                                    <span class="gp-badge-danger">Inactivo</span>
                                @endif
                            </td>

                            <td class="gp-action-group">

                                <a href="{{ route('infraestructuras.edit', $infraestructura) }}"
                                   class="gp-view-button">

                                    Editar
                                </a>

                                <form method="POST"
                                      action="{{ route('infraestructuras.destroy', $infraestructura) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="gp-delete-button">
                                        Eliminar
                                    </button>
                                </form>

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