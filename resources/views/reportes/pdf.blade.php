<div class="header">

    <div class="title">
        REPORTE PREOPERACIONAL
    </div>

    <div class="subtitle">
        Sistema Preoperacional Guana Pollo
    </div>

</div>

<table class="info-table">

    <tr>

        <td>
            <strong>Reporte:</strong>
            #{{ $reporte->id }}
        </td>

        <td>
            <strong>Área:</strong>
            {{ $reporte->area?->nombre ?? 'Área no disponible' }}
        </td>

    </tr>

    <tr>

        <td>
            <strong>Supervisor:</strong>
            {{ $reporte->usuario?->name ?? 'No registrado' }}
        </td>

        <td>
            <strong>Fecha:</strong>
            {{ $reporte->fecha?->format('d/m/Y') ?? 'No registrada' }}
        </td>

    </tr>

    <tr>

        <td>
            <strong>Estado:</strong>
            {{ ucfirst($reporte->estado) }}
        </td>

    </tr>

</table>

@php
    $observacionesDetalle = $reporte->detalles
        ->filter(fn ($detalle) => filled($detalle->observacion))
        ->values();
@endphp

<div class="section-title">
    Checklist registrado
</div>

<table class="checklist-table">

    <thead>
        <tr>
            <th style="width: 22%;">Infraestructura</th>
            <th style="width: 48%;">Elemento</th>
            <th style="width: 14%;">Estado</th>
            <th style="width: 16%;">ID Obs.</th>
        </tr>
    </thead>

    <tbody>

        @foreach($reporte->detalles as $detalle)

            @php
                $indiceObservacion = $observacionesDetalle->search(
                    fn ($observacion) => $observacion->id === $detalle->id
                );

                $codigoObservacion = $indiceObservacion !== false
                    ? 'OBS-' . str_pad(
                        $indiceObservacion + 1,
                        2,
                        '0',
                        STR_PAD_LEFT
                    )
                    : null;
            @endphp

            <tr>

                <td>
                    {{ $detalle->checkItem?->infraestructura?->nombre ?? 'Sin infraestructura' }}
                </td>

                <td>
                    {{ $detalle->checkItem?->nombre ?? 'Elemento no disponible' }}
                </td>

                <td class="text-center">
                    {{ $detalle->estado }}
                </td>

                <td class="text-center observation-id">
                    {{ $codigoObservacion ?? '—' }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>


@if($observacionesDetalle->isNotEmpty())

    <div class="section-title">
        Detalle de observaciones
    </div>

    <table class="checklist-table">

        <thead>
            <tr>
                <th style="width: 13%;">ID</th>
                <th style="width: 20%;">Infraestructura</th>
                <th style="width: 27%;">Elemento</th>
                <th style="width: 40%;">Observación</th>
            </tr>
        </thead>

        <tbody>

            @foreach($observacionesDetalle as $indice => $detalle)

                <tr>

                    <td class="text-center observation-id">
                        OBS-{{ str_pad(
                            $indice + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}
                    </td>

                    <td>
                        {{ $detalle->checkItem?->infraestructura?->nombre ?? 'Sin infraestructura' }}
                    </td>

                    <td>
                        {{ $detalle->checkItem?->nombre ?? 'Elemento no disponible' }}
                    </td>

                    <td>
                        {{ $detalle->observacion }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

@endif


<div class="section-title">
    Observaciones Generales
</div>

<p>
    {{ $reporte->observaciones ?? 'Sin observaciones generales.' }}
</p>

<div class="footer">

    Documento generado automáticamente por el sistema
    preoperacional Guana Pollo.

</div>