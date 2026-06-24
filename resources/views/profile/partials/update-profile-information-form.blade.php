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

    <form method="post"
          action="{{ route('profile.update') }}"
          enctype="multipart/form-data"
          class="mt-6 space-y-6">

        @csrf
        @method('patch')

        <div>
            <x-input-label for="photo" value="Fotografía de perfil" />

            <input
                type="file"
                id="photo"
                name="photo"
                accept="image/*"
                class="mt-2 block w-full border rounded-lg p-2">

            <x-input-error class="mt-2"
                           :messages="$errors->get('photo')" />
        </div>

        <div>
            <x-input-label for="name" value="Nombre" />

            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                autofocus />
        </div>

        <div>
            <x-input-label for="email" value="Correo electrónico" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required />

            <x-input-error class="mt-2"
                           :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">

            <x-primary-button>
                Guardar Cambios
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600">

                    Perfil actualizado correctamente.

                </p>
            @endif

        </div>

    </form>

</section>