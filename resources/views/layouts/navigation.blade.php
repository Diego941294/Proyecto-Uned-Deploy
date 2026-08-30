@php
    if (auth()->user()->hasRole('super-admin')) {
        $rutaHome = route('super-admin.dashboard');
    } elseif (auth()->user()->hasRole('administrador')) {
        $rutaHome = route('administrador.dashboard');
    } else {
        $rutaHome = route('supervisor.dashboard');
    }
@endphp

<nav
    x-data="{
        open: false,
        userMenuOpen: false
    }"
    class="gp-navbar"
>
    <div class="gp-navbar-inner">

        <a href="{{ $rutaHome }}" class="gp-brand">

            <img
                src="{{ asset('images/guana-pollo-logo.png') }}"
                alt="Guana Pollo"
                class="gp-brand-logo"
            >

            <div>
                <h1>Guana Pollo</h1>
                <p>Sistema Preoperacional</p>
            </div>

        </a>


        <div class="gp-nav-links">

            @role('Supervisor')
                <a
                    href="{{ route('supervisor.dashboard') }}"
                    class="gp-nav-link"
                >
                    Supervisor
                </a>
            @endrole


            @role('Administrador')
                <a
                    href="{{ route('administrador.dashboard') }}"
                    class="gp-nav-link"
                >
                    Administrador
                </a>
            @endrole

        </div>


        <div class="gp-nav-actions">

            <button
                type="button"
                onclick="toggleDarkMode()"
                class="gp-dark-toggle"
                style="margin-right: 40px;"
            >
                🌙 Modo oscuro
            </button>


            <div class="gp-user-box">

                {{-- Dropdown usuario --}}
                <div
                    class="gp-user-dropdown"
                    @click.outside="userMenuOpen = false"
                >

                    <button
                        type="button"
                        class="gp-user-dropdown-trigger"
                        @click="userMenuOpen = !userMenuOpen"
                    >

                        <span>
                            {{ Auth::user()->name }}
                        </span>

                        <span
                            class="gp-user-dropdown-arrow"
                            :class="{ 'open': userMenuOpen }"
                        >
                            ▾
                        </span>

                    </button>


                    <div
                        x-show="userMenuOpen"
                        x-transition
                        class="gp-user-dropdown-menu"
                        style="display: none;"
                    >

                        <div class="gp-user-dropdown-header">

                            <strong>
                                {{ Auth::user()->name }}
                            </strong>

                            <span>
                                @role('Supervisor')
                                    Supervisor de Calidad
                                @endrole

                                @role('Administrador')
                                    Administrador de Calidad
                                @endrole

                                @role('super-admin')
                                    Super Administrador
                                @endrole
                            </span>

                        </div>


                        <div class="gp-user-dropdown-divider"></div>


                        <a
                            href="{{ route('profile.edit') }}"
                            class="gp-user-dropdown-link"
                        >
                            👤 Mi Perfil
                        </a>

                    </div>

                </div>


                {{-- Cerrar sesión --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="gp-logout-btn"
                    >
                        Salir
                    </button>

                </form>

            </div>

        </div>


        <button
            type="button"
            @click="open = !open"
            class="gp-mobile-btn"
        >
            ☰
        </button>

    </div>


    {{-- MENÚ MÓVIL --}}
    <div
        x-show="open"
        class="gp-mobile-menu"
    >

        @role('Supervisor')
            <a href="{{ route('supervisor.dashboard') }}">
                Supervisor
            </a>
        @endrole


        @role('Administrador')
            <a href="{{ route('administrador.dashboard') }}">
                Administrador
            </a>
        @endrole


        <a href="{{ route('profile.edit') }}">
            Mi Perfil
        </a>


        <button
            type="button"
            onclick="toggleDarkMode()"
        >
            🌙 Modo oscuro
        </button>


        <form
            method="POST"
            action="{{ route('logout') }}"
        >
            @csrf

            <button type="submit">
                Cerrar sesión
            </button>
        </form>

    </div>


    <style>

        /* ===============================
           DROPDOWN USUARIO
        =============================== */

        .gp-user-dropdown {
            position: relative;
        }


        .gp-user-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 7px;

            border: none;
            background: transparent;

            color: #0f2f5f;

            font-family: inherit;
            font-size: 14px;
            font-weight: 800;

            cursor: pointer;

            padding: 9px 12px;

            border-radius: 10px;

            transition:
                background .2s ease,
                color .2s ease;
        }


        .gp-user-dropdown-trigger:hover {
            background: #eaf2ff;
            color: #0b63d8;
        }


        .gp-user-dropdown-arrow {
            font-size: 12px;
            transition: transform .2s ease;
        }


        .gp-user-dropdown-arrow.open {
            transform: rotate(180deg);
        }


        .gp-user-dropdown-menu {
            position: absolute;

            top: calc(100% + 10px);
            right: 0;

            width: 245px;

            background: #ffffff;

            border: 1px solid #dbe8f3;

            border-radius: 14px;

            box-shadow:
                0 16px 40px rgba(15, 47, 95, .16);

            z-index: 100;

            overflow: hidden;
        }


        .gp-user-dropdown-header {
            padding: 16px;
        }


        .gp-user-dropdown-header strong {
            display: block;

            color: #0f2f5f;

            font-size: 14px;
            font-weight: 900;
        }


        .gp-user-dropdown-header span {
            display: block;

            margin-top: 4px;

            color: #64748b;

            font-size: 12px;
            font-weight: 700;
        }


        .gp-user-dropdown-divider {
            height: 1px;
            background: #e2e8f0;
        }


        .gp-user-dropdown-link {
            display: block;

            padding: 13px 16px;

            color: #0b63d8;

            text-decoration: none;

            font-size: 14px;
            font-weight: 800;

            transition:
                background .2s ease,
                color .2s ease;
        }


        .gp-user-dropdown-link:hover {
            background: #eaf2ff;
            color: #084fae;
        }


        /* ===============================
           DARK MODE
        =============================== */

        body.dark-mode .gp-user-dropdown-trigger {
            color: #eaf3ff;
        }


        body.dark-mode .gp-user-dropdown-trigger:hover {
            background: #14233d;
            color: #69b6ff;
        }


        body.dark-mode .gp-user-dropdown-menu {
            background: #0d192d;

            border-color:
                rgba(99, 170, 255, .25);
        }


        body.dark-mode .gp-user-dropdown-header strong {
            color: #ffffff;
        }


        body.dark-mode .gp-user-dropdown-header span {
            color: #b8c7dd;
        }


        body.dark-mode .gp-user-dropdown-divider {
            background:
                rgba(99, 170, 255, .18);
        }


        body.dark-mode .gp-user-dropdown-link {
            color: #69b6ff;
        }


        body.dark-mode .gp-user-dropdown-link:hover {
            background: #14233d;
            color: #ffffff;
        }

    </style>

</nav>