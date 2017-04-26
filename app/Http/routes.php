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
Grupo de rutas que requieren permisos para consultar datos sobre un partido.
--------------------------------------------------------------------------------
*/
Route::group(['middleware' => ['consulta_partido']], function () {
    Route::post('test_consulta_partido', 'PuntuacionesController@testConsulta');
});

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

    // TODO Middleware para validar permisos en dicho partido
    Route::get('add_apuesta_to_partido/{apuesta_id}/{partido_id}',
        'ApuestaPartidoController@addApuesta');
    Route::get('remove_apuesta_from_partido/{apuesta_id}/{partido_id}',
        'ApuestaPartidoController@removeApuesta');
    Route::get('apuestas_en_partido/{partido_id}',
        'ApuestaPartidoController@getApuestasEnPartido');

    Route::get('puntuaciones_jugador_partido/{jugador_id}/{partido_id}',
        'PuntuacionesController@getPuntuacionesJugadorPartido');
    Route::get('puntuaciones_jugador_partido_hoyo/{jugador_id}/{partido_id}/{hoyo}',
        'PuntuacionesController@getPuntuacionesJugadorPartidoHoyo');
    Route::post('registrar_puntuaciones',
        'PuntuacionesController@registrarPuntuaciones');
});

///*
//--------------------------------------------------------------------------------
//Rutas de prueba
//--------------------------------------------------------------------------------
//*/
//
//Route::get('campo', 'CampoController@index');
//Route::get('all_jugador_all_partido',
//    'JugadorPartidoController@allJugadorAllPartido');
//Route::get('all_apuesta_all_partido',
//    'ApuestaPartidoController@allApuestaAllPartido');
//Route::get('partidos_de_jugador/{jugador_id}',
//    'JugadorPartidoController@getPartidosDelJugador');
//Route::get('partidos_con_apuesta/{apuesta_id}',
//    'ApuestaPartidoController@getPartidosConApuesta');
//Route::get('puntuaciones_all_jugador_all_partido',
//    'PuntuacionesController@getPuntuacionesAllJugadorAllPartido');

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
    Route::post('add_jugador_to_partido', 'JugadorPartidoController@addJugador');

    /**
     * Elimina un jugador de un partido por medio de sus ids.
     * Parámetros: partido_id*, clave_edicion*, jugador_id*
     */
    Route::post('remove_jugador_from_partido', 'JugadorPartidoController@removeJugador');
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
});

/**
 * -----------------------------------------------------------------------------
 * Rutas que requieren permisos de administración de la aplicación
 * -----------------------------------------------------------------------------
 */
Route::group(['middleware' => ['administrador']], function () {
    Route::post('apuesta', 'ApuestaController@store');
    Route::put('apuesta/{id}', 'ApuestaController@update');
    Route::delete('apuesta/{id}', 'ApuestaController@destroy');
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
Route::get('apuesta_all', 'ApuestaController@index');
Route::get('apuesta/{id}', 'ApuestaController@show');

/**
 * -----------------------------------------------------------------------------
 * Rutas implementadas con fines de testing.
 * -----------------------------------------------------------------------------
 */

Route::get('partido_all', 'PartidoController@index');
Route::get('partido_vaciar_finalizados',
    'PartidoController@vaciarPartidosFinalizados');