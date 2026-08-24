<x-app-layout>

    {{-- =========================================================
         ENCABEZADO
    ========================================================== --}}
    <section class="gp-page-header">

        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Detalle del Reporte #{{ $reporte->id_reportes }}
                </h2>

                <p class="gp-header-subtitle">
                    Revisión completa del reporte preoperacional.
                </p>
            </div>


            <div class="gp-header-actions">

                <a
                    href="{{ route('reportes.index') }}"
                    class="gp-action-btn secondary">
                    ← Volver
                </a>


                <a
                    href="{{ route('reportes.pdf', $reporte) }}"
                    class="gp-action-btn pdf">
                    📄 PDF
                </a>


                <a
                    href="{{ route('reportes.excel-detalle', $reporte) }}"
                    class="gp-action-btn excel">
                    📊 Excel
                </a>


                {{-- =====================================================
                     ACCIONES ADMINISTRATIVAS
                ====================================================== --}}
                @if(
                auth()->check() &&
                auth()->user()->hasAnyRole([
                'administrador',
                'super-admin'
                ])
                )

                @if($reporte->estado !== 'aprobado')

                <form
                    method="POST"
                    action="{{ route('reportes.aprobar', $reporte) }}"
                    onsubmit="return confirm('¿Desea aprobar este reporte?');">

                    @csrf

                    <button
                        type="submit"
                        class="gp-action-btn success">
                        ✓ Aprobar
                    </button>

                </form>

                @endif


                @if($reporte->estado !== 'rechazado')

                <form
                    method="POST"
                    action="{{ route('reportes.rechazar', $reporte) }}"
                    onsubmit="return confirm('¿Desea rechazar este reporte?');">

                    @csrf

                    <button
                        type="submit"
                        class="gp-action-btn danger">
                        ✕ Rechazar
                    </button>

                </form>

                @endif

                @endif

            </div>

        </div>

    </section>



    <div class="gp-detail-panel">


        {{-- =========================================================
             MENSAJES
        ========================================================== --}}

        @if(session('success'))

        <div class="gp-success-message">
            {{ session('success') }}
        </div>

        @endif


        @if(session('error'))

        <div class="gp-error-message">
            {{ session('error') }}
        </div>

        @endif


        @if($errors->any())

        <div class="gp-error-message">

            <strong>
                No se pudo completar la operación:
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

        @endif



        {{-- =========================================================
             RESUMEN DEL REPORTE
        ========================================================== --}}

        <div class="gp-detail-summary">

            <div class="gp-detail-card">
                <span>Área</span>
                <strong>
                    {{ $reporte->area?->nombre ?? 'Área no disponible' }}
                </strong>
            </div>

            <div class="gp-detail-card">
                <span>Supervisor</span>
                <strong>
                    {{ $reporte->usuario?->name ?? 'Usuario no disponible' }}
                </strong>
            </div>

            <div class="gp-detail-card">
                <span>Fecha</span>
                <strong>
                    {{ $reporte->fecha?->format('d/m/Y') ?? 'No registrada' }}
                </strong>
            </div>

            <div class="gp-detail-card">
                <span>Estado</span>

                @if($reporte->estado === 'aprobado')
                <strong class="gp-text-success">
                    Aprobado
                </strong>

                @elseif($reporte->estado === 'rechazado')
                <strong class="gp-text-danger">
                    Rechazado
                </strong>

                @elseif($reporte->estado === 'enviado')
                <strong class="gp-text-warning">
                    Enviado
                </strong>

                @else
                <strong class="gp-text-warning">
                    Borrador
                </strong>
                @endif
            </div>


            @if($reporte->estado === 'aprobado')

            <div class="gp-detail-card">
                <span>Aprobado por</span>
                <strong>
                    {{ $reporte->aprobador?->name ?? 'No registrado' }}
                </strong>
            </div>

            <div class="gp-detail-card">
                <span>Fecha de aprobación</span>
                <strong>
                    {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') ?? 'No registrada' }}
                </strong>
            </div>

            @elseif($reporte->estado === 'rechazado')

            <div class="gp-detail-card">
                <span>Administrador</span>
                <strong>
                    {{ $reporte->aprobador?->name ?? 'No registrado' }}
                </strong>
            </div>

            <div class="gp-detail-card">
                <span>Revisión administrativa</span>
                <strong>
                    Rechazado por: {{ $reporte->aprobador?->name ?? 'No registrado' }}
                </strong>
            </div>

            @endif

        </div>



        {{-- =========================================================
             CHECKLIST
        ========================================================== --}}

        <div class="gp-detail-section-title">

            <h3>
                Checklist registrado
            </h3>

            <p>
                Elementos verificados por el supervisor.
            </p>

        </div>


        <div class="gp-table-modern-wrap">

            <table class="gp-table-modern">

                <thead>

                    <tr>
                        <th>Infraestructura</th>
                        <th>Elemento</th>
                        <th>Estado</th>
                        <th>Observación</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($reporte->detalles as $detalle)

                    <tr>

                        <td>

                            {{ $detalle->checkItem?->infraestructura?->nombre
                                    ?? 'Infraestructura no disponible' }}

                        </td>


                        <td>

                            {{ $detalle->checkItem?->nombre
                                    ?? 'Elemento no disponible' }}

                        </td>


                        <td>

                            @if($detalle->estado === 'A')

                            <span class="gp-badge-success">
                                A
                            </span>

                            @elseif($detalle->estado === 'NC')

                            <span class="gp-badge-danger">
                                NC
                            </span>

                            @elseif($detalle->estado === 'NA')

                            <span class="gp-badge-secondary">
                                NA
                            </span>

                            @else

                            <span class="gp-badge-warning">
                                NFR
                            </span>

                            @endif

                        </td>


                        <td>

                            {{ $detalle->observacion
                                    ?? 'Sin observación' }}

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td
                            colspan="4"
                            class="gp-empty-table">
                            No hay detalles registrados para este reporte.
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>



        {{-- =========================================================
             OBSERVACIONES GENERALES
        ========================================================== --}}

        <div class="gp-observation-box">

            <h3>
                Observaciones generales
            </h3>

            <p>
                {{ $reporte->observaciones
                    ?? 'Sin observaciones generales.' }}
            </p>

        </div>



        {{-- =========================================================
             FIRMAS
        ========================================================== --}}

        <div class="gp-signature-section">

            <div class="gp-detail-section-title">
                <h3>
                    Firmas de control de calidad
                </h3>
            </div>

            <div class="gp-signature-grid">

                {{-- SUPERVISOR --}}
                <div class="gp-signature-card">

                    <h3>
                        Supervisor de Calidad
                    </h3>

                    <div class="gp-form-group">

                        <label class="gp-label">
                            Nombre
                        </label>

                        <div class="gp-input">
                            {{ $reporte->usuario?->name ?? 'No registrado' }}
                        </div>

                    </div>

                    @if($reporte->usuario?->firma)

                    <div class="gp-current-signature">

                        <p>
                            Firma registrada:
                        </p>

                        <img
                            src="{{ asset('storage/' . $reporte->usuario->firma) }}"
                            class="gp-signature-img"
                            alt="Firma del supervisor de calidad">

                    </div>

                    @else

                    <div class="gp-current-signature">
                        <p>
                            Firma no registrada.
                        </p>
                    </div>

                    @endif

                </div>


                {{-- CONTROL DE CALIDAD --}}
                <div class="gp-signature-card">

                    <h3>
                        Control de Calidad
                    </h3>

                    <div class="gp-form-group">

                        <label class="gp-label">
                            Nombre
                        </label>

                        <div class="gp-input">
                            {{ $reporte->aprobador?->name ?? 'No registrado' }}
                        </div>

                    </div>

                    @if($reporte->aprobador?->firma)

                    <div class="gp-current-signature">

                        <p>
                            Firma registrada:
                        </p>

                        <img
                            src="{{ asset('storage/' . $reporte->aprobador->firma) }}"
                            class="gp-signature-img"
                            alt="Firma de control de calidad">

                    </div>

                    @else

                    <div class="gp-current-signature">
                        <p>
                            Firma no registrada.
                        </p>
                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- =========================================================
         ESTILOS COMPLEMENTARIOS
    ========================================================== --}}

    <style>
        .gp-detail-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .gp-detail-card {
            padding: 16px 18px;
            border: 1px solid #dbe8f3;
            border-radius: 12px;
            background: #ffffff;
        }

        .gp-detail-card span {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            color: #64748b;
        }

        .gp-detail-card strong {
            color: #0f2f5f;
        }

        @media (max-width: 768px) {
            .gp-detail-summary {
                grid-template-columns: 1fr;
            }
        }






        .gp-success-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #dcfce7;
            color: #166534;
            border-radius: 10px;
            font-weight: 600;
        }

        .gp-error-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            font-weight: 600;
        }

        .gp-signature-method-title {
            margin-top: 20px;
            margin-bottom: 8px;
            font-weight: 700;
            color: #0f2f5f;
        }

        .gp-signature-upload {
            margin-top: 20px;
        }

        .gp-signature-buttons {
            margin-top: 10px;
        }

        .gp-current-signature {
            margin-top: 16px;
        }

        .gp-signature-img {
            display: block;
            max-width: 300px;
            max-height: 150px;
            object-fit: contain;
            background: #ffffff;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            padding: 8px;
        }

        .gp-signature-canvas {
            width: 100%;
            height: 180px;
            background: #ffffff;
            border: 2px dashed #bfdbfe;
            border-radius: 12px;
            touch-action: none;
        }
    </style>



</x-app-layout>