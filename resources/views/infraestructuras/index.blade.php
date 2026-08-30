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

                            <td>
                                {{ $infraestructura->area?->nombre ?? 'Área no disponible' }}
                            </td>

                            <td>
                                {{ $infraestructura->nombre }}
                            </td>

                            <td>
                                {{ $infraestructura->codigo ?? '-' }}
                            </td>

                            <td>

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

                            <td class="gp-action-group">

                                <a
                                    href="{{ route('infraestructuras.edit', $infraestructura) }}"
                                    class="gp-view-button"
                                >
                                    Editar
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('infraestructuras.toggle-activo', $infraestructura) }}"

                                    @if($infraestructura->activo)
                                        onsubmit="return confirm('¿Está seguro de desactivar esta infraestructura?');"
                                    @else
                                        onsubmit="return confirm('¿Está seguro de activar esta infraestructura?');"
                                    @endif
                                >

                                    @csrf
                                    @method('PATCH')


                                    @if($infraestructura->activo)

                                        <button
                                            type="submit"
                                            class="gp-delete-button"
                                        >
                                            Desactivar
                                        </button>

                                    @else

                                        <button
                                            type="submit"
                                            class="gp-activate-button"
                                        >
                                            Activar
                                        </button>

                                    @endif

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="gp-empty-table"
                            >
                                No existen infraestructuras registradas.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <style>

        .gp-activate-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
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