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

                @php
                if (auth()->user()->hasRole('super-admin')) {
                $rutaVolver = route('super-admin.dashboard');
                } elseif (auth()->user()->hasRole('administrador')) {
                $rutaVolver = route('administrador.dashboard');
                } else {
                $rutaVolver = route('supervisor.dashboard');
                }
                @endphp

                <a href="{{ $rutaVolver }}" class="gp-action-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Arrow left</title>
                 <polygon points="14 26 15.41 24.59 7.83 17 28 17 28 15 7.83 15 15.41 7.41 14 6 4 16 14 26"/>
                 </svg> Volver
                </a>

                <a href="{{ route('reportes.pdf-general') }}" class="gp-action-btn pdf">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>Document</title>
                  <title>document</title>
                 <path d="M25.7,9.3l-7-7C18.5,2.1,18.3,2,18,2H8C6.9,2,6,2.9,6,4v24c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V10C26,9.7,25.9,9.5,25.7,9.3
	             z M18,4.4l5.6,5.6H18V4.4z M24,28H8V4h8v6c0,1.1,0.9,2,2,2h6V28z"/>
                 <rect x="10" y="22" width="12" height="2"/>
                 <rect x="10" y="16" width="12" height="2"/>
                 </svg> PDF
                </a>

                <a href="{{ route('reportes.excel') }}" class="gp-action-btn excel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>Document download</title>
                    <title>document--download</title>
                    <polygon points="30 25 28.586 23.586 26 26.172 26 18 24 18 24 26.172 21.414 23.586 20 25 25 30 30 25"/>
                    <path d="M18,28H8V4h8v6a2.0058,2.0058,0,0,0,2,2h6v3l2,0V10a.9092.9092,0,0,0-.3-.7l-7-7A.9087.9087,0,0,0,18,2H8A2.0058,2.0058,0,0,0,6,4V28a2.0058,2.0058,0,0,0,2,2H18ZM18,4.4,23.6,10H18Z"/>
                 </svg> Excel
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

                    <select name="id_areas">
                        <option value="">Todas las áreas</option>

                        @foreach($areas as $area)
                        <option value="{{ $area->id_areas }}" @selected(request('id_areas')==$area->id_areas)>
                            {{ $area->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="gp-filter-field">
                    <label>Estado</label>


                    <select name="estado">
                        <option value="">Todos los estados</option>

                        <option value="borrador"
                            @selected(request('estado')=='borrador' )>
                            Borrador
                        </option>

                        <option value="enviado"
                            @selected(request('estado')=='enviado' )>
                            Pendiente
                        </option>

                        <option value="aprobado"
                            @selected(request('estado')=='aprobado' )>
                            Aprobado
                        </option>

                        <option value="rechazado"
                            @selected(request('estado')=='rechazado' )>
                            Rechazado
                        </option>
                    </select>

                </div>

            </div>  

            <div class="gp-filter-actions">
                <button type="submit" class="gp-action-btn primary">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                 width="32px" height="32px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve"><title>IBM watsonx® Discovery</title>
                     <rect x="6" y="17" width="8" height="2"/>
                     <circle cx="3" cy="18" r="1"/>
                     <circle cx="13" cy="14" r="1"/>
                     <rect x="2" y="13" width="8" height="2"/>
                     <rect x="6" y="9" width="8" height="2"/>
                     <circle cx="3" cy="10" r="1"/>
                     <path d="M30,28.6l-7.4-7.4c1.5-2,2.4-4.5,2.4-7.2c0-6.6-5.4-12-12-12C9.7,2,6.6,3.3,4.3,5.8l1.5,1.4C7.6,5.1,10.2,4,13,4
	                 c5.5,0,10,4.5,10,10s-4.5,10-10,10c-3,0-5.8-1.3-7.7-3.6l-1.5,1.3C6,24.4,9.4,26,13,26c3.2,0,6.1-1.3,8.3-3.3l7.3,7.3L30,28.6z"/>
                     </svg> Filtrar
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
                        <td data-label="Área">
                            <strong>{{ $reporte->area->nombre }}</strong>
                        </td>
                        <td data-label="Fecha">
                            {{ $reporte->fecha->format('d/m/Y') }}
                        </td>
                        <td data-label="Estado">

                            @switch($reporte->estado)
                            @case('borrador')
                            <span class="gp-badge-secondary">
                                Borrador
                            </span>
                            @break

                            @case('enviado')
                            <span class="gp-badge-pending">
                                Pendiente
                            </span>
                            @break

                            @case('aprobado')
                            <span class="gp-badge-success">
                                Aprobado
                            </span>
                            @break

                            @case('rechazado')
                            <span class="gp-badge-danger">
                                Rechazado
                            </span>
                            @break

                            @default
                            <span class="gp-badge-secondary">
                                {{ ucfirst($reporte->estado) }}
                            </span>
                            @endswitch

                        </td>
                        <td data-label="Supervisor">
                            {{ $reporte->usuario->name }}
                        </td>
                        <td data-label="Acciones" class="text-center">
                            <a href="{{ route('reportes.show', $reporte) }}" class="gp-view-button">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="gp-empty-table">
                            No hay reportes registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</x-app-layout>