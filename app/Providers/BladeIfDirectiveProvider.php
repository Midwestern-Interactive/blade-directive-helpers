<?php
namespace MWI\BladeHelpers\Providers;

use Auth;
use Blade;
use Request;
use Illuminate\Support\ServiceProvider;

class BladeIfDirectiveProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasPermission', function ($requestedPermission) {
            return Auth::user()->hasPermission($requestedPermission);
        });

        Blade::if('isInRole', function ($requestedRole) {
            return Auth::user()->hasRole($requestedRole);
        });

        Blade::if('isActive', function ($thisPath) {
            return Request::is($thisPath);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){}
}