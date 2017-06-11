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
    Route::post('partido_tablero_write', 'PartidoController@writeTableroStatus');
    /**
     * -------------------------------------------------------------------------
     * Rutas donde se requiere que el jugador pertenezca al partido
     * -------------------------------------------------------------------------
     */
    Route::group(['middleware' => ['jugador_partido']], function () {
        /*
        ------------------------------------------------------------------------
        Descripción: Actualiza el jugador por medio de su id y los datos
        pasados como parámetro.
        ------------------------------------------------------------------------
        Parámetros: partido_id*, clave_edicion*, jugador_id*, nombre, handicap
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
        Route::put('jugador_update', 'JugadorController@update');

        /*
        ------------------------------------------------------------------------
        Descripción: Elimina el jugador con el id pasado como parámetro.
        ------------------------------------------------------------------------
        Parámetros: partido_id*, clave_edicion*, jugador_id*
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
        Route::delete('jugador_delete', 'JugadorController@destroy');

        /*
        ------------------------------------------------------------------------
        Descripción: Elimina un jugador de un partido por medio de sus ids.
        ------------------------------------------------------------------------
        Parámetros: Parámetros: partido_id*, clave_edicion*, jugador_id*
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
        Route::post('jugador_partido_remove',
            'JugadorPartidoController@removeJugador');
    });

    /*
    ----------------------------------------------------------------------------
    Descripción: Agrega un jugador a un partido por medio de sus ids.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_edicion*, jugador_id*
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "jugador_partido_id": "jugadorPartidoInsertadoId"
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
    Route::post('jugador_partido_add', 'JugadorPartidoController@addJugador');

    /*
    ----------------------------------------------------------------------------
    Descripción: Inserta un jugador con los datos pasados como parámetro.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_edicion*, nombre*, handicap*
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "jugador_id": "jugadorInsertadoId"
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
    Route::post('jugador_insert', 'JugadorController@store');

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

    /*
    ----------------------------------------------------------------------------
    Descripción: Agrega una apuesta a un partido por medio de sus ids.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_edicion*, apuesta_id*
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "apuesta_partido_id": apuestaPartidoInsertadoId
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
    Route::post('apuesta_partido_add', 'ApuestaPartidoController@addApuesta');

    /**
     * Elimina una apuesta de un partido por medio de sus ids.
     * Parámetros: partido_id*, clave_edicion*, apuesta_id*
     */
    Route::post('apuesta_partido_remove', 'ApuestaPartidoController@removeApuesta');

    /**
     * Registra la puntuación para cierto hoyo de un jugador en un partido.
     * Parámetros: partido_id*, jugador_id*, clave_edicion*, hoyo*, golpes*.
     */
    Route::post('registrar_puntuaciones',
        'PuntuacionesController@registrarPuntuaciones');
});

/**
 * -----------------------------------------------------------------------------
 * Rutas que requieren permisos ya sea de consulta o de edición
 * -----------------------------------------------------------------------------
 */
Route::group(['middleware' => ['consulta_edicion']], function () {
    /*
    ----------------------------------------------------------------------------
    Descripción: Devuelve los jugadores que participan en un partido.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_consulta, clave_edicion. [alguna de las
    dos claves es obligatoria]
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "jugadores": [
            {
                "id": jugador_1_id,
                "nombre": jugador_1_nombre,
                "handicap": jugador_1_handicap
            },
            {
                ...
            }
        ]
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
    Route::post('jugador_partido_get',
        'JugadorPartidoController@getJugadoresEnPartido');

    /**
     * Devuelve las apuestas que se llevan a cabo en un partido.
     * Parámetros: partido_id*, clave_consulta, clave_edicion. [alguna de las
     * dos claves es obligatoria]
     */
    Route::post('apuesta_partido_get',
        'ApuestaPartidoController@getApuestasEnPartido');

    /**
     * Devuelve las puntuaciones en todos los hoyos del jugador en el partido
     * identificados por medio de sus id's.
     * Parámetros: partido_id*, jugador_id*, clave_consulta, clave_edicion.
     * [alguna de las dos claves es obligatoria]
     */
    Route::post('get_all_puntuaciones_jugador',
        'PuntuacionesController@getAllPuntuacionesJugador');

    /**
     * Devuelve las puntuaciones en el hoyo especificado del jugador en el
     * partido identificados por medio de sus id's.
     * Parámetros: partido_id*, jugador_id*, hoyo*, clave_consulta,
     * clave_edicion. [alguna de las dos claves es obligatoria]
     */
    Route::post('get_hoyo_puntuaciones_jugador',
        'PuntuacionesController@getHoyoPuntuacionesJugador');

    /*
    ----------------------------------------------------------------------------
    Descripción: Devuele el campo que se está llevando a cabo en el partido
    cuya clave de consulta o clave de edición están dadas.
    ----------------------------------------------------------------------------
    Parámetros: partido_id*, clave_consulta, clave_edicion. [alguna de las dos
    claves es obligatoria]
    ----------------------------------------------------------------------------
    Respuestas con código 200 (ok):

    {
        "ok": true,
        "campo": {
            "id": "1_5",
            "nombre": "CampitoActualizado",
            "par_hoyo_1": "4",
            "par_hoyo_2": "5",
            "par_hoyo_3": "6",
            "par_hoyo_4": "6",
            "par_hoyo_5": "3",
            "par_hoyo_6": "7",
            "par_hoyo_7": "5",
            "par_hoyo_8": "6",
            "par_hoyo_9": "5",
            "par_hoyo_10": "4",
            "par_hoyo_11": "3",
            "par_hoyo_12": "5",
            "par_hoyo_13": "8",
            "par_hoyo_14": "8",
            "par_hoyo_15": "6",
            "par_hoyo_16": "5",
            "par_hoyo_17": "4",
            "par_hoyo_18": "4",
            "ventaja_hoyo_1": "18",
            "ventaja_hoyo_2": "17",
            "ventaja_hoyo_3": "16",
            "ventaja_hoyo_4": "15",
            "ventaja_hoyo_5": "14",
            "ventaja_hoyo_6": "13",
            "ventaja_hoyo_7": "12",
            "ventaja_hoyo_8": "11",
            "ventaja_hoyo_9": "10",
            "ventaja_hoyo_10": "9",
            "ventaja_hoyo_11": "8",
            "ventaja_hoyo_12": "7",
            "ventaja_hoyo_13": "6",
            "ventaja_hoyo_14": "5",
            "ventaja_hoyo_15": "4",
            "ventaja_hoyo_16": "3",
            "ventaja_hoyo_17": "2",
            "ventaja_hoyo_18": "1",
            "owner_id": "25"
        }
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
    Route::post('get_campo_by_clave', 'CampoController@getCampoByClave');
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

Route::post('campo_count', 'CampoController@getCamposCount');

Route::post('partido_tablero_get', 'PartidoController@getTableroStatus');