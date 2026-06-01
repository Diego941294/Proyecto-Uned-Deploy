<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">
            <div>
                <h2 class="gp-header-title">
                    Detalle del Reporte #{{ $reporte->id }}
                </h2>

                <p class="gp-header-subtitle">
                    Revisión completa del reporte preoperacional.
                </p>
            </div>

            <div class="gp-header-actions">
                <a href="{{ route('reportes.index') }}" class="gp-action-btn secondary">
                    ← Volver
                </a>

                <a href="{{ route('reportes.pdf', $reporte) }}" class="gp-action-btn pdf">
                    📄 PDF
                </a>

                <a href="{{ route('reportes.excel-detalle', $reporte) }}" class="gp-action-btn excel">
                    📊 Excel
                </a>

                @role('Administrador')
                @if($reporte->estado !== 'aprobado')
                <form method="POST" action="{{ route('reportes.aprobar', $reporte) }}">
                    @csrf
                    <button type="submit" class="gp-action-btn success">
                        ✓ Aprobar
                    </button>
                </form>
                @endif

                @if($reporte->estado !== 'rechazado')
                <form method="POST" action="{{ route('reportes.rechazar', $reporte) }}">
                    @csrf
                    <button type="submit" class="gp-action-btn danger">
                        ✕ Rechazar
                    </button>
                </form>
                @endif
                @endrole
            </div>
        </div>
    </section>

    <div class="gp-detail-panel">

        <div class="gp-detail-summary">

            <div class="gp-detail-card">
                <span>Área</span>
                <strong>{{ $reporte->area->nombre }}</strong>
            </div>

            <div class="gp-detail-card">
                <span>Supervisor</span>
                <strong>{{ $reporte->usuario->name }}</strong>
            </div>

            <div class="gp-detail-card">
                <span>Fecha</span>
                <strong>{{ $reporte->fecha->format('d/m/Y') }}</strong>
            </div>

            <div class="gp-detail-card">
                <span>Estado</span>

                @if($reporte->estado == 'aprobado')
                <strong class="gp-text-success">Aprobado</strong>
                @elseif($reporte->estado == 'rechazado')
                <strong class="gp-text-danger">Rechazado</strong>
                @else
                <strong class="gp-text-warning">Pendiente</strong>
                @endif
            </div>

        </div>

        <div class="gp-review-info">

            @if($reporte->estado === 'aprobado')

            <div class="gp-review-card success">
                <strong>Aprobado por:</strong>
                {{ $reporte->aprobador?->name ?? 'No registrado' }}
            </div>

            <div class="gp-review-card success">
                <strong>Fecha de aprobación:</strong>
                {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') }}
            </div>

            @elseif($reporte->estado === 'rechazado')

            <div class="gp-review-card danger">
                <strong>Rechazado por:</strong>
                {{ $reporte->aprobador?->name ?? 'No registrado' }}
            </div>

            <div class="gp-review-card danger">
                <strong>Fecha de rechazo:</strong>
                {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') }}
            </div>

            @endif

        </div>

        <div class="gp-observation-box">
            <h3>Revisión administrativa</h3>

            @if($reporte->estado === 'aprobado')
            <p>
                <strong>Aprobado por:</strong>
                {{ $reporte->aprobador?->name ?? 'No registrado' }}
            </p>

            <p>
                <strong>Fecha de aprobación:</strong>
                {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') ?? 'No registrada' }}
            </p>
            @elseif($reporte->estado === 'rechazado')
            <p>
                <strong>Rechazado por:</strong>
                {{ $reporte->aprobador?->name ?? 'No registrado' }}
            </p>

            <p>
                <strong>Fecha de rechazo:</strong>
                {{ $reporte->fecha_aprobacion?->format('d/m/Y H:i') ?? 'No registrada' }}
            </p>
            @else
            <p>
                Este reporte todavía está pendiente de revisión administrativa.
            </p>
            @endif
        </div>

        <div class="gp-detail-section-title">
            <h3>Checklist registrado</h3>
            <p>Elementos verificados por el supervisor.</p>
        </div>

        <div class="gp-table-modern-wrap">
            <table class="gp-table-modern">
                <thead>
                    <tr>
                        <th>Sección</th>
                        <th>Elemento</th>
                        <th>Estado</th>
                        <th>Observación</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reporte->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->checkItem->seccion }}</td>
                        <td>{{ $detalle->checkItem->nombre }}</td>
                        <td>
                            @if($detalle->estado === 'A')
                            <span class="gp-badge-success">A</span>
                            @elseif($detalle->estado === 'NC')
                            <span class="gp-badge-danger">NC</span>
                            @elseif($detalle->estado === 'NA')
                            <span class="gp-badge-secondary">NA</span>
                            @else
                            <span class="gp-badge-warning">NFR</span>
                            @endif
                        </td>
                        <td>{{ $detalle->observacion ?? 'Sin observación' }}</td>
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

        <div class="gp-observation-box">
            <h3>Observaciones generales</h3>
            <p>{{ $reporte->observaciones ?? 'Sin observaciones generales.' }}</p>
        </div>

        @role('Administrador')

        @if($reporte->estado === 'aprobado' || $reporte->estado === 'rechazado')

        <div class="gp-signature-section">
            <form method="POST" action="{{ route('reportes.firmas', $reporte) }}">
                @csrf

                <div class="gp-signature-grid">

                    <div class="gp-signature-card">
                        <h3>Inspector de Calidad</h3>

                        <input
                            type="text"
                            name="inspector_calidad"
                            class="gp-input"
                            placeholder="Nombre del inspector"
                            value="{{ old('inspector_calidad', $reporte->inspector_calidad) }}">

                        <canvas id="firmaInspectorCanvas" class="gp-signature-canvas"></canvas>

                        <input
                            type="hidden"
                            name="firma_inspector"
                            id="firmaInspectorInput"
                            value="{{ old('firma_inspector', $reporte->firma_inspector) }}">

                        <button type="button" class="gp-action-btn secondary" id="limpiarInspector">
                            Limpiar firma
                        </button>

                        @if($reporte->firma_inspector)
                        <div class="gp-current-signature">
                            <p>Firma registrada:</p>
                            <img src="{{ $reporte->firma_inspector }}" class="gp-signature-img">
                        </div>
                        @endif
                    </div>

                    <div class="gp-signature-card">
                        <h3>Verificador Jefe de Calidad</h3>

                        <input
                            type="text"
                            name="verificador_calidad"
                            class="gp-input"
                            placeholder="Nombre del verificador"
                            value="{{ old('verificador_calidad', $reporte->verificador_calidad) }}">

                        <canvas id="firmaVerificadorCanvas" class="gp-signature-canvas"></canvas>

                        <input
                            type="hidden"
                            name="firma_verificador"
                            id="firmaVerificadorInput"
                            value="{{ old('firma_verificador', $reporte->firma_verificador) }}">

                        <button type="button" class="gp-action-btn secondary" id="limpiarVerificador">
                            Limpiar firma
                        </button>

                        @if($reporte->firma_verificador)
                        <div class="gp-current-signature">
                            <p>Firma registrada:</p>
                            <img src="{{ $reporte->firma_verificador }}" class="gp-signature-img">
                        </div>
                        @endif
                    </div>

                </div>

                <button type="submit" class="gp-action-btn success" style="margin-top:20px;">
                    Guardar firmas digitales
                </button>
            </form>
        </div>

        @endif

        @endrole

    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.SignaturePad) return;

            function setupSignature(canvasId, inputId, clearButtonId) {
                const canvas = document.getElementById(canvasId);
                const input = document.getElementById(inputId);
                const clearButton = document.getElementById(clearButtonId);

                if (!canvas || !input || !clearButton) return;

                const signaturePad = new window.SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)',
                    penColor: 'rgb(15, 47, 95)'
                });

                function resizeCanvas() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const rect = canvas.getBoundingClientRect();

                    canvas.width = rect.width * ratio;
                    canvas.height = rect.height * ratio;
                    canvas.getContext('2d').scale(ratio, ratio);
                }

                resizeCanvas();

                window.addEventListener('resize', resizeCanvas);

                signaturePad.addEventListener('endStroke', function() {
                    input.value = signaturePad.toDataURL('image/png');
                });

                clearButton.addEventListener('click', function() {
                    signaturePad.clear();
                    input.value = '';
                });
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
        });
    </script>

</x-app-layout>