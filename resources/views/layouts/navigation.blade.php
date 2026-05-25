<nav x-data="{ open: false }" class="gp-navbar">
    <div class="gp-navbar-inner">

        <a href="{{ route('administrador.dashboard') }}" class="gp-brand">
            <img src="{{ asset('images/guana-pollo-logo.png') }}" alt="Guana Pollo" class="gp-brand-logo">

            <div>
                <h1>Guana Pollo</h1>
                <p>Sistema Preoperacional</p>
            </div>
        </a>

        <div class="gp-nav-links">
            @role('Supervisor')
                <a href="{{ route('supervisor.dashboard') }}" class="gp-nav-link">
                    Supervisor
                </a>
            @endrole

            @role('Administrador')
                <a href="{{ route('administrador.dashboard') }}" class="gp-nav-link">
                    Administrador
                </a>
            @endrole
        </div>

        <div class="gp-nav-actions">
            <button onclick="toggleDarkMode()" class="gp-dark-toggle" style="margin-right: 40px;">
                🌙 Modo oscuro
            </button>

            <div class="gp-user-box">
                <div class="gp-user-info">
                    <strong>{{ Auth::user()->name }}</strong>
                    <span>
                        @role('Supervisor')
                            Supervisor de Calidad
                        @endrole

                        @role('Administrador')
                            Administrador de Calidad
                        @endrole
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="gp-logout-btn">
                        Salir
                    </button>
                </form>
            </div>
        </div>

        <button @click="open = !open" class="gp-mobile-btn">
            ☰
        </button>
    </div>

    <div x-show="open" class="gp-mobile-menu">

        @role('Supervisor')
            <a href="{{ route('supervisor.dashboard') }}">Supervisor</a>
        @endrole

        @role('Administrador')
            <a href="{{ route('administrador.dashboard') }}">Administrador</a>
        @endrole

        <button type="button" onclick="toggleDarkMode()">
            🌙 Modo oscuro
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                Cerrar sesión
            </button>
        </form>

    </div>
</nav>