<x-guest-layout>
    <section class="employee-login-card">
        <div class="auth-brand">
            <img src="{{ asset('images/guana-pollo-logo.png') }}" alt="Guana Pollo" class="auth-brand-logo">

            <h1>Guana Pollo</h1>

            <div class="auth-subtitle">
                <span></span>
                <p>Recuperar contraseña</p>
                <span></span>
            </div>

            <p class="auth-welcome">
                Ingresa tu correo electrónico y te enviaremos un enlace seguro para restablecer tu contraseña.
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="auth-field">
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="Correo electrónico"
                >
            </div>

            <x-input-error :messages="$errors->get('email')" class="auth-error" />

            <button type="submit" class="auth-submit">
                Enviar enlace de recuperación
            </button>

            <p class="auth-access-text" style="margin-top: 18px;">
                <a href="{{ route('login') }}">Volver al inicio de sesión</a>
            </p>
        </form>
    </section>
    <footer class="auth-footer">
        © {{ date('Y') }} Guana Pollo. Todos los derechos reservados.
    </footer>
    
</x-guest-layout>