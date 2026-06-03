<x-app-layout>
    <x-slot name="header">
        <h2 class="gp-header-title">Editar Reporte</h2>
        <p class="gp-header-subtitle">Modifica los datos del reporte seleccionado.</p>
    </x-slot>

    <div class="gp-form-container">
        <form method="POST" action="{{ route('supervisor.reportes.update', $reporte) }}">
            @csrf
            @method('PUT')

            {{-- Área (solo lectura, no editable) --}}
            <div class="gp-form-group">
                <label class="gp-label">Área</label>
                <input type="text" value="{{ $reporte->area->nombre }}" class="gp-input" readonly>
            </div>

            {{-- Fecha (solo lectura, no editable) --}}
            <div class="gp-form-group">
                <label class="gp-label">Fecha</label>
                <input type="text" value="{{ $reporte->fecha->format('d/m/Y') }}" class="gp-input" readonly>
            </div>

            <div class="gp-form-group">
                <label class="gp-label">Observaciones generales</label>
                <textarea name="observaciones" rows="4" class="gp-textarea">{{ $reporte->observaciones }}</textarea>
            </div>

            <!-- Detalles -->
            @php
                $itemsPorSeccion = $reporte->area->checkItems->groupBy('seccion');
            @endphp

            @foreach($itemsPorSeccion as $seccion => $items)
                <div class="gp-section-card">
                    <h3 class="gp-section-title">{{ $seccion }}</h3>
                    @foreach($items as $item)
                        @php
                            $detalle = $reporte->detalles->firstWhere('check_item_id', $item->id);
                        @endphp
                        <div class="gp-check-item">
                            <strong>{{ $item->nombre }}</strong>
                            <select name="detalles[{{ $item->id }}][estado]" class="gp-input">
                                <option value="A" @selected($detalle?->estado == 'A')>A - Aceptable</option>
                                <option value="NC" @selected($detalle?->estado == 'NC')>NC - No Conforme</option>
                                <option value="NA" @selected($detalle?->estado == 'NA')>NA - No Aplica</option>
                                <option value="NFR" @selected($detalle?->estado == 'NFR')>NFR - No Fue Revisado</option>
                            </select>
                            <input type="text" name="detalles[{{ $item->id }}][observacion]"
                                   value="{{ $detalle?->observacion }}" class="gp-input">
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="flex gap-4 mt-6">
                <button type="submit" class="gp-card-button">💾 Guardar cambios</button>
                <a href="{{ route('reportes.index') }}" class="gp-secondary-button">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>

