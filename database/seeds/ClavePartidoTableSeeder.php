<?php

use App\Http\Controllers\ClavePartidoController;
use Illuminate\Database\Seeder;

class ClavePartidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clave_partido')->truncate();
        $controller = new ClavePartidoController();
        for ($i = 0; $i < 3; $i++)
            $controller->insertarNuevaClave();
    }
}
