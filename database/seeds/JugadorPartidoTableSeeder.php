<?php

use Illuminate\Database\Seeder;

class JugadorPartidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jugador_partido')->truncate();

        DB::table('jugador_partido')->insert(array([
            'jugador_id' => 1,
            'partido_id' => 1
        ], [
            'jugador_id' => 1,
            'partido_id' => 2
        ], [
            'jugador_id' => 1,
            'partido_id' => 3
        ], [
            'jugador_id' => 2,
            'partido_id' => 1
        ], [
            'jugador_id' => 2,
            'partido_id' => 2
        ]));
    }
}
