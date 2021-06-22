<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
        [
            'nombre_articulo' => 'Embase de 700 cc',
            'categoria'=> 'insumo',
            'unidad_medida'=> 'javas',
            'cantidad'=> '50'
        ],
        [
            'nombre_articulo' => 'Hojas bond tamaño carta',
            'categoria'=> 'material de escritorio',
            'unidad_medida'=> 'Paquetes',
            'cantidad'=> '15'
        ],
        [
            'nombre_articulo' => 'Leche',
            'categoria'=> 'Materia Prima',
            'unidad_medida'=> 'Litros',
            'cantidad'=> '100'
        ]
        ]);
    }
}
