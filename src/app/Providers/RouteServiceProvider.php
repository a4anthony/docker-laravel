<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Request $request)
    {
        if ($request->getHttpHost() == env('API_URL')) {
            //dd($request->getHttpHost());
            $this->mapApiRoutes();
        }
        if ($request->getHttpHost() == env('APP_BASE_DOMAIN')) {
            //dd($request->getHttpHost());
            $this->mapWebRoutes();
        }
        if ($request->getHttpHost() == env('ADMIN_URL')) {
            //dd($request->getHttpHost());
            $this->mapAdminRoutes();
        }
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
        Route::domain($this->_baseDomain(''))
            ->middleware('web')
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
        Route::domain($this->_baseDomain('api'))
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::domain($this->_baseDomain('admin'))
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }
    /**
     * Undocumented function
     *
     * @param string $subdomain 
     *
     * @return string
     * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
     */
    private function _baseDomain(string $subdomain = ''): string
    {
        if (strlen($subdomain) > 0) {
            $subdomain = "{$subdomain}.";
        }

        //dd($subdomain);
        return $subdomain . config('app.base_domain');
    }
}
