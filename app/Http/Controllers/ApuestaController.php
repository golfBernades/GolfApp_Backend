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

    public function show($id)
    {
        $validation = FieldValidator::validateIntegerParameterURL($id);
        if ($validation instanceof JsonResponse) {
            return $validation;
        } else {
            $apuesta = Apuesta::find($id);
            if (!$apuesta)
                return HttpResponses::noEncontradoResponse('apuesta');
            return response()->json($apuesta);
        }
    }
}
