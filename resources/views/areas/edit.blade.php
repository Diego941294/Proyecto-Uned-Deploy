<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    ✏️ Editar Área
                </h2>

                <p class="gp-header-subtitle">
                    Actualice la información del área seleccionada.
                </p>
            </div>

            <a href="{{ route('areas.index') }}"
               class="gp-action-btn secondary">
                ← Volver
            </a>

        </div>
    </section>

    <div class="gp-form-shell">

        <div class="gp-form-card">

            <div class="gp-detail-section-title">
                <h3>Información del área #{{ $area->id_areas }}</h3>
                <p>Modifique los datos necesarios y guarde los cambios.</p>
            </div>

            <form method="POST" action="{{ route('areas.update', $area) }}">
                @csrf
                @method('PUT')

                <div class="gp-form-group">
                    <label class="gp-label">Nombre</label>

                    <input type="text"
                           name="nombre"
                           class="gp-input"
                           value="{{ old('nombre', $area->nombre) }}"
                           required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Descripción</label>

                    <textarea name="descripcion"
                              class="gp-textarea"
                              rows="4">{{ old('descripcion', $area->descripcion) }}</textarea>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Estado</label>

                    <select name="activo" class="gp-input" required>
                        <option value="1" @selected(old('activo', $area->activo) == 1)>
                            Activa
                        </option>

                        <option value="0" @selected(old('activo', $area->activo) == 0)>
                            Inactiva
                        </option>
                    </select>
                </div>

                <div class="gp-report-actions">
                    <button type="submit" class="gp-action-btn primary">
                         Guardar cambios
                    </button>

                    <a href="{{ route('areas.index') }}"
                       class="gp-action-btn secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </div>


<style>
    .gp-form-shell {
        max-width: 600px;
        margin: 0 auto;
    }
</style>    
</x-app-layout>