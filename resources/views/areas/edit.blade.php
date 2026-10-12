<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Edit</title>
<title>edit</title>
<rect x="2" y="26" width="28" height="2"/>
<path d="M25.4,9c0.8-0.8,0.8-2,0-2.8c0,0,0,0,0,0l-3.6-3.6c-0.8-0.8-2-0.8-2.8,0c0,0,0,0,0,0l-15,15V24h6.4L25.4,9z M20.4,4L24,7.6
	l-3,3L17.4,7L20.4,4z M6,22v-3.6l10-10l3.6,3.6l-10,10H6z"/>
</svg> Editar Área
                </h2>

                <p class="gp-header-subtitle">
                    Actualice la información del área seleccionada.
                </p>
            </div>

            <a href="{{ route('areas.index') }}"
               class="gp-action-btn secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
  <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
  </svg> Volver
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