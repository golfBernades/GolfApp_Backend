<?php

namespace App\Http\Controllers;

use App\Models\ClavePartido;
use Illuminate\Support\Facades\DB;

class ClavePartidoController extends Controller
{
    public function obtenerClave()
    {
        $claveNoUsada = DB::table('clave_partido as cp')
            ->leftJoin('partido as pa', 'pa.clave', '=', 'cp.clave')
            ->select(['cp.clave as clave'])
            ->where('pa.id', null)
            ->first();
        if ($claveNoUsada)
            return $claveNoUsada->clave;
        else
            return $this->insertarNuevaClave();
    }

    public function insertarNuevaClave()
    {
        $digitos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789';
        $longitud = 8;
        do {
            $clave = '';
            for ($i = 0; $i < $longitud; $i++) {
                $clave = $clave . $digitos[rand(0, 61)];
            }
            $clavePartido = ClavePartido::find($clave);
        } while ($clavePartido);
        $clavePartido = new ClavePartido();
        $clavePartido->clave = $clave;
        $clavePartido->save();
        return $clave;
    }
}
