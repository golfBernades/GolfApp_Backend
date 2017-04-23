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
Rutas de los jugadores
--------------------------------------------------------------------------------
*/

Route::get('jugador', 'JugadorController@index');
Route::get('jugador/{id}', 'JugadorController@show');
Route::post('jugador/', 'JugadorController@store');
Route::put('jugador/{id}', 'JugadorController@update');
Route::delete('jugador/{id}', 'JugadorController@destroy');

/*
--------------------------------------------------------------------------------
Rutas de los campos
--------------------------------------------------------------------------------
*/

Route::get('campo', 'CampoController@index');
Route::get('campo/{id}', 'CampoController@show');
Route::post('campo/', 'CampoController@store');
Route::put('campo/{id}', 'CampoController@update');
Route::delete('campo/{id}', 'CampoController@destroy');

/*
--------------------------------------------------------------------------------
Rutas de las apuestas
--------------------------------------------------------------------------------
*/

Route::get('apuesta', 'ApuestaController@index');
Route::get('apuesta/{id}', 'ApuestaController@show');
Route::post('apuesta/', 'ApuestaController@store');
Route::put('apuesta/{id}', 'ApuestaController@update');
Route::delete('apuesta/{id}', 'ApuestaController@destroy');

/*
--------------------------------------------------------------------------------
Rutas de los partidos
--------------------------------------------------------------------------------
*/

Route::get('partido', 'PartidoController@index');
Route::get('partido/{id}', 'PartidoController@show');
Route::post('partido/', 'PartidoController@store');
Route::put('partido/{id}', 'PartidoController@update');
Route::delete('partido/{id}', 'PartidoController@destroy');

Route::get('vaciar_partidos_finalizados',
    'PartidoController@vaciarPartidosFinalizados');

/*
--------------------------------------------------------------------------------
Rutas de la gestión de los jugadores asociados a los partidos
--------------------------------------------------------------------------------
*/

Route::get('add_jugador_to_partido/{jugador_id}/{partido_id}',
    'JugadorPartidoController@addJugador');
Route::get('all_jugador_all_partido',
    'JugadorPartidoController@allJugadorAllPartido');
Route::get('remove_jugador_from_partido/{jugador_id}/{partido_id}',
    'JugadorPartidoController@removeJugador');
Route::get('jugadores_en_partido/{partido_id}',
    'JugadorPartidoController@getJugadoresEnPartido');
Route::get('partidos_de_jugador/{jugador_id}',
    'JugadorPartidoController@getPartidosDelJugador');
Route::get('vaciar_partido/{partido_id}',
    'JugadorPartidoController@vaciarPartido');

/*
--------------------------------------------------------------------------------
Rutas de la gestión de las apuestas asociadas a los partidos
--------------------------------------------------------------------------------
*/

Route::get('all_apuesta_all_partido',
    'ApuestaPartidoController@allApuestaAllPartido');
Route::get('add_apuesta_to_partido/{apuesta_id}/{partido_id}',
    'ApuestaPartidoController@addApuesta');
Route::get('remove_apuesta_from_partido/{apuesta_id}/{partido_id}',
    'ApuestaPartidoController@removeApuesta');
Route::get('apuestas_en_partido/{partido_id}',
    'ApuestaPartidoController@getApuestasEnPartido');
Route::get('partidos_con_apuesta/{apuesta_id}',
    'ApuestaPartidoController@getPartidosConApuesta');

/*
--------------------------------------------------------------------------------
Rutas de la gestión de las puntuaciones de los jugadores en los partidos
--------------------------------------------------------------------------------
*/

Route::get('puntuaciones_all_jugador_all_partido',
    'PuntuacionesController@getPuntuacionesAllJugadorAllPartido');
Route::get('puntuaciones_jugador_partido/{jugador_id}/{partido_id}',
    'PuntuacionesController@getPuntuacionesJugadorPartido');
Route::get('puntuaciones_jugador_partido_hoyo/{jugador_id}/{partido_id}/{hoyo}',
    'PuntuacionesController@getPuntuacionesJugadorPartidoHoyo');
Route::post('registrar_puntuaciones',
    'PuntuacionesController@registrarPuntuaciones');

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
    Route::post('test_edicion_partido', 'PuntuacionesController@testEdicion');
});