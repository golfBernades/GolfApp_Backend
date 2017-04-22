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

Route::resource('jugador', 'JugadorController', ['except' => ['create', 'edit']]);

/*
--------------------------------------------------------------------------------
Rutas de los campos
--------------------------------------------------------------------------------
*/

Route::resource('campo', 'CampoController', ['except' => ['create', 'edit']]);

/*
--------------------------------------------------------------------------------
Rutas de las apuestas
--------------------------------------------------------------------------------
*/

Route::resource('apuesta', 'ApuestaController', ['except' => ['create',
    'edit']]);

/*
--------------------------------------------------------------------------------
Rutas de los partidos
--------------------------------------------------------------------------------
*/

Route::resource('partido', 'PartidoController', ['except' => ['create',
    'edit']]);
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