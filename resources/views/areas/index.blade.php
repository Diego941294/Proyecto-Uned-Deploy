<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">
                Nueva Área
            </h2>

            <p class="gp-header-subtitle">
                Crear una nueva área preoperacional.
            </p>
        </div>
    </x-slot>

    <div class="gp-form-container">

        <form method="POST" action="{{ route('areas.store') }}">

            @csrf

            <div class="gp-form-group">

                <label class="gp-label">
                    Nombre
                </label>

                <input
                    type="text"
                    name="nombre"
                    class="gp-input"
                    required
                >

            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Descripción
                </label>

                <textarea
                    name="descripcion"
                    class="gp-textarea"
                    rows="4"
                ></textarea>

            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Estado
                </label>

                <select
                    name="activo"
                    class="gp-input"
                >
                    <option value="1">Activa</option>
                    <option value="0">Inactiva</option>
                </select>

            </div>

            <div class="flex gap-4 mt-6">

                <button type="submit" class="gp-card-button">
                    Guardar Área
                </button>

                <a href="{{ route('areas.index') }}"
                   class="gp-secondary-button">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</x-app-layout>