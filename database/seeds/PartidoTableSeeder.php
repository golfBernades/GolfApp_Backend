<?php

use App\Models\Jugador;
use Illuminate\Database\Seeder;

class PartidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partido')->truncate();

        DB::table('partido')->insert(array([
            'clave' => 'abcd1234',
            'inicio' => '2017-04-10 00:00:00',
            'fin' => null,
            'jugador_id' => 2,
            'campo_id' => 2
        ], [
            'clave' => 'dcba1234',
            'inicio' => '2017-04-11 00:00:00',
            'fin' => null,
            'jugador_id' => 1,
            'campo_id' => 1
        ], [
            'clave' => 'abcd4321',
            'inicio' => '2017-04-12 00:00:00',
            'fin' => null,
            'jugador_id' => 3,
            'campo_id' => 2
        ], [
            'clave' => 'dcba4321',
            'inicio' => '2017-04-13 00:00:00',
            'fin' => null,
            'jugador_id' => 3,
            'campo_id' => 1
        ], [
            'clave' => '1234abcd',
            'inicio' => '2017-04-14 00:00:00',
            'fin' => null,
            'jugador_id' => 1,
            'campo_id' => 2
        ]));
    }
}
