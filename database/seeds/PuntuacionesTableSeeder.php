<?php

use Illuminate\Database\Seeder;

class PuntuacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('puntuaciones')->truncate();

        DB::table('puntuaciones')->insert(array([
            'hoyo' => 1,
            'golpes' => 4,
            'unidades' => 1,
            'jugador_id' => 1,
            'partido_id' => 1
        ], [
            'hoyo' => 2,
            'golpes' => 5,
            'unidades' => 1,
            'jugador_id' => 1,
            'partido_id' => 1
        ], [
            'hoyo' => 3,
            'golpes' => 6,
            'unidades' => 0,
            'jugador_id' => 1,
            'partido_id' => 1
        ], [
            'hoyo' => 4,
            'golpes' => 6,
            'unidades' => 0,
            'jugador_id' => 1,
            'partido_id' => 1
        ], [
            'hoyo' => 5,
            'golpes' => 5,
            'unidades' => 2,
            'jugador_id' => 1,
            'partido_id' => 1
        ], [
            'hoyo' => 1,
            'golpes' => 4,
            'unidades' => 1,
            'jugador_id' => 2,
            'partido_id' => 1
        ], [
            'hoyo' => 2,
            'golpes' => 5,
            'unidades' => 1,
            'jugador_id' => 2,
            'partido_id' => 1
        ], [
            'hoyo' => 3,
            'golpes' => 4,
            'unidades' => 0,
            'jugador_id' => 2,
            'partido_id' => 1
        ], [
            'hoyo' => 4,
            'golpes' => 5,
            'unidades' => 0,
            'jugador_id' => 2,
            'partido_id' => 1
        ], [
            'hoyo' => 5,
            'golpes' => 3,
            'unidades' => 2,
            'jugador_id' => 2,
            'partido_id' => 1
        ], [
            'hoyo' => 1,
            'golpes' => 5,
            'unidades' => 1,
            'jugador_id' => 2,
            'partido_id' => 2
        ], [
            'hoyo' => 2,
            'golpes' => 6,
            'unidades' => 1,
            'jugador_id' => 2,
            'partido_id' => 2
        ], [
            'hoyo' => 3,
            'golpes' => 7,
            'unidades' => 0,
            'jugador_id' => 2,
            'partido_id' => 2
        ], [
            'hoyo' => 4,
            'golpes' => 6,
            'unidades' => 0,
            'jugador_id' => 2,
            'partido_id' => 2
        ], [
            'hoyo' => 5,
            'golpes' => 5,
            'unidades' => 2,
            'jugador_id' => 2,
            'partido_id' => 2
        ]));
    }
}
