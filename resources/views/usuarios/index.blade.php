<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">
                    Usuarios del sistema
                </h2>

                <p class="gp-header-subtitle">
                    Administración de usuarios, roles
                    y estados de las cuentas.
                </p>
            </div>

            <div class="gp-header-actions">
                <a
                    href="{{ route('super-admin.dashboard') }}"
                    class="gp-action-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
                    <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
                     </svg>Volver
                </a>

                <a
                    href="{{ route('usuarios.create') }}"
                    class="gp-action-btn primary">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Add</title>
                    <polygon points="17,15 17,8 15,8 15,15 8,15 8,17 15,17 15,24 17,24 17,17 24,17 24,15 "/>
                    </svg> Nuevo Usuario
                </a>
            </div>
        </div>
    </section>

    <div class="gp-reports-panel">

        {{-- Mensajes de confirmación --}}

        @if (session('success'))
        <div
            role="status"
            style="
                    margin-bottom: 16px;
                    padding: 12px 16px;
                    border-radius: 8px;
                    background-color: #dcfce7;
                    color: #166534;
                ">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div
            role="alert"
            style="
                    margin-bottom: 16px;
                    padding: 12px 16px;
                    border-radius: 8px;
                    background-color: #fee2e2;
                    color: #991b1b;
                ">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div
            role="alert"
            style="
                    margin-bottom: 16px;
                    padding: 12px 16px;
                    border-radius: 8px;
                    background-color: #fee2e2;
                    color: #991b1b;
                ">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="gp-reports-toolbar">
            <div>
                <h3>Usuarios registrados</h3>

                <p>
                    Consulta, edita, deshabilita o
                    habilita las cuentas del sistema.
                </p>
            </div>
        </div>

        <div class="gp-table-modern-wrap">

            <table class="gp-table-modern">

                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-center">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($usuarios as $usuario)

                    <tr>

                        <td data-label="Nombre">
                            {{ $usuario->name }}
                        </td>

                        <td data-label="Correo">
                            {{ $usuario->email }}
                        </td>

                        <td data-label="Rol">
                            {{
                                    $usuario->roles
                                        ->pluck('name')
                                        ->join(', ') ?: 'Sin rol'
                                }}
                        </td>

                        <td data-label="Estado">

                            @if ($usuario->activo)

                            <span
                                style="
                                            display: inline-block;
                                            padding: 5px 12px;
                                            border-radius: 20px;
                                            background: #dcfce7;
                                            color: #166534;
                                            font-size: 13px;
                                            font-weight: 600;
                                        ">
                                Activo
                            </span>

                            @else

                            <span
                                style="
                                            display: inline-block;
                                            padding: 5px 12px;
                                            border-radius: 20px;
                                            background: #fee2e2;
                                            color: #991b1b;
                                            font-size: 13px;
                                            font-weight: 600;
                                        ">
                                Deshabilitado
                            </span>

                            @endif

                        </td>

                        <td
                            data-label="Acciones"
                            class="text-center">

                            <div class="gp-action-group">

                                {{-- Editar usuario --}}

                                <a
                                    href="{{ route('usuarios.edit', $usuario) }}"
                                    class="gp-view-button">
                                    Editar
                                </a>

                                {{-- Deshabilitar usuario activo --}}

                                @if ($usuario->activo)

                                @if (
                                (string) auth()->id() !==
                                (string) $usuario->getKey()
                                )

                                <form
                                    method="POST"
                                    action="{{ route('usuarios.destroy', $usuario) }}"
                                    onsubmit="return confirm('¿Desea deshabilitar a {{ $usuario->name }}? Su cuenta y su rol se conservarán, pero no podrá acceder al sistema.');">
                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="gp-delete-button">
                                        Deshabilitar
                                    </button>

                                </form>

                                @else

                               <span class="gp-account-badge">
                                Tu cuenta
                                </span>

                                @endif

                                @else

                                {{-- Rehabilitar usuario inactivo --}}

                                <form
                                    method="POST"
                                    action="{{ route('usuarios.habilitar', $usuario) }}"
                                    onsubmit="return confirm('¿Desea habilitar nuevamente a {{ $usuario->name }}? Recuperará el acceso con su rol anterior.');">
                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="gp-view-button"
                                        style="
                                                    background-color: #15803d;
                                                    color: #ffffff;
                                                ">
                                        Habilitar
                                    </button>

                                </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td
                            colspan="5"
                            class="gp-empty-table">
                            No hay usuarios registrados.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

<style>
/* ACCIONES - GESTIÓN DE USUARIOS */

.gp-action-group {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    gap: 10px;
    white-space: nowrap;
}

.gp-action-group > * {
    flex-shrink: 0;
}

.gp-action-group form {
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
}

/* TAMAÑO UNIFORME */

.gp-action-group .gp-view-button,
.gp-action-group .gp-delete-button,
.gp-action-group .gp-enable-button,
.gp-action-group .gp-account-badge {
    box-sizing: border-box;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 106px;
    height: 38px;
    padding: 0 12px;
    border: 1px solid transparent;
    border-radius: 999px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    line-height: 1;
    text-decoration: none !important;
    white-space: nowrap;
    flex-shrink: 0;
}

/* EDITAR */

.gp-action-group .gp-view-button {
    background: #e8f1fc;
    color: #0b63d8;
    border-color: #e8f1fc;
    cursor: pointer;
}

.gp-action-group .gp-view-button:hover {
    background: #d7e8fa;
    color: #084fae;
}

/* DESHABILITAR */

.gp-action-group .gp-delete-button {
    background: #fee2e2;
    color: #b91c1c;
    border-color: #fee2e2;
    cursor: pointer;
}

.gp-action-group .gp-delete-button:hover {
    background: #fecaca;
    color: #991b1b;
}

/* HABILITAR */

.gp-action-group .gp-enable-button {
    background: #d1fae5;
    color: #047857;
    border-color: #d1fae5;
    cursor: pointer;
}

/* TU CUENTA - GRIS */

.gp-action-group .gp-account-badge {
    background: #e2e8f0;
    color: #475569;
    border-color: #e2e8f0;
    cursor: default;
}

/* EFECTO AL PRESIONAR */

.gp-action-group .gp-view-button:active,
.gp-action-group .gp-delete-button:active,
.gp-action-group .gp-enable-button:active {
    transform: translateY(1px);
}

 
@media (max-width: 768px) {

    .gp-action-group {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
    }

    .gp-action-group > a,
    .gp-action-group > form,
    .gp-action-group > .gp-account-badge {
        flex: 1 1 0;
        min-width: 0;
    }

    .gp-action-group form {
        display: flex;
        margin: 0;
    }

    .gp-action-group .gp-view-button,
    .gp-action-group .gp-delete-button,
    .gp-action-group .gp-enable-button,
    .gp-action-group .gp-account-badge {
        width: 100%;
        min-width: 0;
        height: 38px;
        padding: 0 6px;
        box-sizing: border-box;
        white-space: nowrap;
        text-align: center;
        font-size: 12px;
        border-radius: 999px;
    }
}
</style>




</x-app-layout>