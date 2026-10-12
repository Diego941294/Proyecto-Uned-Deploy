<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Nueva Área
                </h2>

                <p class="gp-header-subtitle">
                    Registre una nueva área preoperacional del sistema.
                </p>
            </div>

            <div class="gp-header-actions">
                <a href="{{ route('areas.index') }}"
                   class="gp-action-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
  <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
  </svg> Volver
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