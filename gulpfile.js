var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
    
    mix.scripts([
        "../../node_modules/jquery/dist/jquery.min.js",
        "../../node_modules/bootstrap/dist/js/bootstrap.min.js",
        "../../node_modules/jquery-mask-plugin/dist/jquery.mask.min.js",
        "consultaCep.js",
        "app.js"
    ], 'public/js/main.js');
});
