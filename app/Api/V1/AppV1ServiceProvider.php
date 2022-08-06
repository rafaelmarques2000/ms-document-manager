<?php
namespace App\Api\V1;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppV1ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('app/Api/V1/routes.php'));
        });
    }
}
