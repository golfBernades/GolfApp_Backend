<?php

use App\Http\Controllers\ClavePartidoController;
use App\Http\Controllers\PartidoController;
use Illuminate\Http\Request;
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

        $this->insertPartido('2017-04-10 00:00:00', null, 2);
        $this->insertPartido('2017-03-11 00:00:00', null, 1);
        $this->insertPartido('2017-02-12 00:00:00', null, 2);
        $this->insertPartido('2017-01-13 00:00:00', null, 1);
        $this->insertPartido('2017-12-14 00:00:00', null, 2);
    }

    private function insertPartido($inicio, $fin, $campo_id)
    {
        $request = new Request();
        $request['inicio'] = $inicio;
        $request['fin'] = $fin;
        $request['campo_id'] = $campo_id;
        $controller = new PartidoController();
        $controller->store($request);
    }
}
