<?php

use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->truncate();

        DB::table('usuario')->insert(array([
            'email' => 'porfirioads@gmail.com',
            'password' => sha1('holamundo')
        ], [
            'email' => 'haydedc@gmail.com',
            'password' => sha1('holamundo')
        ], [
            'email' => 'victorre@gmail.com',
            'password' => sha1('holamundo')
        ], [
            'email' => 'jimenasds@gmail.com',
            'password' => sha1('holamundo')
        ]));
    }
}
