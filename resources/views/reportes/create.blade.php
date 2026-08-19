<x-app-layout>

    <section class="gp-page-header">

        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Nuevo Reporte
                </h2>

                <p class="gp-header-subtitle">
                    Registrar un nuevo reporte preoperacional por área.
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


    <div class="gp-form-container">

        <form method="POST" action="{{ route('reportes.store') }}">

            @csrf


            @if($errors->any())

                <div class="gp-error-message">
                    {{ $errors->first() }}
                </div>

            @endif


            {{-- Área --}}
            <div class="gp-form-group">

                <label class="gp-label">
                    Área
                </label>

                <select
                    id="areaSelect"
                    name="id_areas"
                    class="gp-input"
                    required
                >

                    <option value="">
                        Seleccione un área
                    </option>

                    @foreach($areas as $area)

                        <option
                            value="{{ $area->id_areas }}"
                            @selected(
                                old('id_areas') == $area->id_areas
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
                    value="{{ old('fecha', now()->format('Y-m-d')) }}"
                    readonly
                    required
                >

            </div>


            {{-- Checklist --}}
            <div
                id="checkItemsContainer"
                class="gp-check-container"
            >

                <p class="gp-empty-message">
                    Seleccione un área para mostrar los elementos de verificación.
                </p>


                @foreach($areas as $area)

                    <div
                        class="area-checklist hidden"
                        data-area="{{ $area->id_areas }}"
                    >

                        @forelse($area->infraestructuras as $infraestructura)

                            @if($infraestructura->checkItems->isNotEmpty())

                                <div class="gp-section-card">

                                    <h3 class="gp-section-title">
                                        {{ $infraestructura->nombre }}
                                    </h3>


                                    @foreach($infraestructura->checkItems as $item)

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
                                                                'A'
                                                            ) === 'A'
                                                        )
                                                    >
                                                        A - Aceptable
                                                    </option>


                                                    <option
                                                        value="NC"
                                                        @selected(
                                                            old(
                                                                "detalles.{$item->id_check_items}.estado"
                                                            ) === 'NC'
                                                        )
                                                    >
                                                        NC - No Conforme
                                                    </option>


                                                    <option
                                                        value="NA"
                                                        @selected(
                                                            old(
                                                                "detalles.{$item->id_check_items}.estado"
                                                            ) === 'NA'
                                                        )
                                                    >
                                                        NA - No Aplica
                                                    </option>


                                                    <option
                                                        value="NFR"
                                                        @selected(
                                                            old(
                                                                "detalles.{$item->id_check_items}.estado"
                                                            ) === 'NFR'
                                                        )
                                                    >
                                                        NFR - No Fue Revisado
                                                    </option>

                                                </select>


                                                <input
                                                    type="text"
                                                    name="detalles[{{ $item->id_check_items }}][observacion]"
                                                    class="gp-input"
                                                    value="{{ old("detalles.{$item->id_check_items}.observacion") }}"
                                                    placeholder="Observación"
                                                >

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @endif


                        @empty

                            <p class="gp-empty-message">
                                Esta área no tiene infraestructuras configuradas.
                            </p>

                        @endforelse

                    </div>

                @endforeach

            </div>


            {{-- Observaciones generales --}}
            <div class="gp-form-group">

                <label class="gp-label">
                    Observaciones generales
                </label>

                <textarea
                    name="observaciones"
                    rows="4"
                    class="gp-textarea"
                    placeholder="Observaciones generales del reporte"
                >{{ old('observaciones') }}</textarea>

            </div>


            {{-- Acciones --}}
            <div class="gp-report-actions">

                <button
                    type="submit"
                    class="gp-card-button"
                >
                    Guardar Reporte
                </button>

            </div>

        </form>

    </div>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const areaSelect =
                    document.getElementById('areaSelect');

                const emptyMessage =
                    document.querySelector('.gp-empty-message');

                const checklists =
                    document.querySelectorAll('.area-checklist');


                function actualizarChecklist() {

                    const selectedArea =
                        areaSelect.value;


                    checklists.forEach(
                        checklist => {

                            const esAreaSeleccionada =
                                checklist.dataset.area === selectedArea;


                            checklist.classList.toggle(
                                'hidden',
                                !esAreaSeleccionada
                            );


                            /*
                             * Los controles de las áreas no seleccionadas
                             * quedan deshabilitados para que NO sean
                             * enviados al servidor.
                             */
                            checklist
                                .querySelectorAll(
                                    'input, select, textarea'
                                )
                                .forEach(
                                    campo => {

                                        campo.disabled =
                                            !esAreaSeleccionada;

                                    }
                                );

                        }
                    );


                    if (emptyMessage) {

                        emptyMessage.classList.toggle(
                            'hidden',
                            selectedArea !== ''
                        );

                    }

                }


                areaSelect.addEventListener(
                    'change',
                    actualizarChecklist
                );


                /*
                 * Ejecutar al cargar para dejar deshabilitados
                 * los campos correspondientes a otras áreas.
                 */
                actualizarChecklist();

            }
        );

    </script>


    <style>

        /* ===============================
           FORMULARIO NUEVO REPORTE
        =============================== */

        .gp-form-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
        }


        .gp-form-group {
            width: 100%;
            margin-bottom: 20px;
        }


        .gp-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 800;
            color: #0f2f5f;
        }


        .gp-input,
        .gp-textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            color: #1e293b;
            font-size: 15px;
        }


        .gp-input:focus,
        .gp-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }


        .gp-section-card {
            margin-bottom: 22px;
            padding: 20px;
            border: 1px solid #dbe8f3;
            border-radius: 16px;
            background: #f8fbff;
        }


        .gp-section-title {
            margin-bottom: 16px;
            color: #0f2f5f;
            font-size: 18px;
            font-weight: 900;
        }


        .gp-check-item {
            display: grid;
            grid-template-columns:
                minmax(220px, 1fr) 1.4fr;
            gap: 20px;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #e2e8f0;
        }


        .gp-check-item:last-child {
            border-bottom: none;
        }


        .gp-check-info strong {
            color: #0f2f5f;
        }


        .gp-check-info p {
            margin-top: 4px;
            color: #64748b;
            font-size: 13px;
        }


        .gp-check-controls {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 12px;
        }


        .gp-card-button {
            padding: 12px 22px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(
                135deg,
                #f59e0b,
                #d97706
            );
            color: #ffffff;
            font-weight: 800;
            cursor: pointer;
            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }


        .gp-card-button:hover {
            transform: translateY(-1px);
            box-shadow:
                0 8px 20px rgba(217, 119, 6, .24);
        }


        .gp-empty-message {
            color: #64748b;
            font-weight: 700;
        }


        .gp-error-message {
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 10px;
            background: #fee2e2;
            color: #991b1b;
            font-weight: 700;
        }


        /* ===============================
           DARK MODE
        =============================== */

        body.dark-mode .gp-form-container {
            background: transparent;
        }


        body.dark-mode .gp-section-card {
            background: #0f1d33;
            border-color: #334155;
        }


        body.dark-mode .gp-section-title,
        body.dark-mode .gp-check-info strong,
        body.dark-mode .gp-label {
            color: #f8fafc;
        }


        body.dark-mode .gp-check-info p {
            color: #94a3b8;
        }


        /* ===============================
           RESPONSIVE
        =============================== */

        @media (max-width: 900px) {

            .gp-check-item {
                grid-template-columns: 1fr;
            }


            .gp-check-controls {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 640px) {

            .gp-form-container {
                padding: 10px;
            }


            .gp-section-card {
                padding: 14px;
            }


            .gp-card-button {
                width: 100%;
                padding: 11px;
                font-size: 14px;
            }

        }

    </style>

</x-app-layout>