<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                     Gestión de Áreas
                </h2>

                <p class="gp-header-subtitle">
                    Administración de áreas preoperacionales del sistema.
                </p>
            </div>

            <div class="gp-header-actions">
                <a href="{{ route('administrador.dashboard') }}"
                    class="gp-action-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
                    <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
                    </svg> Volver
                </a>

                <a href="{{ route('areas.create') }}"
                    class="gp-action-btn primary">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Add</title>
                    <polygon points="17,15 17,8 15,8 15,15 8,15 8,17 15,17 15,24 17,24 17,17 24,17 24,15 "/>
                     </svg> Nueva Área
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
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Edit</title>
<title>edit</title>
<rect x="2" y="26" width="28" height="2"/>
<path d="M25.4,9c0.8-0.8,0.8-2,0-2.8c0,0,0,0,0,0l-3.6-3.6c-0.8-0.8-2-0.8-2.8,0c0,0,0,0,0,0l-15,15V24h6.4L25.4,9z M20.4,4L24,7.6
	l-3,3L17.4,7L20.4,4z M6,22v-3.6l10-10l3.6,3.6l-10,10H6z"/>
</svg> Editar
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