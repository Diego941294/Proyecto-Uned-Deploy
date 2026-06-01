<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Nuevo Item
                </h2>

                <p class="gp-header-subtitle">
                    Registrar un nuevo elemento de verificación para el checklist.
                </p>
            </div>

            <a href="{{ route('check-items.index') }}"
                class="gp-action-btn secondary">
                ← Volver
            </a>

        </div>
    </section>

    <div class="gp-form-shell">

        <div class="gp-form-card">

            <form method="POST" action="{{ route('check-items.store') }}">

                @csrf

                <div class="gp-form-group">
                    <label class="gp-label">Área</label>

                    <select name="area_id" class="gp-input" required>
                        <option value="">Seleccione un área</option>

                        @foreach($areas as $area)
                        <option value="{{ $area->id }}">
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

                        <option value="{{ $infraestructura->id }}">

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
                        placeholder="Ejemplo: Pisos"
                        required>
                </div>

                <div class="gp-form-group">
                    <label class="gp-label">El orden se asignará automáticamente.</label>



                <div class="gp-form-group">
                    <label class="gp-label">Estado</label>

                    <select name="activo" class="gp-input" required>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="gp-report-actions">
                    <button type="submit" class="gp-action-btn primary">
                        Guardar Item
                    </button>

                    <a href="{{ route('check-items.index') }}" class="gp-action-btn secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>