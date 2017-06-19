<?php

/*
|-------------------------------------------------------------------------------
| Application Routes
|-------------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * -----------------------------------------------------------------------------
 * Rutas donde se requiere contar el permiso de edición en un partido.
 * -----------------------------------------------------------------------------
 */
Route::group(['middleware' => ['edicion_partido']], function () {
    Route::post('partido_tablero_write',
        'PartidoController@writeTableroStatus');

    /*
    ----------------------------------------------------------------------------
    Descripción: Actualiza el partido por medio de su id y su fecha de
    finalización.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_edicion*, fin*
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true
    }

    {
        "ok": false,
        "error_message": "El mensaje de error aquí"
    }

    ----------------------------------------------------------------------------
    Respuestas con código 400 (bad request)

    {
        "error_message": "Parámetros incompletos, se requieren los siguientes
                          parámetros: [par_1, ..., par_n]"
    }
    ----------------------------------------------------------------------------
    */
    Route::put('partido_finalizar', 'PartidoController@finalizarPartido');

    /*
    ----------------------------------------------------------------------------
    Descripción: Elimina el partido por medio de su id así como sus puntuaciones
    asociadas.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_edicion*
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true
    }

    {
        "ok": false,
        "error_message": "El mensaje de error aquí"
    }

    ----------------------------------------------------------------------------
    Respuestas con código 400 (bad request)

    {
        "error_message": "Parámetros incompletos, se requieren los siguientes
                          parámetros: [par_1, ..., par_n]"
    }
    ----------------------------------------------------------------------------
    */
    Route::delete('partido_delete', 'PartidoController@destroy');
});

/**
 * -----------------------------------------------------------------------------
 * Rutas donde se requiere estar logueado
 * -----------------------------------------------------------------------------
 */
Route::group(['middleware' => ['usuario_logueado']], function () {
    /*
    ----------------------------------------------------------------------------
    Descripción: Inserta un campo con los datos pasados como parámetro.
    ----------------------------------------------------------------------------
    Parámetros: campo_id*, email*, password*, nombre,
    par_hoyo_1*...par_hoyo_18*, ventaja_hoyo_1*...ventaja_hoyo_18*
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "campo_id": "campoInsertadoId"
    }

    {
        "ok": false,
        "error_message": "El mensaje de error aquí"
    }

    ----------------------------------------------------------------------------
    Respuestas con código 400 (bad request)

    {
        "error_message": "Parámetros incompletos, se requieren los siguientes
                          parámetros: [par_1, ..., par_n]"
    }
    ----------------------------------------------------------------------------
    */
    Route::post('campo_insert', 'CampoController@store');

    /**
     * -------------------------------------------------------------------------
     * Rutas donde se requiere ser el propietario del campo
     * -------------------------------------------------------------------------
     */
    Route::group(['middleware' => ['propietario_campo']], function () {
        /*
        ------------------------------------------------------------------------
        Descripción: Actualiza el campo por medio de su id y los datos
        pasados como parámetro.
        ------------------------------------------------------------------------
        Parámetros: email*, password*, campo_id*, nombre,
        par_hoyo_1...par_hoyo_18, ventaja_hoyo_1...ventaja_hoyo_18
        ------------------------------------------------------------------------
        Respuestas con código 200 (ok):

        {
            "ok": true
        }

        {
            "ok": false,
            "error_message": "El mensaje de error aquí"
        }
        ------------------------------------------------------------------------
        Respuestas con código 400 (bad request)

        {
            "error_message": "Parámetros incompletos, se requieren los
                              siguientes parámetros: [par_1, ..., par_n]"
        }
        ------------------------------------------------------------------------
        */
        Route::put('campo_update', 'CampoController@update');

        /*
        ------------------------------------------------------------------------
        Descripción: Elimina un campo por medio de su id.
        ------------------------------------------------------------------------
        Parámetros: email*, password*, campo_id*.
        ------------------------------------------------------------------------
        Respuestas con código 200 (ok):

        {
            "ok": true
        }

        {
            "ok": false,
            "error_message": "El mensaje de error aquí"
        }
        ------------------------------------------------------------------------
        Respuestas con código 400 (bad request)

        {
            "error_message": "Parámetros incompletos, se requieren los
                              siguientes parámetros: [par_1, ..., par_n]"
        }
        ------------------------------------------------------------------------
        */
        Route::delete('campo_delete', 'CampoController@destroy');
    });

    /*
    ------------------------------------------------------------------------
    Descripción: Inserta un partido con los datos pasados como parámetro.
    ------------------------------------------------------------------------
    Parámetros: email*, password*, campo_id*, inicio*, fin
    ------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "partido_id": partidoInsertadoId
    }

    {
        "ok": false,
        "error_message": "El mensaje de error aquí"
    }
    ------------------------------------------------------------------------
    Respuestas con código 400 (bad request)

    {
        "error_message": "Parámetros incompletos, se requieren los
                      siguientes parámetros: [par_1, ..., par_n]"
    }
    ------------------------------------------------------------------------
    */
    Route::post('partido_insert', 'PartidoController@store');
});


/**
 * -----------------------------------------------------------------------------
 * Rutas que no requieren el uso de ningún middleware.
 * -----------------------------------------------------------------------------
 */

/*
--------------------------------------------------------------------------------
Descripción: Realiza la autenticación del usuario por medio de su email y
password.
--------------------------------------------------------------------------------
Parámetros: Parámetros: email*, password*.
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('usuario_login', 'UsuarioController@login');

/*
--------------------------------------------------------------------------------
Descripción: Determina si existe el usuario con el email pasado como
parámetro.
--------------------------------------------------------------------------------
Parámetros: email*
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true,
    "existe": true|false
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('usuario_exists', 'UsuarioController@usuarioExists');

/*
--------------------------------------------------------------------------------
Descripción: Inserta un usuario con los datos pasados como parámetro.
--------------------------------------------------------------------------------
Parámetros: email*, password*.
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true,
    "usuario_id": usuarioInsertadoId
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('usuario_insert', 'UsuarioController@store');

/*
--------------------------------------------------------------------------------
Descripción: Actualiza un usuario por medio de su id y los datos pasados
como parámetro.
--------------------------------------------------------------------------------
Parámetros: usuario_id*, email*, password*, new_password.
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::put('usuario_update', 'UsuarioController@update');

/*
--------------------------------------------------------------------------------
Descripción: Elimina un usuario por medio de sus datos de loguin.
--------------------------------------------------------------------------------
Parámetros: Parámetros: email*, password*.
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::delete('usuario_delete', 'UsuarioController@destroy');

/*
--------------------------------------------------------------------------------
Descripción: Obtiene el contador para el siguiente id de un campo
--------------------------------------------------------------------------------
Parámetros:
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true,
    "next_id": enteroAutoincremental
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('campo_user_next_id', 'CampoController@getCampoNextId');

/*
--------------------------------------------------------------------------------
Descripción: Obtiene los campos asociados al usuario con el id pasado como
parámetro
--------------------------------------------------------------------------------
Parámetros: usuario_id
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true,
    "campos_count": usuarioCamposCount
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('campo_user_all', 'CampoController@getUserCampos');

/*
--------------------------------------------------------------------------------
Descripción: Obtiene tablero del partido cuya clave de consulta es pasada como
parámetro;
--------------------------------------------------------------------------------
Parámetros: clave_consulta*
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true,
    "tablero": {
    "atributo_1": true,
        "atributo_2": [
        1,
        2,
        3,
        4
    ],
        "atributo_3": {
        "atributo_1_1": 4,
            "atributo_1_2": "holapepe"
        }
    }
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('partido_tablero_get', 'PartidoController@getTableroStatus');

/*
--------------------------------------------------------------------------------
Descripción: Determina si existe o no el partido con la clave de consulta
pasada como parámetro
--------------------------------------------------------------------------------
Parámetros: clave_consulta*
--------------------------------------------------------------------------------
Respuestas con código 200 (ok):

{
    "ok": true,
    "exists": true|false
}

{
    "ok": false,
    "error_message": "El mensaje de error aquí"
}

--------------------------------------------------------------------------------
Respuestas con código 400 (bad request)

{
    "error_message": "Parámetros incompletos, se requieren los siguientes
                      parámetros: [par_1, ..., par_n]"
}
--------------------------------------------------------------------------------
*/
Route::post('partido_consulta_exists', 'PartidoController@partidoConsultaExists');