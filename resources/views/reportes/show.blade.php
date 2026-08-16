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
                    class="gp-action-btn secondary"
                >
                    ← Volver
                </a>


                <a
                    href="{{ route('reportes.pdf', $reporte) }}"
                    class="gp-action-btn pdf"
                >
                    📄 PDF
                </a>


                <a
                    href="{{ route('reportes.excel-detalle', $reporte) }}"
                    class="gp-action-btn excel"
                >
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
                            onsubmit="return confirm('¿Desea aprobar este reporte?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="gp-action-btn success"
                            >
                                ✓ Aprobar
                            </button>

                        </form>

                    @endif


                    @if($reporte->estado !== 'rechazado')

                        <form
                            method="POST"
                            action="{{ route('reportes.rechazar', $reporte) }}"
                            onsubmit="return confirm('¿Desea rechazar este reporte?');"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="gp-action-btn danger"
                            >
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

                <span>
                    Área
                </span>

                <strong>
                    {{ $reporte->area?->nombre ?? 'Área no disponible' }}
                </strong>

            </div>


            <div class="gp-detail-card">

                <span>
                    Supervisor
                </span>

                <strong>
                    {{ $reporte->usuario?->name ?? 'Usuario no disponible' }}
                </strong>

            </div>


            <div class="gp-detail-card">

                <span>
                    Fecha
                </span>

                <strong>
                    {{ $reporte->fecha?->format('d/m/Y') ?? 'No registrada' }}
                </strong>

            </div>


            <div class="gp-detail-card">

                <span>
                    Estado
                </span>

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

        </div>



        {{-- =========================================================
             INFORMACIÓN DE REVISIÓN
        ========================================================== --}}

        <div class="gp-review-info">

            @if($reporte->estado === 'aprobado')

                <div class="gp-review-card success">

                    <strong>
                        Aprobado por:
                    </strong>

                    {{ $reporte->aprobador?->name ?? 'No registrado' }}

                </div>


                <div class="gp-review-card success">

                    <strong>
                        Fecha de aprobación:
                    </strong>

                    {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') ?? 'No registrada' }}

                </div>


            @elseif($reporte->estado === 'rechazado')

                <div class="gp-review-card danger">

                    <strong>
                        Rechazado por:
                    </strong>

                    {{ $reporte->aprobador?->name ?? 'No registrado' }}

                </div>

            @endif

        </div>



        {{-- =========================================================
             REVISIÓN ADMINISTRATIVA
        ========================================================== --}}

        <div class="gp-observation-box">

            <h3>
                Revisión administrativa
            </h3>


            @if($reporte->estado === 'aprobado')

                <p>
                    <strong>
                        Aprobado por:
                    </strong>

                    {{ $reporte->aprobador?->name ?? 'No registrado' }}
                </p>


                <p>
                    <strong>
                        Fecha de aprobación:
                    </strong>

                    {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') ?? 'No registrada' }}
                </p>


            @elseif($reporte->estado === 'rechazado')

                <p>
                    <strong>
                        Rechazado por:
                    </strong>

                    {{ $reporte->aprobador?->name ?? 'No registrado' }}
                </p>


            @else

                <p>
                    Este reporte todavía está pendiente de revisión administrativa.
                </p>

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
                                class="gp-empty-table"
                            >
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
             ADMINISTRADOR / SUPER ADMIN
        ========================================================== --}}

        @if(
            auth()->check() &&
            auth()->user()->hasAnyRole([
                'administrador',
                'super-admin'
            ])
        )

            <div class="gp-signature-section">

                <div class="gp-detail-section-title">

                    <h3>
                        Firmas de control de calidad
                    </h3>

                    <p>
                        Registre las firmas digitales de las personas responsables de la revisión.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('reportes.firmas', $reporte) }}"
                >

                    @csrf


                    <div class="gp-signature-grid">


                        {{-- =================================================
                             SUPERVISOR / INSPECTOR DE CALIDAD
                        ================================================== --}}

                        <div class="gp-signature-card">

                            <h3>
                                Supervisor de Calidad
                            </h3>


                            <label class="gp-label">
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="inspector_calidad"
                                class="gp-input"
                                placeholder="Nombre del supervisor de calidad"
                                value="{{ old(
                                    'inspector_calidad',
                                    $reporte->inspector_calidad
                                ) }}"
                            >


                            <div class="gp-signature-method-title">
                                Dibujar firma
                            </div>


                            <canvas
                                id="firmaInspectorCanvas"
                                class="gp-signature-canvas"
                            ></canvas>


                            <input
                                type="hidden"
                                name="firma_inspector"
                                id="firmaInspectorInput"
                                value="{{ old(
                                    'firma_inspector',
                                    $reporte->firma_inspector
                                ) }}"
                            >


                            <div class="gp-signature-buttons">

                                <button
                                    type="button"
                                    class="gp-action-btn secondary"
                                    id="limpiarInspector"
                                >
                                    Limpiar firma
                                </button>

                            </div>


                            {{-- SUBIR IMAGEN --}}
                            <div class="gp-signature-upload">

                                <label
                                    for="imagenFirmaInspector"
                                    class="gp-label"
                                >
                                    O cargar firma como imagen
                                </label>

                                <input
                                    type="file"
                                    id="imagenFirmaInspector"
                                    class="gp-input"
                                    accept="image/png,image/jpeg,image/webp"
                                >

                                <p class="gp-form-help">
                                    Formatos permitidos: PNG, JPG, JPEG o WEBP.
                                </p>

                            </div>


                            <div
                                id="previewInspector"
                                class="gp-current-signature"
                                style="display:none;"
                            >

                                <p>
                                    Vista previa:
                                </p>

                                <img
                                    id="previewInspectorImg"
                                    class="gp-signature-img"
                                    alt="Vista previa de la firma"
                                >

                            </div>


                            @if($reporte->firma_inspector)

                                <div class="gp-current-signature">

                                    <p>
                                        Firma registrada:
                                    </p>

                                    <img
                                        src="{{ $reporte->firma_inspector }}"
                                        class="gp-signature-img"
                                        alt="Firma del supervisor de calidad"
                                    >

                                </div>

                            @endif

                        </div>



                        {{-- =================================================
                             CONTROL / VERIFICADOR DE CALIDAD
                        ================================================== --}}

                        <div class="gp-signature-card">

                            <h3>
                                Control de Calidad
                            </h3>


                            <label class="gp-label">
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="verificador_calidad"
                                class="gp-input"
                                placeholder="Nombre del responsable de control de calidad"
                                value="{{ old(
                                    'verificador_calidad',
                                    $reporte->verificador_calidad
                                ) }}"
                            >


                            <div class="gp-signature-method-title">
                                Dibujar firma
                            </div>


                            <canvas
                                id="firmaVerificadorCanvas"
                                class="gp-signature-canvas"
                            ></canvas>


                            <input
                                type="hidden"
                                name="firma_verificador"
                                id="firmaVerificadorInput"
                                value="{{ old(
                                    'firma_verificador',
                                    $reporte->firma_verificador
                                ) }}"
                            >


                            <div class="gp-signature-buttons">

                                <button
                                    type="button"
                                    class="gp-action-btn secondary"
                                    id="limpiarVerificador"
                                >
                                    Limpiar firma
                                </button>

                            </div>


                            {{-- SUBIR IMAGEN --}}
                            <div class="gp-signature-upload">

                                <label
                                    for="imagenFirmaVerificador"
                                    class="gp-label"
                                >
                                    O cargar firma como imagen
                                </label>

                                <input
                                    type="file"
                                    id="imagenFirmaVerificador"
                                    class="gp-input"
                                    accept="image/png,image/jpeg,image/webp"
                                >

                                <p class="gp-form-help">
                                    Formatos permitidos: PNG, JPG, JPEG o WEBP.
                                </p>

                            </div>


                            <div
                                id="previewVerificador"
                                class="gp-current-signature"
                                style="display:none;"
                            >

                                <p>
                                    Vista previa:
                                </p>

                                <img
                                    id="previewVerificadorImg"
                                    class="gp-signature-img"
                                    alt="Vista previa de la firma"
                                >

                            </div>


                            @if($reporte->firma_verificador)

                                <div class="gp-current-signature">

                                    <p>
                                        Firma registrada:
                                    </p>

                                    <img
                                        src="{{ $reporte->firma_verificador }}"
                                        class="gp-signature-img"
                                        alt="Firma de control de calidad"
                                    >

                                </div>

                            @endif

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="gp-action-btn success"
                        style="margin-top:20px;"
                    >
                        Guardar firmas digitales
                    </button>

                </form>

            </div>

        @endif


    </div>



    {{-- =========================================================
         ESTILOS COMPLEMENTARIOS
    ========================================================== --}}

    <style>

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



    {{-- =========================================================
         FIRMA DIGITAL
    ========================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                |--------------------------------------------------------------------------
                | FIRMA DIBUJADA
                |--------------------------------------------------------------------------
                */

                function setupSignature(
                    canvasId,
                    inputId,
                    clearButtonId
                ) {

                    const canvas =
                        document.getElementById(canvasId);

                    const input =
                        document.getElementById(inputId);

                    const clearButton =
                        document.getElementById(clearButtonId);


                    if (
                        !canvas ||
                        !input ||
                        !clearButton
                    ) {
                        return;
                    }


                    if (!window.SignaturePad) {
                        console.warn(
                            'SignaturePad no está disponible.'
                        );

                        return;
                    }


                    const signaturePad =
                        new window.SignaturePad(
                            canvas,
                            {
                                backgroundColor:
                                    'rgb(255, 255, 255)',

                                penColor:
                                    'rgb(15, 47, 95)'
                            }
                        );


                    function resizeCanvas() {

                        const ratio =
                            Math.max(
                                window.devicePixelRatio || 1,
                                1
                            );

                        const rect =
                            canvas.getBoundingClientRect();


                        canvas.width =
                            rect.width * ratio;

                        canvas.height =
                            rect.height * ratio;


                        canvas
                            .getContext('2d')
                            .scale(
                                ratio,
                                ratio
                            );


                        signaturePad.clear();
                    }


                    resizeCanvas();


                    window.addEventListener(
                        'resize',
                        resizeCanvas
                    );


                    signaturePad.addEventListener(
                        'endStroke',
                        function () {

                            input.value =
                                signaturePad.toDataURL(
                                    'image/png'
                                );
                        }
                    );


                    clearButton.addEventListener(
                        'click',
                        function () {

                            signaturePad.clear();

                            input.value = '';
                        }
                    );
                }



                setupSignature(
                    'firmaInspectorCanvas',
                    'firmaInspectorInput',
                    'limpiarInspector'
                );


                setupSignature(
                    'firmaVerificadorCanvas',
                    'firmaVerificadorInput',
                    'limpiarVerificador'
                );



                /*
                |--------------------------------------------------------------------------
                | FIRMA CARGADA COMO IMAGEN
                |--------------------------------------------------------------------------
                */

                function setupImageUpload(
                    fileInputId,
                    hiddenInputId,
                    previewContainerId,
                    previewImageId
                ) {

                    const fileInput =
                        document.getElementById(
                            fileInputId
                        );

                    const hiddenInput =
                        document.getElementById(
                            hiddenInputId
                        );

                    const previewContainer =
                        document.getElementById(
                            previewContainerId
                        );

                    const previewImage =
                        document.getElementById(
                            previewImageId
                        );


                    if (
                        !fileInput ||
                        !hiddenInput ||
                        !previewContainer ||
                        !previewImage
                    ) {
                        return;
                    }


                    fileInput.addEventListener(
                        'change',
                        function () {

                            const file =
                                fileInput.files[0];


                            if (!file) {
                                return;
                            }


                            const allowedTypes = [
                                'image/png',
                                'image/jpeg',
                                'image/webp'
                            ];


                            if (
                                !allowedTypes.includes(
                                    file.type
                                )
                            ) {

                                alert(
                                    'Seleccione una imagen PNG, JPG, JPEG o WEBP.'
                                );

                                fileInput.value = '';

                                return;
                            }


                            const reader =
                                new FileReader();


                            reader.onload =
                                function (event) {

                                    const imageData =
                                        event.target.result;


                                    hiddenInput.value =
                                        imageData;


                                    previewImage.src =
                                        imageData;


                                    previewContainer.style.display =
                                        'block';
                                };


                            reader.readAsDataURL(file);
                        }
                    );
                }



                setupImageUpload(
                    'imagenFirmaInspector',
                    'firmaInspectorInput',
                    'previewInspector',
                    'previewInspectorImg'
                );


                setupImageUpload(
                    'imagenFirmaVerificador',
                    'firmaVerificadorInput',
                    'previewVerificador',
                    'previewVerificadorImg'
                );

            }
        );

    </script>

</x-app-layout>