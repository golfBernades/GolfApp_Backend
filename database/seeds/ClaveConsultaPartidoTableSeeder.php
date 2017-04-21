<?php

use App\Http\Controllers\ClavePartidoController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClaveConsultaPartidoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clave_consulta_partido')->truncate();
        $controller = new ClavePartidoController();
        for ($i = 0; $i < 3; $i++)
            $controller->insertarClaveConsulta();
    }
}
