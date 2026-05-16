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
                    required
                >
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
                                                class="gp-input"
                                            >
                                                <option value="A">A - Aceptable</option>
                                                <option value="NC">NC - No Conforme</option>
                                                <option value="NA">NA - No Aplica</option>
                                                <option value="NFR">NFR - No Fue Revisado</option>
                                            </select>

                                            <input
                                                type="text"
                                                name="detalles[{{ $item->id }}][observacion]"
                                                class="gp-input"
                                                placeholder="Observación"
                                            >
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
                    placeholder="Observaciones generales del reporte"
                ></textarea>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" class="gp-card-button">
                    Guardar Reporte
                </button>

                <a href="{{ route('reportes.index') }}" class="gp-secondary-button">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        const areaSelect = document.getElementById('areaSelect');
        const emptyMessage = document.querySelector('.gp-empty-message');
        const checklists = document.querySelectorAll('.area-checklist');

        areaSelect.addEventListener('change', function () {
            const selectedArea = this.value;

            checklists.forEach(checklist => {
                checklist.classList.add('hidden');
            });

            if (!selectedArea) {
                emptyMessage.classList.remove('hidden');
                return;
            }

            emptyMessage.classList.add('hidden');

            const selectedChecklist = document.querySelector(`[data-area="${selectedArea}"]`);

            if (selectedChecklist) {
                selectedChecklist.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>