<?php

namespace App\Services;

use App\Models\Reporte;
use App\Models\ReporteSnapshot;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReporteSnapshotService
{
    public function crear(Reporte $reporte): ReporteSnapshot
    {
        if (!in_array($reporte->estado, ['aprobado', 'rechazado'], true)) {
            throw ValidationException::withMessages([
                'estado' => 'Solo se pueden generar snapshots de reportes finalizados.',
            ]);
        }

        // Impide crear un segundo snapshot del mismo reporte.
        if ($reporte->snapshot()->exists()) {
            throw ValidationException::withMessages([
                'snapshot' => 'Este reporte ya tiene un snapshot definitivo.',
            ]);
        }

        $reporte->load([
            'area',
            'usuario.roles',
            'aprobador.roles',
            'detalles.checkItem.infraestructura',
            'accionesCorrectivas',
            'historialEstados.usuario',
        ]);

        $datos = [
            'version' => 1,

            'reporte' => [
                'id_reportes' => $reporte->id_reportes,
                'fecha' => $reporte->fecha?->toDateString(),
                'semana' => $reporte->semana,
                'estado' => $reporte->estado,
                'observaciones' => $reporte->observaciones,
                'created_at' => $reporte->created_at?->toIso8601String(),
                'updated_at' => $reporte->updated_at?->toIso8601String(),
            ],

            'area' => [
                'id_areas' => $reporte->area?->id_areas,
                'nombre' => $reporte->area?->nombre,
            ],

            'supervisor' => [
                'id_users' => $reporte->usuario?->id_users,
                'nombre' => $reporte->nombre_supervisor_snapshot,
                'email' => $reporte->usuario?->email,
                'roles' => $reporte->usuario?->roles->pluck('name')->all() ?? [],
                'firma' => $reporte->firma_supervisor_snapshot,
            ],

            'administrador' => [
                'id_users' => $reporte->aprobador?->id_users,
                'nombre' => $reporte->aprobador?->name,
                'email' => $reporte->aprobador?->email,
                'roles' => $reporte->aprobador?->roles->pluck('name')->all() ?? [],
                'firma' => $reporte->aprobador?->firma,
                'fecha_aprobacion' => $reporte->fecha_aprobacion?->toIso8601String(),
                'motivo_rechazo' => $reporte->motivo_rechazo,
            ],

            'inspeccion' => $reporte->detalles->map(function ($detalle) {
                return [
                    'id_reporte_detalles' => $detalle->id_reporte_detalles,
                    'id_check_items' => $detalle->id_check_items,
                    'elemento' => $detalle->checkItem?->nombre,
                    'infraestructura' => [
                        'id_infraestructuras' =>
                        $detalle->checkItem?->infraestructura?->id_infraestructuras,
                        'nombre' =>
                        $detalle->checkItem?->infraestructura?->nombre,
                    ],
                    'estado' => $detalle->estado,
                    'observacion' => $detalle->observacion,
                ];
            })->all(),

            'acciones_correctivas' => $reporte->accionesCorrectivas
                ->map(function ($accion) {
                    return [
                        'id' => $accion->id_reporte_accion_correctiva,
                        'fecha' => $accion->fecha?->toDateString(),
                        'referencia' => $accion->referencia,
                        'causa_raiz' => $accion->causa_raiz,
                        'hora_causa' => $accion->hora_causa,
                        'accion_correctiva' => $accion->accion_correctiva,
                        'hora_accion' => $accion->hora_accion,
                        'verificacion' => $accion->verificacion,
                        'coordinador_area' => $accion->coordinador_area,
                    ];
                })->all(),

            'historial' => $reporte->historialEstados
                ->sortBy('created_at')
                ->map(function ($evento) {
                    return [
                        'id' => $evento->id_reporte_historial_estados,
                        'id_users' => $evento->id_users,
                        'usuario' => $evento->usuario?->name,
                        'estado_anterior' => $evento->estado_anterior,
                        'estado_nuevo' => $evento->estado_nuevo,
                        'comentario' => $evento->comentario,
                        'fecha' => $evento->created_at?->toIso8601String(),
                    ];
                })->values()->all(),
        ];

        return ReporteSnapshot::create([
            'id_reportes' => $reporte->id_reportes,
            'estado_final' => $reporte->estado,
            'datos' => $datos,
            'fecha_snapshot' => now(),
        ]);
    }
}
