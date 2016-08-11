var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');

    mix.scripts([
    'bootstrap.min.js',
    "tether.min.js",
    "drop.min.js",
    "blazy.min.js",
    "responsiveslides.min.js",
    "lightbox.min.js",
    "script.js",
    ]);
});

