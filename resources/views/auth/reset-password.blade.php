<x-guest-layout>
    <section class="employee-login-card">

        <div class="auth-brand">

            <img
                src="{{ asset('images/guana-pollo-logo.png') }}"
                alt="Guana Pollo"
                class="auth-brand-logo"
            >

            <h1>Guana Pollo</h1>

            <div class="auth-subtitle">
                <span></span>
                <p>Nueva contraseña</p>
                <span></span>
            </div>

            <p class="auth-welcome">
                Crea una nueva contraseña segura para continuar utilizando el sistema preoperacional.
            </p>

        </div>

        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="auth-field">
                <span class="auth-icon">✉</span>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Correo electrónico"
                >
            </div>

            <x-input-error :messages="$errors->get('email')" class="auth-error" />

            <div class="auth-field">
                <span class="auth-icon">🔒</span>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Nueva contraseña"
                >
            </div>

            <x-input-error :messages="$errors->get('password')" class="auth-error" />

            <div class="auth-field">
                <span class="auth-icon">🔐</span>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirmar contraseña"
                >
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />

            <button type="submit" class="auth-submit">
                Restablecer contraseña
            </button>

        </form>

        <p class="auth-access-text">
            Acceso exclusivo para empleados autorizados
        </p>

    </section>
</x-guest-layout>