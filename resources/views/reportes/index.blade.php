<x-app-layout>

    <section class="gp-page-header">
        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Reportes Preoperacionales
                </h2>

                <p class="gp-header-subtitle">
                    Consulta, filtra y revisa los reportes registrados.
                </p>
            </div>

            <div class="gp-header-actions">

                <a href="{{ route('administrador.dashboard') }}"
                   class="gp-action-btn secondary">
                    ← Volver
                </a>

                <a href="{{ route('reportes.pdf-general') }}"
                   class="gp-action-btn pdf">
                    📄 PDF
                </a>

                <a href="{{ route('reportes.excel') }}"
                   class="gp-action-btn excel">
                    📊 Excel
                </a>

            </div>

        </div>
    </section>

    <div class="gp-reports-panel">

        <div class="gp-reports-toolbar">
            <div>
                <h3>Reportes registrados</h3>
                <p>Filtra por fecha, área o estado del reporte.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('reportes.index') }}" class="gp-filter-card">

            <div class="gp-filter-grid-clean">

                <div class="gp-filter-field">
                    <label>Fecha</label>
                    <input type="date" name="fecha" value="{{ request('fecha') }}">
                </div>

                <div class="gp-filter-field">
                    <label>Área</label>

                    <select name="area_id">
                        <option value="">Todas las áreas</option>

                        @foreach($areas as $area)
                            <option value="{{ $area->id }}"
                                @selected(request('area_id') == $area->id)>
                                {{ $area->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="gp-filter-field">
                    <label>Estado</label>

                    <select name="estado">
                        <option value="">Todos los estados</option>
                        <option value="borrador" @selected(request('estado') == 'borrador')>Borrador</option>
                        <option value="aprobado" @selected(request('estado') == 'aprobado')>Aprobado</option>
                        <option value="rechazado" @selected(request('estado') == 'rechazado')>Rechazado</option>
                    </select>
                </div>

            </div>

            <div class="gp-filter-actions">
                <button type="submit" class="gp-action-btn primary">
                    🔎 Filtrar
                </button>

                <a href="{{ route('reportes.index') }}" class="gp-action-btn secondary">
                    Limpiar
                </a>
            </div>

        </form>

        <div class="gp-table-modern-wrap">
            <table class="gp-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Área</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Supervisor</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reportes as $reporte)
                        <tr>
                            <td>#{{ $reporte->id }}</td>
                            <td><strong>{{ $reporte->area->nombre }}</strong></td>
                            <td>{{ $reporte->fecha->format('d/m/Y') }}</td>

                            <td>
                                @if($reporte->estado == 'aprobado')
                                    <span class="gp-badge-success">Aprobado</span>
                                @elseif($reporte->estado == 'rechazado')
                                    <span class="gp-badge-danger">Rechazado</span>
                                @else
                                    <span class="gp-badge-secondary">Borrador</span>
                                @endif
                            </td>

                            <td>{{ $reporte->usuario->name }}</td>

                            <td class="text-center">
                                <a href="{{ route('reportes.show', $reporte) }}" class="gp-view-button">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="gp-empty-table">
                                No hay reportes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-app-layout>