<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    ➕ Nueva Área
                </h2>

                <p class="gp-header-subtitle">
                    Registre una nueva área preoperacional del sistema.
                </p>
            </div>

            <div class="gp-header-actions">
                <a href="{{ route('areas.index') }}"
                   class="gp-action-btn secondary">
                    ← Volver
                </a>
            </div>

        </div>
    </section>

    <div class="gp-form-shell">

        <div class="gp-form-card">

            <div class="gp-detail-section-title">
                <h3>Información del área</h3>
                <p>Complete los datos para registrar una nueva área.</p>
            </div>

            <form method="POST" action="{{ route('areas.store') }}">
                @csrf

                <div class="gp-form-group">
                    <label class="gp-label">Nombre</label>

                    <input type="text"
                           name="nombre"
                           class="gp-input"
                           value="{{ old('nombre') }}"
                           placeholder="Ejemplo: Área Fría"
                           required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Descripción</label>

                    <textarea name="descripcion"
                              class="gp-textarea"
                              rows="4"
                              placeholder="Descripción breve del área">{{ old('descripcion') }}</textarea>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">Estado</label>

                    <select name="activo" class="gp-input" required>
                        <option value="1" @selected(old('activo') == '1')>
                            Activa
                        </option>

                        <option value="0" @selected(old('activo') == '0')>
                            Inactiva
                        </option>
                    </select>
                </div>

                <div class="gp-report-actions">
                    <button type="submit" class="gp-action-btn primary">
                         Guardar Área
                    </button>

                    <a href="{{ route('areas.index') }}"
                       class="gp-action-btn secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>