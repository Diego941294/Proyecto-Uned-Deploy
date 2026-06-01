<x-app-layout>

    <div class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Nueva Infraestructura
                </h2>

                <p class="gp-header-subtitle">
                    Registrar una nueva sección o infraestructura.
                </p>
            </div>

            <a href="{{ route('infraestructuras.index') }}"
                class="gp-action-btn secondary">
                ← Volver
            </a>

        </div>
    </div>

    <div class="gp-form-shell">

        <div class="gp-form-card">

            <form method="POST"
                action="{{ route('infraestructuras.store') }}">

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
                        Nombre
                    </label>

                    <input type="text"
                        name="nombre"
                        class="gp-input"
                        required>

                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Código asignado</label>

                    <div class="gp-code-preview">
                        {{ $codigoSugerido }}
                    </div>

                    <p class="gp-help-text">
                        Este código será asignado automáticamente al guardar.
                    </p>
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

                <div class="gp-report-actions">

                    <button type="submit"
                        class="gp-action-btn primary">

                        Guardar
                    </button>

                    <a href="{{ route('infraestructuras.index') }}"
                        class="gp-action-btn secondary">

                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>