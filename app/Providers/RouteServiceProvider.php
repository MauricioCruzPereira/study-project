<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace = "App\\Http\\Controllers";


    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::namespace($this->namespace)->middleware('api')->prefix('api')->group(function(){
                Route::namespace('User')->prefix('user')->group(base_path('routes/user/user.php'));
            });

            Route::namespace($this->namespace)->middleware('api')->prefix('api')->group(function(){
                Route::namespace('Login')->group(base_path('routes/login/login.php'));
            });

            Route::namespace($this->namespace)->middleware('api')->prefix('api')->group(function(){
                Route::namespace('Product')->prefix('product')->group(base_path('routes/product/product.php'));
            });

            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
        });
    }
}
