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

                <a href="{{ route('reportes.index') }}" class="gp-action-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
                  <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
                 </svg> Volver
                </a>

                @if(
                auth()->check() &&
                auth()->user()->hasAnyRole([
                'administrador',
                'super-admin'
                ])
                )

                <a href="{{ route('reportes.pdf', $reporte) }}" class="gp-action-btn pdf">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	             width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Document</title>
                 <title>document</title>
                 <path d="M25.7,9.3l-7-7C18.5,2.1,18.3,2,18,2H8C6.9,2,6,2.9,6,4v24c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V10C26,9.7,25.9,9.5,25.7,9.3
	             z M18,4.4l5.6,5.6H18V4.4z M24,28H8V4h8v6c0,1.1,0.9,2,2,2h6V28z"/>
                 <rect x="10" y="22" width="12" height="2"/>
                 <rect x="10" y="16" width="12" height="2"/>
                 </svg> PDF
                </a>

                @endif

                <a href="{{ route('reportes.excel-detalle', $reporte) }}" class="gp-action-btn excel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Document download</title>
                 <title>document--download</title>
                 <polygon points="30 25 28.586 23.586 26 26.172 26 18 24 18 24 26.172 21.414 23.586 20 25 25 30 30 25"/>
                 <path d="M18,28H8V4h8v6a2.0058,2.0058,0,0,0,2,2h6v3l2,0V10a.9092.9092,0,0,0-.3-.7l-7-7A.9087.9087,0,0,0,18,2H8A2.0058,2.0058,0,0,0,6,4V28a2.0058,2.0058,0,0,0,2,2H18ZM18,4.4,23.6,10H18Z"/>
                 </svg> Excel
                </a>


                {{-- =====================================================
ACCIONES ADMINISTRATIVAS
====================================================== --}}

                @if(
                auth()->check() &&
                auth()->user()->hasAnyRole(['administrador', 'super-admin']) &&
                $reporte->estado === 'enviado'
                )

                {{-- EDITAR --}}
                <a
                    href="{{ route('administrador.reportes.edit', $reporte) }}"
                    class="gp-action-btn secondary">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Edit</title>
                  <title>edit</title>
                    <                 rect x="2" y="26" width="28" height="2"/>
                  <path d="M25.4,9c0.8-0.8,0.8-2,0-2.8c0,0,0,0,0,0l-3.6-3.6c-0.8-0.8-2-0.8-2.8,0c0,0,0,0,0,0l-15,15V24h6.4L25.4,9z M20.4,4L24,7.6
	                   l-3,3L17.4,7L20.4,4z M6,22v-3.6l10-10l3.6,3.6l-10,10H6z"/>
                     </svg> Editar
                </a>

                {{-- APROBAR --}}
                <form
                    method="POST"
                    action="{{ route('reportes.aprobar', $reporte) }}"
                    onsubmit="return confirm('¿Desea aprobar este reporte?');">
                    @csrf

                    <button type="submit" class="gp-action-btn success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Document tasks</title>
                      <polygon points="22 27.18 19.41 24.59 18 26 22 30 30 22 28.59 20.59 22 27.18"/>
                     <path d="M15,28H8V4h8v6a2.0058,2.0058,0,0,0,2,2h6v6h2V10a.9092.9092,0,0,0-.3-.7l-7-7A.9087.9087,0,0,0,18,2H8A2.0058,2.0058,0,0,0,6,4V28a2.0058,2.0058,0,0,0,2,2h7ZM18,4.4,23.6,10H18Z"/>
                      </svg> Aprobar
                    </button>
                </form>

                {{-- RECHAZAR --}}
                <button
                    type="button"
                    class="gp-action-btn danger"
                    onclick="
            document.getElementById('gp-rechazo-panel').hidden = false;
            document.getElementById('motivo_rechazo').focus();
        ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Close large</title>
                  <polygon points="17.4141 16 26 7.4141 24.5859 6 16 14.5859 7.4143 6 6 7.4141 14.5859 16 6 24.5859 7.4143 26 16 17.4141 24.5859 26 26 24.5859 17.4141 16"/>
                   </svg> Rechazar
                </button>

                @endif

            </div> {{-- Cierra gp-header-actions --}}

        </div> {{-- Cierra gp-page-title-row --}}

    </section> {{-- Cierra gp-page-header --}}


    {{-- =====================================================
FORMULARIO DE RECHAZO
====================================================== --}}

    @if(
    auth()->check() &&
    auth()->user()->hasAnyRole(['administrador', 'super-admin']) &&
    $reporte->estado === 'enviado'
    )

    <section
        id="gp-rechazo-panel"
        class="gp-rechazo-panel"
        @if(!$errors->has('motivo_rechazo')) hidden @endif
        >

        <h3>
            Rechazar reporte #{{ $reporte->id_reportes }}
        </h3>

        <p>
            Para rechazar este reporte, debe digitar el motivo del rechazo.
        </p>

        <form
            action="{{ route('reportes.rechazar', $reporte) }}"
            method="POST">
            @csrf

            <label for="motivo_rechazo">
                Motivo del rechazo *
            </label>

            <textarea
                id="motivo_rechazo"
                name="motivo_rechazo"
                class="gp-textarea"
                rows="4"
                maxlength="1000"
                required
                placeholder="Digite el motivo del rechazo...">{{ old('motivo_rechazo') }}</textarea>

            @error('motivo_rechazo')
            <p class="gp-rechazo-error" role="alert">
                {{ $message }}
            </p>
            @enderror

            <div class="gp-rechazo-actions">

                <button
                    type="button"
                    class="gp-action-btn secondary"
                    onclick="
                        document.getElementById('gp-rechazo-panel').hidden = true;
                    ">
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="gp-action-btn danger">
                    Confirmar rechazo
                </button>

            </div>

        </form>

    </section>

    @endif


    {{-- =====================================================
CONTENIDO DEL REPORTE
====================================================== --}}

    <div class="gp-detail-panel">


        {{-- =========================================================
                        MENSAJES
========================================================== --}}

        @if(session('success'))

        <div class="gp-success-message">
            {{ session('success') }}
        </div>

        @endif

        @if(session('warning'))
        <div class="gp-warning-message" role="alert">
            {{ session('warning') }}
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
                <span>Creado por</span>

                <strong>
                    {{ $reporte->nombre_supervisor_snapshot
            ?: ($reporte->usuario?->name ?? 'Usuario no disponible') }}
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
                <span>Administrador</span>

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
                <span>Motivo del rechazo</span>

                <strong>
                    {{ $reporte->motivo_rechazo ?? 'No registrado' }}
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

                        <td data-label="Infraestructura">

                            {{ $detalle->checkItem?->infraestructura?->nombre
                        ?? 'Infraestructura no disponible' }}

                        </td>


                        <td data-label="Elemento">

                            {{ $detalle->checkItem?->nombre
                        ?? 'Elemento no disponible' }}

                        </td>


                        <td data-label="Estado">

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


                        <td data-label="Observación">

                            {{ $detalle->observacion
                        ?? 'Sin observación' }}

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td colspan="4" class="gp-empty-table">
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

        @php
        $finalizado = in_array(
        $reporte->estado,
        ['aprobado', 'rechazado'],
        true
        );

        $firmaSupervisor = $reporte->estado === 'borrador'
        ? $reporte->usuario?->firma
        : $reporte->firma_supervisor_snapshot;

        $nombreSupervisor = $reporte->estado === 'borrador'
        ? $reporte->usuario?->name
        : $reporte->nombre_supervisor_snapshot;

        $firmaAdministrador = $finalizado
        ? data_get($reporte->snapshot?->datos, 'administrador.firma')
        : null;

        $nombreAdministrador = $finalizado
        ? data_get($reporte->snapshot?->datos, 'administrador.nombre')
        : null;
        @endphp


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
                            {{ $nombreSupervisor ?? 'No registrado' }}
                        </div>

                    </div>

                    @if($reporte->usuario?->firma)

                    <div class="gp-current-signature">

                        <p>
                            Firma registrada:
                        </p>

                        <img src="{{ asset('storage/' . $reporte->usuario->firma) }}" class="gp-signature-img"
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

                    <h3>Control de Calidad</h3>

                    <div class="gp-form-group">
                        <label class="gp-label">
                            Nombre
                        </label>

                        <div class="gp-input">
                            {{ $nombreAdministrador ?? 'Pendiente de revisión' }}
                        </div>
                    </div>

                    @if($firmaAdministrador)
                    <div class="gp-current-signature">
                        <p>Firma registrada:</p>

                        <img
                            src="{{ asset('storage/' . $firmaAdministrador) }}"
                            class="gp-signature-img"
                            alt="Firma del administrador de calidad">
                    </div>
                    @else
                    <div class="gp-current-signature">
                        <p>
                            @if($reporte->estado === 'borrador')
                            Reporte pendiente de envío.
                            @elseif($reporte->estado === 'enviado')
                            Pendiente de revisión.
                            @else
                            Firma no registrada.
                            @endif
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


        .gp-warning-message {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
            border-radius: 10px;
            font-weight: 600;
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


        .gp-rechazo-panel {
            margin: 20px 0;
            padding: 24px;
            background: #fff7f7;
            border: 1px solid #fecaca;
            border-left: 5px solid #dc2626;
            border-radius: 12px;
        }

        .gp-rechazo-panel[hidden] {
            display: none;
        }

        .gp-rechazo-panel h3 {
            margin-bottom: 8px;
            color: #991b1b;
            font-size: 20px;
            font-weight: 700;
        }

        .gp-rechazo-panel p {
            margin-bottom: 16px;
            color: #7f1d1d;
        }

        .gp-rechazo-panel label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .gp-rechazo-panel textarea {
            display: block;
            width: 100%;
            min-height: 110px;
            padding: 12px;
            border: 1px solid #fca5a5;
            border-radius: 8px;
        }

        .gp-rechazo-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 16px;
        }

        .gp-rechazo-error {
            margin-top: 8px;
            color: #b91c1c;
            font-weight: 600;
        }
    </style>


</x-app-layout>