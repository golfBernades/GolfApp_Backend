<?php

namespace App\Http\Controllers;

use App\Http\Utils\FieldValidator;
use App\Http\Utils\HttpResponses;
use App\Models\Apuesta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApuestaController extends Controller
{
    public function index()
    {
        $apuestas = Apuesta::all();
        return response()->json($apuestas);
    }

    public function getApuestaById(Request $request)
    {
        $id = $request['apuesta_id'];
        if (!$id) return HttpResponses::parametrosIncompletosReponse();
        return EntityByIdController::getApuestaById($id);
    }
}
