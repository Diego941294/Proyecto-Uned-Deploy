<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Información del Perfil
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Actualice su información personal y fotografía.
        </p>
    </header>

    <form id="send-verification"
          method="post"
          action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="gp-profile-form">

        @csrf
        @method('PATCH')

        <div class="gp-form-group">
            <label for="photo" class="gp-label">
                Fotografía de perfil
            </label>

            <input
                type="file"
                id="photo"
                name="photo"
                accept=".jpg,.jpeg,.png,.webp"
                class="gp-file-input">

            <x-input-error
                class="mt-2"
                :messages="$errors->get('photo')" />
        </div>

        <div class="gp-form-group">
            <label for="name" class="gp-label">
                Nombre
            </label>

            <input
                id="name"
                name="name"
                type="text"
                class="gp-input"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name">

            <x-input-error
                class="mt-2"
                :messages="$errors->get('name')" />
        </div>

        <div class="gp-form-group">
            <label for="email" class="gp-label">
                Correo electrónico
            </label>

            <input
                id="email"
                name="email"
                type="email"
                class="gp-input"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username">

            <x-input-error
                class="mt-2"
                :messages="$errors->get('email')" />
        </div>

        <div class="gp-form-actions">

            <button type="submit" class="gp-action-btn primary">
                Guardar cambios
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="gp-profile-success">

                    Perfil actualizado correctamente.

                </p>
            @endif

        </div>

    </form>

</section>