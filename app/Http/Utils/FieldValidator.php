<?php
/**
 * Created by PhpStorm.
 * User: porfirio
 * Date: 4/10/17
 * Time: 2:04 PM
 */

namespace App\Http\Utils;


class FieldValidator
{
    /**
     * Valida que la variable $parameter sea de tipo entero. De no ser así,
     * se asume que la ruta donde venía ese parámetro no existe.
     *
     * @param $parameter int|string el valor de un parámetro recibido en una
     * ruta por medio de la url, por ejemplo:
     * http://localhost/recurso/{parameter}
     * @return \Illuminate\Http\JsonResponse|int
     */
    public static function validateIntegerParameterURL($parameter)
    {
        if (RegexValidator::isIntegerNumber($parameter)) {
            return 1;
        } else {
            return HttpResponses::rutaInexistenteResponse();
        }
    }
}