<?php

use App\Http\Controllers\ClavePartidoController;
use App\Models\Jugador;
use App\Models\Partido;
use Illuminate\Database\Seeder;

class PartidoTableSeeder extends Seeder
{
    private $clavePartidoController;

    public function __construct()
    {
        $this->clavePartidoController = new ClavePartidoController();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partido')->truncate();

        $this->insertPartido('2017-04-10 00:00:00', null, 2, 2);
        $this->insertPartido('2017-03-11 00:00:00', null, 1, 1);
        $this->insertPartido('2017-02-12 00:00:00', null, 3, 2);
        $this->insertPartido('2017-01-13 00:00:00', null, 3, 1);
        $this->insertPartido('2017-12-14 00:00:00', null, 1, 2);
    }

    private function insertPartido($inicio, $fin, $jugador_id, $campo_id)
    {
        $partido = new Partido();
        $partido->inicio = $inicio;
        $partido->fin = $fin;
        $partido->jugador_id = $jugador_id;
        $partido->campo_id = $campo_id;
        $partido->clave = $this->clavePartidoController->obtenerClave();
        $partido->save();
    }
}
