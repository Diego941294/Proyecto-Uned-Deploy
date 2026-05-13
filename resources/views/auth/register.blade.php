<x-guest-layout>
    <section class="employee-login-card">
        <div class="auth-brand">
            <img src="{{ asset('images/guana-pollo-logo.png') }}" alt="Guana Pollo" class="auth-brand-logo">

            <h1>Guana Pollo</h1>

            <div class="auth-subtitle">
                <span></span>
                <p>REGISTRO DE EMPLEADOS </p>
                <span></span>
            </div>

            <p class="auth-welcome">
                Ingrese los datos requeridos para quedar registrado en el sistema.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <!-- Nombre -->
            <div class="auth-field">
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Nombre completo">
            </div>
            <x-input-error :messages="$errors->get('name')" class="auth-error" />

            <!-- Correo -->
            <div class="auth-field">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="Correo electrónico">
            </div>
            <x-input-error :messages="$errors->get('email')" class="auth-error" />

            <!-- Contraseña -->
            <div class="auth-field">
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Contraseña">
            </div>
            <x-input-error :messages="$errors->get('password')" class="auth-error" />

            <!-- Confirmar contraseña -->
            <div class="auth-field">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Confirmar contraseña">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />

            <!-- Opciones -->
            <div class="auth-options">
                <a href="{{ route('login') }}">
                    ¿Ya estás registrado?
                </a>
            </div>

            <!-- Botón -->
            <button type="submit" class="auth-submit">
                Registrarse
            </button>

            <!-- Seguridad -->
            <div class="auth-security">
                <div class="auth-line"></div>
                <span>🛡</span>
                <div class="auth-line"></div>
            </div>

            <p class="auth-access-text">
                Acceso exclusivo para empleados autorizados
            </p>
        </form>
    </section>


    <footer class="auth-footer">
        <p>&copy; {{ date('Y') }} Guana Pollo. Todos los derechos reservados.</p>
    </footer>

</x-guest-layout>