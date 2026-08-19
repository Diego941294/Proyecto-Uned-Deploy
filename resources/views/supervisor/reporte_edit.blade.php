<x-app-layout>

    <section class="gp-page-header">

        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Editar Reporte #{{ $reporte->id_reportes }}
                </h2>

                <p class="gp-header-subtitle">
                    Actualizar información del reporte preoperacional.
                </p>
            </div>

            <a
                href="{{ route('supervisor.dashboard') }}"
                class="gp-action-btn secondary"
            >
                ← Volver
            </a>

        </div>

    </section>


    <div class="gp-form-shell">

        <div class="gp-form-card">

            <form
                method="POST"
                action="{{ route('supervisor.reportes.update', $reporte) }}"
            >

                @csrf
                @method('PUT')


                {{-- Mensajes de error --}}
                @if($errors->any())

                    <div class="gp-error-message">

                        <strong>
                            No se pudo actualizar el reporte:
                        </strong>

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                @endif


                {{-- Área --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Área
                    </label>

                    <select
                        name="id_areas"
                        class="gp-input"
                        required
                    >

                        @foreach($areas as $area)

                            <option
                                value="{{ $area->id_areas }}"
                                @selected(
                                    old(
                                        'id_areas',
                                        $reporte->id_areas
                                    ) == $area->id_areas
                                )
                            >
                                {{ $area->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Fecha --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Fecha
                    </label>

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


                {{-- Observaciones --}}
                <div class="gp-form-group">

                    <label class="gp-label">
                        Observaciones generales
                    </label>

                    <textarea
                        name="observaciones"
                        rows="4"
                        class="gp-textarea"
                    >{{ old(
                        'observaciones',
                        $reporte->observaciones
                    ) }}</textarea>

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
                                        ->firstWhere(
                                            'id_check_items',
                                            $item->id_check_items
                                        );
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
                                            name="detalles[{{ $item->id_check_items }}][estado]"
                                            class="gp-input"
                                        >

                                            <option
                                                value="A"
                                                @selected(
                                                    old(
                                                        "detalles.{$item->id_check_items}.estado",
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
                                                        "detalles.{$item->id_check_items}.estado",
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
                                                        "detalles.{$item->id_check_items}.estado",
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
                                                        "detalles.{$item->id_check_items}.estado",
                                                        $detalle?->estado
                                                    ) === 'NFR'
                                                )
                                            >
                                                NFR - No Fue Revisado
                                            </option>

                                        </select>


                                        <input
                                            type="text"
                                            name="detalles[{{ $item->id_check_items }}][observacion]"
                                            value="{{ old(
                                                "detalles.{$item->id_check_items}.observacion",
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


                {{-- Acciones --}}
                <div class="gp-report-actions">

                    <button
                        type="submit"
                        class="gp-action-btn primary"
                    >
                        Guardar cambios
                    </button>


                    <a
                        href="{{ route('supervisor.dashboard') }}"
                        class="gp-action-btn secondary"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>


    <style>

        .gp-error-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            font-weight: 600;
        }

        .gp-error-message ul {
            margin-top: 8px;
            padding-left: 20px;
        }

    </style>

</x-app-layout>