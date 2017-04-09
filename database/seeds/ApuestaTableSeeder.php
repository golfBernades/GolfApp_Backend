<?php

use Illuminate\Database\Seeder;

class ApuestaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apuesta')->truncate();

        DB::table('apuesta')->insert(array([
            'nombre' => 'Rayas'
        ], [
            'nombre' => 'Coneja'
        ], [
            'nombre' => 'Polla'
        ], [
            'nombre' => 'Foursome'
        ],));
    }
}
