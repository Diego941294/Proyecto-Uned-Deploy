<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CheckItem;
use Illuminate\Database\Seeder;

class CheckItemSeeder extends Seeder
{
    public function run(): void
    {
        $areaFria = Area::where('nombre', 'Área Fría')->first();

        $itemsFrio = [

            ['seccion' => 'Infraestructura', 'nombre' => 'Pisos'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Paredes'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Techos'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Puertas'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Ventanas'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Drenajes y rejillas'],

            ['seccion' => 'Iluminación y ventilación', 'nombre' => 'Iluminación'],
            ['seccion' => 'Iluminación y ventilación', 'nombre' => 'Ventilación'],

            ['seccion' => 'Control de plagas', 'nombre' => 'Presencia de insectos'],

            ['seccion' => 'Equipos', 'nombre' => 'Prechiller'],
            ['seccion' => 'Equipos', 'nombre' => 'Chiller'],
            ['seccion' => 'Equipos', 'nombre' => 'Fábrica de hielo'],

            ['seccion' => 'Personal', 'nombre' => 'Uniformes'],
            ['seccion' => 'Personal', 'nombre' => 'Estado de salud del personal'],
        ];

        foreach ($itemsFrio as $index => $item) {

            CheckItem::create([
                'area_id' => $areaFria->id,
                'seccion' => $item['seccion'],
                'nombre' => $item['nombre'],
                'orden' => $index + 1,
                'activo' => true,
            ]);
        }

        $areaCaliente = Area::where('nombre', 'Área Caliente')->first();

        $itemsCaliente = [

            ['seccion' => 'Infraestructura', 'nombre' => 'Pisos'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Paredes'],
            ['seccion' => 'Infraestructura', 'nombre' => 'Techos'],

            ['seccion' => 'Equipos', 'nombre' => 'Cocinas'],
            ['seccion' => 'Equipos', 'nombre' => 'Mesas de trabajo'],
            ['seccion' => 'Equipos', 'nombre' => 'Utensilios'],

            ['seccion' => 'Personal', 'nombre' => 'Uniformes'],
            ['seccion' => 'Personal', 'nombre' => 'Lavado de manos'],
        ];

        foreach ($itemsCaliente as $index => $item) {

            CheckItem::create([
                'area_id' => $areaCaliente->id,
                'seccion' => $item['seccion'],
                'nombre' => $item['nombre'],
                'orden' => $index + 1,
                'activo' => true,
            ]);
        }
    }
}


