<x-app-layout>

    <section class="gp-page-header">

        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Check Items
                </h2>

                <p class="gp-header-subtitle">
                    Administración de elementos de verificación por infraestructura.
                </p>
            </div>

            <div class="gp-header-actions">

                <a
                    href="{{ route('administrador.dashboard') }}"
                    class="gp-action-btn secondary"
                >
                    ← Volver
                </a>

                <a
                    href="{{ route('check-items.create') }}"
                    class="gp-action-btn primary"
                >
                    + Nuevo Item
                </a>

            </div>

        </div>

    </section>


    <div class="gp-reports-panel">

        @if(session('success'))
            <div class="gp-success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="gp-error-message">
                {{ session('error') }}
            </div>
        @endif

        <div class="gp-reports-toolbar">

            <div>
                <h3>
                    Elementos registrados
                </h3>

                <p>
                    Consulta los elementos de verificación del sistema preoperacional.
                </p>
            </div>

        </div>


        <div class="gp-table-modern-wrap">

            <table class="gp-table-modern">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Área</th>
                        <th>Infraestructura</th>
                        <th>Nombre</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th class="text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($checkItems as $item)

                        <tr>

                            <td>
                                #{{ $item->id_check_items }}
                            </td>

                            <td>
                                <strong>
                                    {{ $item->infraestructura?->area?->nombre ?? 'Área no disponible' }}
                                </strong>
                            </td>

                            <td>
                                {{ $item->infraestructura?->nombre ?? 'Infraestructura no disponible' }}
                            </td>

                            <td>
                                {{ $item->nombre }}
                            </td>

                            <td>
                                {{ $item->orden }}
                            </td>

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

                            <td class="text-center">

                                <div class="gp-action-group">

                                    <a
                                        href="{{ route('check-items.edit', $item) }}"
                                        class="gp-view-button"
                                    >
                                        ✏️ Editar
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('check-items.destroy', $item) }}"
                                        onsubmit="return confirm('¿Está seguro de eliminar este Check Item? Esta acción no se puede deshacer.');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="gp-delete-button"
                                        >
                                            🗑 Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="7"
                                class="gp-empty-table"
                            >
                                No hay items registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>