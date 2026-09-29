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
                    ← Volver
                </a>

                <a
                    href="{{ route('usuarios.create') }}"
                    class="gp-action-btn primary">
                    + Nuevo Usuario
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

                                <span
                                    style="
                                                    font-size: 12px;
                                                    color: #64748b;
                                                ">
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

/* ==========================================
   ACCIONES - GESTIÓN DE USUARIOS
========================================== */

        .gp-action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .gp-action-group form {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        /* Tamaño idéntico para todas las acciones */
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

            transition:
                background-color .2s ease,
                color .2s ease,
                border-color .2s ease,
                transform .15s ease;
        }

        /* EDITAR */
        .gp-action-group .gp-view-button {
            background: #e8f1fc;
            color: #0b63d8;
            border-color: #e8f1fc;
            cursor: pointer;
        }

        .gp-action-group .gp-view-button:hover,
        .gp-action-group .gp-view-button:focus,
        .gp-action-group .gp-view-button:active,
        .gp-action-group .gp-view-button:visited {
            text-decoration: none !important;
        }

        .gp-action-group .gp-view-button:hover {
            background: #d7e8fa;
            color: #084fae;
            border-color: #d7e8fa;
        }

        /* DESHABILITAR */
        .gp-action-group .gp-delete-button {
            background: #fee2e2;
            color: #b91c1c;
            border-color: #fee2e2;
            cursor: pointer;
        }

        .gp-action-group .gp-delete-button:hover,
        .gp-action-group .gp-delete-button:focus,
        .gp-action-group .gp-delete-button:active {
            background: #fecaca;
            color: #991b1b;
            border-color: #fecaca;
            text-decoration: none !important;
        }

        /* HABILITAR */
        .gp-action-group .gp-enable-button {
            background: #d1fae5;
            color: #047857;
            border-color: #d1fae5;
            cursor: pointer;
        }

        .gp-action-group .gp-enable-button:hover {
            background: #a7f3d0;
            color: #065f46;
            border-color: #a7f3d0;
        }

        /* TU CUENTA */
        .gp-action-group .gp-account-badge {
            background: #fef3c7;
            color: #a16207;
            border-color: #fef3c7;
        }

        /* Al presionar  */
        .gp-action-group .gp-view-button:active,
        .gp-action-group .gp-delete-button:active,
        .gp-action-group .gp-enable-button:active {
            transform: translateY(1px);
        }
    </style>




</x-app-layout>