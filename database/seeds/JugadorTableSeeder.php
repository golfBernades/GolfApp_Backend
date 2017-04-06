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
            'apodo' => 'Porfi',
            'handicap' => 10,
            'sexo' => 'H',
            'url_foto' => 'foto.jpg',
            'email' => 'porfirioads@gmail.com',
            'password' => sha1('holamundo')
        ], [
            'nombre' => 'Margarito',
            'apodo' => 'Marga',
            'handicap' => 5,
            'sexo' => 'H',
            'url_foto' => 'foto.jpg',
            'email' => 'margarito@gmail.com',
            'password' => sha1('holamundo')
        ], [
            'nombre' => 'Abraham',
            'apodo' => 'sabru',
            'handicap' => 8,
            'sexo' => 'H',
            'url_foto' => 'foto.jpg',
            'email' => 'abraham@gmail.com',
            'password' => sha1('holamundo')
        ]));
    }
}
