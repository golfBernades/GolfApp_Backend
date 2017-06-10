<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' =>
            \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'edicion_partido' =>
            \App\Http\Middleware\EdicionPartidoMiddleware::class,
        'consulta_edicion' =>
            \App\Http\Middleware\ConsultaEdicionPartidoMiddleware::class,
        'propietario_campo' =>
            \App\Http\Middleware\PropietarioCampoMiddleware::class,
        'usuario_logueado' =>
            \App\Http\Middleware\LoginMiddleware::class,
        'jugador_partido' =>
            \App\Http\Middleware\JugadorPartidoMiddleware::class,
    ];
}
