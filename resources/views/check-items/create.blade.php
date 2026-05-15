<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">
                Nuevo Check Item
            </h2>

            <p class="gp-header-subtitle">
                Crear nuevo elemento de verificación.
            </p>
        </div>
    </x-slot>

    <div class="gp-form-container">

        <form method="POST"
              action="{{ route('check-items.store') }}">

            @csrf

            <div class="gp-form-group">

                <label class="gp-label">
                    Área
                </label>

                <select name="area_id"
                        class="gp-input"
                        required>

                    <option value="">
                        Seleccione un área
                    </option>

                    @foreach($areas as $area)

                        <option value="{{ $area->id }}">
                            {{ $area->nombre }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Sección
                </label>

                <input type="text"
                       name="seccion"
                       class="gp-input"
                       required>

            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Nombre
                </label>

                <input type="text"
                       name="nombre"
                       class="gp-input"
                       required>

            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Orden
                </label>

                <input type="number"
                       name="orden"
                       class="gp-input"
                       required>

            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Estado
                </label>

                <select name="activo"
                        class="gp-input">

                    <option value="1">
                        Activo
                    </option>

                    <option value="0">
                        Inactivo
                    </option>

                </select>

            </div>

            <div class="flex gap-4 mt-6">

                <button type="submit"
                        class="gp-card-button">

                    Guardar Item

                </button>

                <a href="{{ route('check-items.index') }}"
                   class="gp-secondary-button">

                    Cancelar

                </a>

            </div>

        </form>

    </div>

</x-app-layout>