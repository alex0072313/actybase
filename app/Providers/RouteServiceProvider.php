<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use App\User;
use Auth;

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
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();

        Route::bind('user', function ($value) {

            $user = User::whereId($value)->first();

            if($user) {
                if (!Auth::user()->hasRole('megaroot')) {

                    if($user->hasRole('megaroot')){
                        return abort(403);
                    }

                    if (($user->id != Auth::id()) && Auth::user()->hasRole('boss')) {
                        if ($user->company->id == Auth::user()->company->id) {
                            return $user;
                        }else{
                            return abort(404);
                        }
                    }elseif ($user->id == Auth::id()){
                        return $user;
                    }else{
                        return abort(403);
                    }
                }else{
                    return $user;
                }
            }else {
                return abort(404);
            };
        });

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
