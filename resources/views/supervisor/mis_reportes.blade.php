<x-app-layout>
    <x-slot name="header">
        <h2 class="gp-header-title">Mis Reportes</h2>
        <p class="gp-header-subtitle">Listado de todos los reportes creados por ti.</p>
    </x-slot>

    @if($reportes->isEmpty())
        <p style="color:#991b1b; font-weight:600;">❌ No has creado ningún reporte aún.</p>
    @else
        <table class="gp-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes as $reporte)
                    <tr>
                        <td>#{{ $reporte->id }}</td>
                        <td>{{ $reporte->area->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}</td>
                        <td>
                            @if($reporte->estado === 'aprobado')
                                ✅ Aprobado
                            @elseif($reporte->estado === 'rechazado')
                                ❌ Rechazado
                            @else
                                📝 Borrador
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
