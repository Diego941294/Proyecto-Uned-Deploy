<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CheckItem;
use App\Models\Infraestructura;
use Illuminate\Database\Seeder;

class CheckItemSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ÁREA FRÍA
        |--------------------------------------------------------------------------
        */

        $areaFria = Area::where('nombre', 'Área Fría')->first();

        if ($areaFria) {

            $infraFria = Infraestructura::where(
                'id_areas',
                $areaFria->id_areas
            )
                ->where('nombre', 'Infraestructura y Áreas')
                ->first();

            $equiposFrio = Infraestructura::where(
                'id_areas',
                $areaFria->id_areas
            )
                ->where('nombre', 'Equipos y Utensilios')
                ->first();

            $personalFrio = Infraestructura::where(
                'id_areas',
                $areaFria->id_areas
            )
                ->where('nombre', 'Personal')
                ->first();

            $itemsInfraFria = [
                'Pisos',
                'Paredes',
                'Techos',
                'Puertas',
                'Ventanas',
                'Drenajes y rejillas',
                'Iluminación',
                'Ventilación',
                'Presencia de insectos',
            ];

            foreach ($itemsInfraFria as $index => $nombre) {

                if ($infraFria) {
                    CheckItem::firstOrCreate(
                        [
                            'id_infraestructuras' =>
                                $infraFria->id_infraestructuras,

                            'nombre' => $nombre,
                        ],
                        [
                            'orden' => $index + 1,
                            'activo' => true,
                        ]
                    );
                }
            }

            $itemsEquiposFrio = [
                'Prechiller',
                'Chiller',
                'Fábrica de hielo',
            ];

            foreach ($itemsEquiposFrio as $index => $nombre) {

                if ($equiposFrio) {
                    CheckItem::firstOrCreate(
                        [
                            'id_infraestructuras' =>
                                $equiposFrio->id_infraestructuras,

                            'nombre' => $nombre,
                        ],
                        [
                            'orden' => $index + 1,
                            'activo' => true,
                        ]
                    );
                }
            }

            $itemsPersonalFrio = [
                'Uniformes',
                'Estado de salud del personal',
            ];

            foreach ($itemsPersonalFrio as $index => $nombre) {

                if ($personalFrio) {
                    CheckItem::firstOrCreate(
                        [
                            'id_infraestructuras' =>
                                $personalFrio->id_infraestructuras,

                            'nombre' => $nombre,
                        ],
                        [
                            'orden' => $index + 1,
                            'activo' => true,
                        ]
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ÁREA CALIENTE
        |--------------------------------------------------------------------------
        */

        $areaCaliente = Area::where(
            'nombre',
            'Área Caliente'
        )->first();

        if ($areaCaliente) {

            $infraCaliente = Infraestructura::where(
                'id_areas',
                $areaCaliente->id_areas
            )
                ->where('nombre', 'Infraestructura y Áreas')
                ->first();

            $equiposCaliente = Infraestructura::where(
                'id_areas',
                $areaCaliente->id_areas
            )
                ->where('nombre', 'Equipos')
                ->first();

            $personalCaliente = Infraestructura::where(
                'id_areas',
                $areaCaliente->id_areas
            )
                ->where('nombre', 'Personal')
                ->first();

            $itemsInfraCaliente = [
                'Pisos',
                'Paredes',
                'Techos',
            ];

            foreach ($itemsInfraCaliente as $index => $nombre) {

                if ($infraCaliente) {
                    CheckItem::firstOrCreate(
                        [
                            'id_infraestructuras' =>
                                $infraCaliente->id_infraestructuras,

                            'nombre' => $nombre,
                        ],
                        [
                            'orden' => $index + 1,
                            'activo' => true,
                        ]
                    );
                }
            }

            $itemsEquiposCaliente = [
                'Cocinas',
                'Mesas de trabajo',
                'Utensilios',
            ];

            foreach ($itemsEquiposCaliente as $index => $nombre) {

                if ($equiposCaliente) {
                    CheckItem::firstOrCreate(
                        [
                            'id_infraestructuras' =>
                                $equiposCaliente->id_infraestructuras,

                            'nombre' => $nombre,
                        ],
                        [
                            'orden' => $index + 1,
                            'activo' => true,
                        ]
                    );
                }
            }

            $itemsPersonalCaliente = [
                'Uniformes',
                'Lavado de manos',
            ];

            foreach ($itemsPersonalCaliente as $index => $nombre) {

                if ($personalCaliente) {
                    CheckItem::firstOrCreate(
                        [
                            'id_infraestructuras' =>
                                $personalCaliente->id_infraestructuras,

                            'nombre' => $nombre,
                        ],
                        [
                            'orden' => $index + 1,
                            'activo' => true,
                        ]
                    );
                }
            }
        }
    }
}