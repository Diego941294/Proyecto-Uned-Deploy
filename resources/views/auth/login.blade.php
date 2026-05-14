<x-guest-layout>
    <section class="employee-login-card">

        <div class="auth-brand">
            <img src="{{ asset('images/guana-pollo-logo.png') }}" alt="Guana Pollo" class="auth-brand-logo">
            <div class="auth-subtitle">
                <span></span>
                <p>Sistema Preoperacional</p>
                <span></span>
            </div>

            <p class="auth-welcome">
                Bienvenido, inicia sesión para continuar con el sistema.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            <div class="auth-field mb-3">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" placeholder="Correo electrónico" class="form-control form-control-lg">
            </div>
            <x-input-error :messages="$errors->get('email')" class="auth-error" />

            <div class="auth-field mb-3">

                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Contraseña">
            </div>
            <x-input-error :messages="$errors->get('password')" class="auth-error" />

            <div class="auth-options">
                <label class="auth-remember">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="auth-submit">
                Iniciar sesión
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('register') }}">
                    ¿No tienes una cuenta? Regístrate
                </a>
            </div>



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
        © {{ date('Y') }} Guana Pollo. Todos los derechos reservados.
    </footer>
</x-guest-layout>