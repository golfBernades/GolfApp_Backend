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

/*
--------------------------------------------------------------------------------
Grupo de rutas que requieren permisos para editar datos sobre un partido.
--------------------------------------------------------------------------------
*/
Route::group(['middleware' => ['edicion_partido']], function () {
    // TODO ¿Cómo se manejarán los campos?
    Route::post('campo', 'CampoController@store');
    Route::get('campo/{id}', 'CampoController@show');
    Route::put('campo/{id}', 'CampoController@update');
    Route::delete('campo/{id}', 'CampoController@destroy');
});

/**
 * -----------------------------------------------------------------------------
 * Rutas donde se requere contar el permiso de edición en un partido.
 * -----------------------------------------------------------------------------
 */

Route::group(['middleware' => ['edicion_partido']], function () {
    /**
     * Devuelve todos los jugadores.
     * Parámetros: partido_id*, clave_edicion*
     */
    Route::post('jugador_all', 'JugadorController@getAllJugador');

    /**
     * Devuelve el jugador por medio de su id.
     * Parámetros: partido_id*, clave_edicion*, jugador_id*
     */
    Route::post('jugador_by_id', 'JugadorController@getJugadorById');

    /**
     * Inserta un jugador con los datos pasados como parámetro.
     * Parámetros: partido_id*, clave_edicion*, nombre*, handicap*
     */
    Route::post('jugador_insert', 'JugadorController@store');

    /**
     * Actualiza el jugador por medio de su id y los datos
     * pasados como parámetro.
     * Parámetros: partido_id*, clave_edicion*, jugador_id*, nombre, handicap
     */
    Route::put('jugador_update', 'JugadorController@update');

    /**
     * Devuelve el partido por medio de su id.
     * Parámetros: partido_id*, clave_edicion*
     */
    Route::post('partido_by_id', 'PartidoController@getPartidoById');

    /**
     * Actualiza el partido por medio de su id y los datos
     * pasados como parámetro.
     * Parámetros: partido_id*, clave_edicion*
     */
    Route::put('partido_update', 'PartidoController@update');

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
Route::get('apuesta', 'ApuestaController@index');
Route::get('apuesta/{id}', 'ApuestaController@show');

/**
 * -----------------------------------------------------------------------------
 * Rutas implementadas con fines de testing.
 * -----------------------------------------------------------------------------
 */

Route::get('partido_all', 'PartidoController@index');
Route::get('partido_vaciar_finalizados',
    'PartidoController@vaciarPartidosFinalizados');