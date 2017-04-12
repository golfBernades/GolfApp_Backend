<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApuestaPartidoController extends Controller
{
    public function allApuestaAllPartido()
    {
        $apuestasPartidos = DB::table('apuesta_partido as ap')
            ->join('apuesta as apu', function ($join) {
                $join->on('apu.id', '=', 'ap.apuesta_id');
            })
            -join('partido as par', function ($join) {
                $join->on('par.id', '=', 'ap.partido_id');
            })
            ->select(['apu.id as apuesta_id', 'apu.nombre as nombre_apuesta',
                'par.id as partido_id', 'par.clave as clave_partido'])
            ->get();
        return response()->json($apuestasPartidos);
    }

    public function addApuesta($apuestaId, $partidoId)
    {

    }

    public function removeApuesta($apuestaId, $partidoId)
    {

    }

    public function getApuestasEnPartido($partidoId)
    {

    }

    public function getPartidosConApuesta($apuestaId)
    {

    }
}
