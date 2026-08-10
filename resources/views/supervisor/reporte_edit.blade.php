<div class="gp-form-container">

    <form method="POST" action="{{ route('supervisor.reportes.update', $reporte) }}">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="gp-error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="gp-form-group">
            <label class="gp-label">Área</label>

            <select name="area_id" class="gp-input" required>

                @foreach($areas as $area)
                    <option
                        value="{{ $area->id }}"
                        @selected(
                            old('area_id', $reporte->area_id) == $area->id
                        )
                    >
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
                value="{{ old(
                    'fecha',
                    $reporte->fecha?->format('Y-m-d')
                ) }}"
                required
            >
        </div>

        <div class="gp-form-group">

            <label class="gp-label">
                Observaciones generales
            </label>

            <textarea
                name="observaciones"
                rows="4"
                class="gp-textarea"
            >{{ old('observaciones', $reporte->observaciones) }}</textarea>

        </div>

        {{-- =====================================================
             DETALLES DEL CHECKLIST
        ====================================================== --}}

        @forelse($reporte->area->infraestructuras as $infraestructura)

            @if($infraestructura->checkItems->isNotEmpty())

                <div class="gp-section-card">

                    <h3 class="gp-section-title">
                        {{ $infraestructura->nombre }}
                    </h3>

                    @foreach($infraestructura->checkItems as $item)

                        @php
                            $detalle = $reporte->detalles
                                ->firstWhere('check_item_id', $item->id);
                        @endphp

                        <div class="gp-check-item">

                            <div class="gp-check-info">

                                <strong>
                                    {{ $item->nombre }}
                                </strong>

                                <p>
                                    Orden: {{ $item->orden }}
                                </p>

                            </div>

                            <div class="gp-check-controls">

                                <select
                                    name="detalles[{{ $item->id }}][estado]"
                                    class="gp-input"
                                >

                                    <option
                                        value="A"
                                        @selected(
                                            old(
                                                "detalles.{$item->id}.estado",
                                                $detalle?->estado
                                            ) === 'A'
                                        )
                                    >
                                        A - Aceptable
                                    </option>

                                    <option
                                        value="NC"
                                        @selected(
                                            old(
                                                "detalles.{$item->id}.estado",
                                                $detalle?->estado
                                            ) === 'NC'
                                        )
                                    >
                                        NC - No Conforme
                                    </option>

                                    <option
                                        value="NA"
                                        @selected(
                                            old(
                                                "detalles.{$item->id}.estado",
                                                $detalle?->estado
                                            ) === 'NA'
                                        )
                                    >
                                        NA - No Aplica
                                    </option>

                                    <option
                                        value="NFR"
                                        @selected(
                                            old(
                                                "detalles.{$item->id}.estado",
                                                $detalle?->estado
                                            ) === 'NFR'
                                        )
                                    >
                                        NFR - No Fue Revisado
                                    </option>

                                </select>

                                <input
                                    type="text"
                                    name="detalles[{{ $item->id }}][observacion]"
                                    value="{{ old(
                                        "detalles.{$item->id}.observacion",
                                        $detalle?->observacion
                                    ) }}"
                                    class="gp-input"
                                    placeholder="Observación"
                                >

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        @empty

            <div class="gp-empty-message">
                No hay infraestructuras configuradas para esta área.
            </div>

        @endforelse


        <div class="flex gap-4 mt-6">

            <button
                type="submit"
                class="gp-card-button"
            >
                 Guardar cambios
            </button>

            <a
                href="{{ route('reportes.index') }}"
                class="gp-secondary-button"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>