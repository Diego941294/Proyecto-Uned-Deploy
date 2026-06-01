<x-app-layout>

    <div class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Editar Infraestructura
                </h2>

                <p class="gp-header-subtitle">
                    Actualice la información de la infraestructura seleccionada.
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
                  action="{{ route('infraestructuras.update', $infraestructura) }}">

                @csrf
                @method('PUT')

                <div class="gp-form-group">
                    <label class="gp-label">
                        Área
                    </label>

                    <select name="area_id"
                            class="gp-input"
                            required>

                        @foreach($areas as $area)
                            <option value="{{ $area->id }}"
                                @selected(old('area_id', $infraestructura->area_id) == $area->id)>
                                {{ $area->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">
                        Código asignado
                    </label>

                    <div class="gp-code-preview">
                        {{ $infraestructura->codigo ?? 'Sin código' }}
                    </div>

                    <p class="gp-help-text">
                        Este código se asignó automáticamente al crear la infraestructura y no puede ser modificado.
                    </p>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           class="gp-input"
                           value="{{ old('nombre', $infraestructura->nombre) }}"
                           required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">
                        Estado
                    </label>

                    <select name="activo"
                            class="gp-input"
                            required>

                        <option value="1"
                            @selected(old('activo', $infraestructura->activo) == 1)>
                            Activo
                        </option>

                        <option value="0"
                            @selected(old('activo', $infraestructura->activo) == 0)>
                            Inactivo
                        </option>

                    </select>
                </div>

                <div class="gp-report-actions">

                    <button type="submit"
                            class="gp-action-btn primary">
                        Guardar cambios
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