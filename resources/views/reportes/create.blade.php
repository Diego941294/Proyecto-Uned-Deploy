<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">Nuevo Reporte</h2>
            <p class="gp-header-subtitle">Formulario preoperacional por área.</p>
        </div>
    </x-slot>

    <div class="gp-form-container">
        <form method="POST" action="{{ route('reportes.store') }}">
            @csrf
            @csrf

            @if($errors->any())
            <div class="gp-error-message">
                {{ $errors->first() }}
            </div>
            @endif

            <div class="gp-form-group">
                <label class="gp-label">Área</label>

                <select id="areaSelect" name="area_id" class="gp-input" required>
                    <option value="">Seleccione un área</option>

                    @foreach($areas as $area)
                    <option value="{{ $area->id }}">
                        {{ $area->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="gp-form-group">
                <label class="gp-label">Fecha</label>

                <input
                    type="date"
                    name="fecha"
                    class="gp-input"
                    value="{{ now()->format('Y-m-d') }}"
                    readonly
                    required>
            </div>

            <div id="checkItemsContainer" class="gp-check-container">
                <p class="gp-empty-message">
                    Seleccione un área para mostrar los elementos de verificación.
                </p>

                @foreach($areas as $area)
                <div class="area-checklist hidden" data-area="{{ $area->id }}">
                    @php
                    $itemsPorSeccion = $area->checkItems->groupBy('seccion');
                    @endphp

                    @foreach($itemsPorSeccion as $seccion => $items)
                    <div class="gp-section-card">
                        <h3 class="gp-section-title">{{ $seccion }}</h3>

                        @foreach($items as $item)
                        <div class="gp-check-item">
                            <div>
                                <strong>{{ $item->nombre }}</strong>
                                <p>Orden: {{ $item->orden }}</p>
                            </div>

                            <div class="gp-check-controls">
                                <select
                                    name="detalles[{{ $item->id }}][estado]"
                                    class="gp-input">
                                    <option value="A">A - Aceptable</option>
                                    <option value="NC">NC - No Conforme</option>
                                    <option value="NA">NA - No Aplica</option>
                                    <option value="NFR">NFR - No Fue Revisado</option>
                                </select>

                                <input
                                    type="text"
                                    name="detalles[{{ $item->id }}][observacion]"
                                    class="gp-input"
                                    placeholder="Observación">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

            <div class="gp-form-group">
                <label class="gp-label">Observaciones generales</label>

                <textarea
                    name="observaciones"
                    rows="4"
                    class="gp-textarea"
                    placeholder="Observaciones generales del reporte"></textarea>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" class="gp-card-button">
                    Guardar Reporte
                </button>


            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const areaSelect = document.getElementById('areaSelect');
            const emptyMessage = document.querySelector('.gp-empty-message');
            const checklists = document.querySelectorAll('.area-checklist');

            function actualizarChecklist() {
                const selectedArea = areaSelect.value;

                checklists.forEach(checklist => {
                    const esAreaSeleccionada =
                        checklist.dataset.area === selectedArea;

                    checklist.classList.toggle(
                        'hidden',
                        !esAreaSeleccionada
                    );

                    /*
                     * Los campos ocultos deben quedar deshabilitados.
                     * Un campo disabled no se envía al servidor.
                     */
                    checklist
                        .querySelectorAll('input, select, textarea')
                        .forEach(campo => {
                            campo.disabled = !esAreaSeleccionada;
                        });
                });

                emptyMessage.classList.toggle(
                    'hidden',
                    selectedArea !== ''
                );
            }

            areaSelect.addEventListener('change', actualizarChecklist);

            // Desactivar los campos de todas las áreas al cargar la página.
            actualizarChecklist();
        });
    </script>

    <style>
/* Contenedor principal */
.gp-form-container {
    width: 100%;
    max-width: 1200px;   /* ancho máximo en escritorio */
    margin: 0 auto;
    padding: 20px;
    background: #fff;
}

/* Grupos de formulario */
.gp-form-group {
    margin-bottom: 20px;
    width: 100%;
}

/* Labels */
.gp-label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
    color: #f97316; /* naranja */
}

/* Inputs y selects */
.gp-input, .gp-textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    background: #fff;
    color: #333;
}

/* Botón principal */
.gp-card-button {
    background-color: #f97316; /* naranja */
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s;
    width: 100%; /* ocupa todo el ancho en móvil */
}

.gp-card-button:hover {
    background-color: #e36414; /* tono más oscuro al hover */
}

/* Mensajes */
.gp-empty-message {
    color: #991b1b;
    font-weight: 600;
}

.gp-error-message {
    color: #fff;
    background: #991b1b;
    padding: 10px;
    border-radius: 6px;
    margin-top: 10px;
}

/* Responsivo */
@media (max-width: 768px) {
    .gp-form-container {
        padding: 10px;
    }

    .gp-card-button {
        font-size: 14px;
        padding: 10px;
    }
}
</style>

</x-app-layout>