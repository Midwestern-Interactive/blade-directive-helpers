<?php
namespace MWI\BladeHelpers\Providers;

use Blade;
use File;
use Illuminate\Support\ServiceProvider;

class BladeDirectiveProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('asset', function ($file) {

            $file = str_replace(['(', ')', "'"], '', $file);
            $filename = $file;

                // Internal file
            if (!starts_with($file, '//') && !starts_with($file, 'http') && File::exists(public_path() . '/' . $file)) {
                $version = File::lastModified(public_path() . '/' . $file);
                $filename = $file . '?v=' . $version;
                if (!starts_with($filename, '/')) {
                    $filename = '/' . $filename;
                }
            }

            return $filename;
        });


        Blade::directive('icon', function($args) {
            $parts = explode(',', str_replace(["('", "')", '"', "'", ' '], '', $args));
            $argLength = count($parts);
            $name = $parts[0];
            $provider = $argLength < 2 ? "fa" : $parts[1];
            $element = "i";
            if($argLength >= 3) {
                $element = $parts[2];
            }elseif($provider != "fa") {
                $element = "span";
            }

            return "<$element class='$provider $provider-$name' aria-hidden='true'></$element>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
