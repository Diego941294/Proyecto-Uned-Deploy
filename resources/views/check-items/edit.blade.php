<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Editar Check Item
                </h2>

                <p class="gp-header-subtitle">
                    Actualizar elemento de verificación del sistema.
                </p>
            </div>

            <a href="{{ route('check-items.index') }}"
                class="gp-action-btn secondary">
                ← Volver
            </a>

        </div>
    </section>

    <div class="gp-form-container">

        <form method="POST"
            action="{{ route('check-items.update', $checkItem) }}">

            @csrf
            @method('PUT')

            <div class="gp-form-group">
                <label class="gp-label">Área</label>

                <select name="area_id" class="gp-input" required>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}"
                        @selected(old('area_id', $checkItem->area_id) == $area->id)>
                        {{ $area->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="gp-form-group">

                <label class="gp-label">
                    Infraestructura
                </label>

                <select name="infraestructura_id"
                    class="gp-input"
                    required>

                    <option value="">
                        Seleccione una infraestructura
                    </option>

                    @foreach($infraestructuras as $infraestructura)

                    <option value="{{ $infraestructura->id }}"
                        {{ $checkItem->infraestructura_id == $infraestructura->id ? 'selected' : '' }}>

                        {{ $infraestructura->area->nombre }}
                        -
                        {{ $infraestructura->nombre }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="gp-form-group">
                <label class="gp-label">Nombre</label>

                <input type="text"
                    name="nombre"
                    class="gp-input"
                    value="{{ old('nombre', $checkItem->nombre) }}"
                    required>
            </div>

            <div class="gp-form-group">
                <label class="gp-label">Orden</label>

                <input type="number"
                    name="orden"
                    class="gp-input"
                    value="{{ old('orden', $checkItem->orden) }}"
                    required>
            </div>

            <div class="gp-form-group">
                <label class="gp-label">Estado</label>

                <select name="activo" class="gp-input" required>
                    <option value="1" @selected(old('activo', $checkItem->activo) == 1)>
                        Activo
                    </option>

                    <option value="0" @selected(old('activo', $checkItem->activo) == 0)>
                        Inactivo
                    </option>
                </select>
            </div>

            <div class="gp-report-actions">
                <button type="submit" class="gp-action-btn primary">
                    Guardar cambios
                </button>

                <a href="{{ route('check-items.index') }}" class="gp-action-btn secondary">
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</x-app-layout>