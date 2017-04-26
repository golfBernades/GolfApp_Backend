<?php

use Illuminate\Database\Seeder;

class JugadorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jugador')->truncate();

        DB::table('jugador')->insert(array([
            'nombre' => 'Porfirio',
            'handicap' => 10
        ], [
            'nombre' => 'Margarito',
            'handicap' => 5
        ], [
            'nombre' => 'Abraham',
            'handicap' => 8
        ], [
            'nombre' => 'Santiago',
            'handicap' => 2
        ], [
            'nombre' => 'Adrián',
            'handicap' => 1
        ], [
            'nombre' => 'Haydé',
            'handicap' => 10
        ]));
    }
}
