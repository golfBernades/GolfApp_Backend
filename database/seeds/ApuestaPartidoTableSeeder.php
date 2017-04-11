<?php

use Illuminate\Database\Seeder;

class ApuestaPartidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apuesta_partido')->truncate();

        DB::table('apuesta_partido')->insert(array([
            'apuesta_id' => 1,
            'partido_id' => 1
        ], [
            'apuesta_id' => 2,
            'partido_id' => 1
        ], [
            'apuesta_id' => 3,
            'partido_id' => 2
        ], [
            'apuesta_id' => 4,
            'partido_id' => 3
        ], [
            'apuesta_id' => 1,
            'partido_id' => 4
        ]));
    }
}
