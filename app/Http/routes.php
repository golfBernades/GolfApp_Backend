<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
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
    /**
     * -------------------------------------------------------------------------
     * Rutas donde se requiere que el jugador pertenezca al partido
     * -------------------------------------------------------------------------
     */
    Route::group(['middleware' => ['jugador_partido']], function () {
        /**
         * Actualiza el jugador por medio de su id y los datos
         * pasados como parámetro.
         * Parámetros: partido_id*, clave_edicion*, jugador_id*, nombre,
         * handicap
         */
        Route::put('jugador_update', 'JugadorController@update');

        /**
         * Elimina el jugador por medio de su id y los datos
         * pasados como parámetro.
         * Parámetros: partido_id*, clave_edicion*, jugador_id*
         */
        Route::delete('jugador_delete', 'JugadorController@destroy');
    });

    /**
     * Inserta un jugador con los datos pasados como parámetro.
     * Parámetros: partido_id*, clave_edicion*, nombre*, handicap*
     */
    Route::post('jugador_insert', 'JugadorController@store');

    /**
     * Actualiza el partido por medio de su id y su fecha de finalización.
     * Parámetros: partido_id*, clave_edicion*, fin*
     */
    Route::put('partido_finalizar', 'PartidoController@finalizarPartido');

    /**
     * Elimina el partido por medio de su id así como sus puntuaciones
     * asociadas.
     * Parámetros: partido_id*, clave_edicion*
     */
    Route::delete('partido_delete', 'PartidoController@destroy');

    /**
     * Agrega un jugador a un partido por medio de sus ids.
     * Parámetros: partido_id*, clave_edicion*, jugador_id*
     */
    Route::post('add_jugador_to_partido',
        'JugadorPartidoController@addJugador');

    /**
     * Elimina un jugador de un partido por medio de sus ids.
     * Parámetros: partido_id*, clave_edicion*, jugador_id*
     */
    Route::post('remove_jugador_from_partido',
        'JugadorPartidoController@removeJugador');

    /**
     * Agrega una apuesta a un partido por medio de sus ids.
     * Parámetros: partido_id*, clave_edicion*, apuesta_id*
     */
    Route::post('add_apuesta_to_partido',
        'ApuestaPartidoController@addApuesta');

    /**
     * Elimina una apuesta de un partido por medio de sus ids.
     * Parámetros: partido_id*, clave_edicion*, apuesta_id*
     */
    Route::post('remove_apuesta_from_partido',
        'ApuestaPartidoController@removeApuesta');

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
    /**
     * Devuelve los jugadores que participan en un partido.
     * Parámetros: partido_id*, clave_consulta, clave_edicion. [alguna de las
     * dos claves es obligatoria]
     */
    Route::post('jugadores_en_partido',
        'JugadorPartidoController@getJugadoresEnPartido');

    /**
     * Devuelve las apuestas que se llevan a cabo en un partido.
     * Parámetros: partido_id*, clave_consulta, clave_edicion. [alguna de las
     * dos claves es obligatoria]
     */
    Route::post('apuestas_en_partido',
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

    /**
     * Devuele el campo que se está llevando a cabo en el partido cuya clave
     * de consulta o clave de edición están dadas.
     * Parámetros: partido_id*, clave_consulta, clave_edicion. [alguna de las
     * dos claves es obligatoria]
     */
    Route::post('get_campo_by_clave', 'CampoController@getCampoByClave');
});

/**
 * -----------------------------------------------------------------------------
 * Rutas donde se requiere estar logueado
 * -----------------------------------------------------------------------------
 */
Route::group(['middleware' => ['usuario_logueado']], function () {
    /**
     * Inserta un nuevo campo.
     * Parámetros: id*, email*, password*, nombre,
     * par_hoyo_1*...par_hoyo_18*, ventaja_hoyo_1*...ventaja_hoyo_18*
     */
    Route::post('campo_insert', 'CampoController@store');

    /**
     * -------------------------------------------------------------------------
     * Rutas donde se requiere ser el propietario del campo
     * -------------------------------------------------------------------------
     */
    Route::group(['middleware' => ['propietario_campo']], function () {
        /**
         * Actualiza un campo existente.
         * Parámetros: email*, password*, campo_id*, nombre,
         * par_hoyo_1...par_hoyo_18, ventaja_hoyo_1...ventaja_hoyo_18
         */
        Route::put('campo_update', 'CampoController@update');

        /**
         * Elimina un campo por medio de su id.
         * Parámetros: email*, password*, campo_id*.
         */
        Route::delete('campo_delete', 'CampoController@destroy');
    });
});


/**
 * -----------------------------------------------------------------------------
 * Rutas que no requieren el uso de ningún middleware.
 * -----------------------------------------------------------------------------
 */

/**
 * Inserta un partido con los datos pasados como parámetro.
 * Parámetros: inicio, fin, campo_id
 */
Route::post('partido_insert', 'PartidoController@store');

/**
 * Obtiene un listado con las apuestas existentes.
 * Parámetros: Ninguno
 */
Route::get('apuesta_all', 'ApuestaController@index');

/**
 * Obtiene los detalles de la apuesta por medio de su id.
 * Parámetros: apuesta_id*.
 */
Route::post('apuesta_by_id', 'ApuestaController@getApuestaById');

/**
 * Realiza la autenticación del usuario por medio de su email y password.
 * Parámetros: email*, password*.
 */
Route::post('usuario_login', 'UsuarioController@login');

/**
 * Obtiene un usuario por medio de su email.
 * Parámetros: email*.
 */
Route::post('usuario_exists', 'UsuarioController@usuarioExists');

/**
 * Inserta un usuario con los datos pasados como parámetro.
 * Parámetros: email*, password*.
 */
Route::post('usuario_insert', 'UsuarioController@store');

/**
 * Actualiza un usuario por medio de su id y los datos pasados como parámetro.
 * Parámetros: usuario_id*, email*, password*, new_password.
 */
Route::put('usuario_update', 'UsuarioController@update');

/**
 * Elimina un usuario por medio de sus datos de loguin.
 * Parámetros: email*, password*.
 */
Route::delete('usuario_delete', 'UsuarioController@destroy');

/**
 * Devuelve el partido por medio de su clave de consulta o de edición.
 * Parámetros: clave_consulta, clave_edicion. [alguna de las dos claves
 * es obligatoria]
 */
Route::post('partido_by_clave', 'PartidoController@getPartidoByClave');