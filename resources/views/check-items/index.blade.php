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
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
                    <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
                    </svg>Volver
                </a>

                <a
                    href="{{ route('check-items.create') }}"
                    class="gp-action-btn primary"
                >
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Add</title>
                    <polygon points="17,15 17,8 15,8 15,15 8,15 8,17 15,17 15,24 17,24 17,17 24,17 24,15 "/>
                    </svg> Nuevo Item
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

                            <td data-label="Área">

                                <strong>
                                    {{ $item->infraestructura?->area?->nombre ?? 'Área no disponible' }}
                                </strong>

                            </td>


                            <td data-label="Infraestructura">
                                {{ $item->infraestructura?->nombre ?? 'Infraestructura no disponible' }}
                            </td>


                            <td data-label="Nombre">
                                {{ $item->nombre }}
                            </td>


                            <td data-label="Orden">
                                {{ $item->orden }}
                            </td>


                            <td data-label="Estado">

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


                            <td data-label="Acciones" class="text-center">

                                <div class="gp-action-group">

                                    <a
                                        href="{{ route('check-items.edit', $item) }}"
                                        class="gp-view-button"
                                    >
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                    width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Edit</title>
                                        <title>edit</title>
                                        <rect x="2" y="26" width="28" height="2"/>
                                        <path d="M25.4,9c0.8-0.8,0.8-2,0-2.8c0,0,0,0,0,0l-3.6-3.6c-0.8-0.8-2-0.8-2.8,0c0,0,0,0,0,0l-15,15V24h6.4L25.4,9z M20.4,4L24,7.6
	                                    l-3,3L17.4,7L20.4,4z M6,22v-3.6l10-10l3.6,3.6l-10,10H6z"/>
                                        </svg>Editar
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('check-items.toggle-activo', $item) }}"

                                        @if($item->activo)
                                            onsubmit="return confirm('¿Está seguro de desactivar este Check Item?');"
                                        @else
                                            onsubmit="return confirm('¿Está seguro de activar este Check Item?');"
                                        @endif
                                    >

                                        @csrf
                                        @method('PATCH')


                                        @if($item->activo)

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


    <style>

        .gp-action-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }


        .gp-view-button,
        .gp-delete-button,
        .gp-activate-button {
            min-width: 100px;
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