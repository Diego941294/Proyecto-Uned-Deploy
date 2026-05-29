<x-app-layout>
    <x-slot name="header">
        <h2 class="gp-header-title">Reportes del Día</h2>
        <p class="gp-header-subtitle">Solo se muestran los reportes de hoy en estado Borrador.</p>
    </x-slot>

    @if($reportes->isEmpty())
        <p style="color:#991b1b; font-weight:600;">❌ No hay reportes en estado Borrador para hoy.</p>
    @else
        <table class="gp-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportes as $reporte)
                    <tr>
                        <td>#{{ $reporte->id }}</td>
                        <td>{{ $reporte->area->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('reportes.edit', $reporte->id) }}" class="gp-action-link">✏️ Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-app-layout>
