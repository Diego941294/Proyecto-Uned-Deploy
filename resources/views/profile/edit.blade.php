<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Mi Perfil
                </h2>

                <p class="gp-header-subtitle">
                    Información personal, rol asignado y seguridad de la cuenta.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="gp-action-btn secondary">
                ← Volver
            </a>

        </div>
    </section>

    <div class="gp-profile-layout">

        <aside class="gp-profile-card">

            <div class="gp-profile-avatar">

                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                         alt="Foto de perfil">
                @else
                    <span>
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                @endif

            </div>

            <h3>{{ Auth::user()->name }}</h3>

            <p>{{ Auth::user()->email }}</p>

            <div class="gp-profile-role">
                {{ Auth::user()->roles->pluck('name')->join(', ') ?: 'Sin rol asignado' }}
            </div>

            <div class="gp-profile-meta">
                <strong>Usuario desde</strong>
                <span>{{ Auth::user()->created_at?->format('d/m/Y') }}</span>
            </div>

        </aside>

        <main class="gp-profile-forms">

            <section class="gp-form-card">
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="gp-form-card">
                @include('profile.partials.update-password-form')
            </section>

        </main>

    </div>

</x-app-layout>