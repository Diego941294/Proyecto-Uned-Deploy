<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="gp-header-title">
                Reportes Preoperacionales
            </h2>

            <p class="gp-header-subtitle">
                Gestión de reportes del sistema.
            </p>
        </div>
    </x-slot>

    <div class="flex justify-between items-center mb-6">

        <h3 class="text-xl font-bold text-slate-700">
            Reportes registrados
        </h3>

        <a href="{{ route('reportes.create') }}"
            class="gp-card-button">

            Nuevo Reporte

        </a>

    </div>



<form method="GET"
      action="{{ route('reportes.index') }}"
      class="gp-filter-container">

    <div class="gp-filter-grid">

        <div>
            <label class="gp-label">
                Fecha
            </label>

            <input type="date"
                   name="fecha"
                   value="{{ request('fecha') }}"
                   class="gp-input">
        </div>

        <div>
            <label class="gp-label">
                Área
            </label>

            <select name="area_id"
                    class="gp-input">

                <option value="">
                    Todas
                </option>

                @foreach($areas as $area)

                    <option value="{{ $area->id }}"
                        @selected(request('area_id') == $area->id)>

                        {{ $area->nombre }}

                    </option>

                @endforeach

            </select>
        </div>

        <div>
            <label class="gp-label">
                Estado
            </label>

            <select name="estado"
                    class="gp-input">

                <option value="">
                    Todos
                </option>

                <option value="borrador"
                    @selected(request('estado') == 'borrador')>

                    Borrador

                </option>

                <option value="aprobado"
                    @selected(request('estado') == 'aprobado')>

                    Aprobado

                </option>

                <option value="rechazado"
                    @selected(request('estado') == 'rechazado')>

                    Rechazado

                </option>

            </select>
        </div>

    </div>

    <div class="flex gap-3 mt-4">

        <button type="submit"
                class="gp-card-button">

            Filtrar

        </button>

        <a href="{{ route('reportes.index') }}"
           class="gp-secondary-button">

            Limpiar

        </a>

    </div>

</form>



    <div class="gp-table-container">

        <table class="gp-table">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Supervisor</th>
                    <th>Acciones</th>
                </tr>

            </thead>

            <tbody>

                @forelse($reportes as $reporte)

                <tr>

                    <td>{{ $reporte->id }}</td>

                    <td>{{ $reporte->area->nombre }}</td>

                    <td>{{ $reporte->fecha->format('d/m/Y') }}</td>

                    <td>
                        @if($reporte->estado == 'aprobado')
                        <span class="gp-badge-success">Aprobado</span>

                        @elseif($reporte->estado == 'rechazado')
                        <span class="gp-badge-danger">Rechazado</span>

                        @elseif($reporte->estado == 'enviado')
                        <span class="gp-badge-warning">Enviado</span>

                        @else
                        <span class="gp-badge-secondary">Borrador</span>
                        @endif
                    </td>

                    <td>{{ $reporte->usuario->name }}</td>

                    <td>

                        <a href="{{ route('reportes.show', $reporte) }}"
                            class="gp-table-button">

                            Ver

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="text-center py-6">

                        No hay reportes registrados.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


</x-app-layout>