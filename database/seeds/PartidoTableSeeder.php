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

        DB::table('partido')->insert(array([
            'clave_consulta' => 'abcdefgh',
            'clave_edicion' => 'abcdefgh'
        ]));

        $this->insertPartido('2017-04-10 00:00:00', null, 2, null);
        $this->insertPartido('2017-03-11 00:00:00', null, 1, null);
        $this->insertPartido('2017-02-12 00:00:00', null, 2, null);
        $this->insertPartido('2017-01-13 00:00:00', null, 1, null);
        $this->insertPartido('2017-12-14 00:00:00', '2017-12-14 02:00:00', 2,
            'test_tablero');

        $partidoTest = Partido::all()->first();
        $controller = new PartidoController();
        $request = new Request();
        $request['partido_id'] = $partidoTest->id;
        $request['clave_edicion'] = $partidoTest->clave_edicion;
        $request['tablero_json'] = '{"testBoolean": true, "testString": "hi"}';
        $controller->writeTableroStatus($request);
    }

    private function insertPartido($inicio, $fin, $campo_id, $tablero_json)
    {
        $request = new Request();
        $request['inicio'] = $inicio;
        $request['fin'] = $fin;
        $request['campo_id'] = $campo_id;
        $request['tablero_json'] = $tablero_json;
        $controller = new PartidoController();
        $controller->store($request);

    }
}
