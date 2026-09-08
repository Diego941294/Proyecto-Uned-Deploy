<x-app-layout>

    <section class="gp-page-header">

        <div class="gp-page-title-row">

            <div>
                <h2 class="gp-header-title">
                    Mis Reportes
                </h2>

                <p class="gp-header-subtitle">
                    Listado de todos los reportes creados por ti.
                </p>
            </div>

            <a
                href="{{ route('supervisor.dashboard') }}"
                class="gp-action-btn secondary"
            >
                ← Volver
            </a>

        </div>

    </section>


    @if($reportes->isEmpty())

        <p style="color:#991b1b; font-weight:600;">
            ❌ No has creado ningún reporte aún.
        </p>

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

                        <td>
                            #{{ $reporte->id_reportes }}
                        </td>

                        <td>
                            {{ $reporte->area?->nombre ?? 'Área no disponible' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}
                        </td>

                        <td>

                            @if($reporte->estado === 'aprobado')

                                ✅ Aprobado

                            @elseif($reporte->estado === 'rechazado')

                                ❌ Rechazado

                            @elseif($reporte->estado === 'enviado')

                                📤 Enviado

                            @else

                                📝 Borrador

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @endif

         <style>
        /* ===============================
           TABLA MIS REPORTES
        =============================== */

        .gp-table-wrapper {
            width: 100%;
            overflow-x: hidden; /* 🔸 evita scroll horizontal */
        }

        .gp-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 100%; /* 🔸 ajusta al ancho del dispositivo */
            background-color: #ffffff;
            color: #333333;
        }

        .gp-table th,
        .gp-table td {
            padding: 10px;
            border-bottom: 1px solid #dbe8f3;
            text-align: left;
            word-wrap: break-word;
            white-space: normal;
        }

        .gp-table th {
            background: linear-gradient(135deg, #0b63d8, #0f2f5f);
            color: #ffffff;
        }

        .gp-table tbody tr:hover {
            background: #f1f7ff;
        }

        /* ===============================
           RESPONSIVE
        =============================== */
        @media (max-width: 768px) {
            .gp-table th,
            .gp-table td {
                padding: 6px;
                font-size: 14px;
            }
        }
    </style>


</x-app-layout>