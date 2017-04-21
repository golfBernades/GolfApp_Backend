<?php

namespace App\Http\Controllers;

use App\Models\ClaveConsultaPartido;
use App\Models\ClaveEdicionPartido;
use App\Models\ClavePartido;
use Illuminate\Support\Facades\DB;

class ClavePartidoController extends Controller
{
    private function obtenerClave($tablaClaves, $campoEnPartido)
    {
        $claveNoUsada = DB::table($tablaClaves . ' as almacen')
            ->leftJoin('partido as pa', $campoEnPartido, '=', 'almacen.clave')
            ->select(['almacen.clave as clave'])
            ->where('pa.id', null)
            ->first();
        if ($claveNoUsada)
            return $claveNoUsada->clave;
        else if ($tablaClaves == 'clave_consulta_partido')
            return $this->insertarClaveConsulta();
        else
            return $this->insertarClaveEdicion();
    }

    public function obtenerClaveConsulta()
    {
        return $this->obtenerClave('clave_consulta_partido', 'pa.clave_consulta');
    }

    public function obtenerClaveEdicion()
    {
        return $this->obtenerClave('clave_edicion_partido', 'pa.clave_edicion');
    }

    private function insertarClave($tabla)
    {
        $digitos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $longitud = 8;
        do {
            $clave = '';
            for ($i = 0; $i < $longitud; $i++)
                $clave = $clave . $digitos[rand(0, 61)];
            if ($tabla == 'clave_consulta_partido')
                $clavePartido = ClaveConsultaPartido::find($clave);
            else
                $clavePartido = ClaveEdicionPartido::find($clave);
        } while ($clavePartido);
        if ($tabla == 'clave_consulta_partido')
            $clavePartido = new ClaveConsultaPartido();
        else
            $clavePartido = new ClaveEdicionPartido();
        $clavePartido->clave = $clave;
        $clavePartido->save();
        return $clave;
    }

    public function insertarClaveConsulta()
    {
        return $this->insertarClave('clave_consulta_partido');
    }

    public function insertarClaveEdicion()
    {
        return $this->insertarClave('clave_edicion_partido');
    }

}
