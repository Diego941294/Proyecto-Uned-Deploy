<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        Area::firstOrCreate(
            ['nombre' => 'Área Fría'],
            [
                'descripcion' => 'Área destinada a procesos y controles en ambiente frío.',
                'activo' => true,
            ]
        );

        Area::firstOrCreate(
            ['nombre' => 'Área Caliente'],
            [
                'descripcion' => 'Área destinada a procesos y controles en ambiente caliente.',
                'activo' => true,
            ]
        );
    }
}