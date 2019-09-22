<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        /*
         * Générateur d'image thumbnail sans cookies de session.
         */
        Route::namespace($this->namespace)
            ->group(function () {
                Route::get('media/cache/{path}', 'ImageController@thumbnail')->where('path', '.*');
            });

        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        $middlewares = ['api'];

        if (! in_array($this->app->request->ip(), ['127.0.0.1', '::1'])) {
            $middlewares[] = 'throttle:60,1';
        }

        Route::prefix('api')
             ->middleware($middlewares)
             ->namespace('App\Api\Controllers')
             ->as('api.')
             ->group(base_path('routes/api.php'));
    }
}
