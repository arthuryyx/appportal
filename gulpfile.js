const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
    .webpack('app.js');
});

// elixir(function(mix) {
//     mix.styles([
//         "flat-ui.min.css",
//         "vendor/bootstrap/css/bootstrap.min.css"
//     ],  'public/assets/css/styles.css');
// });
// elixir(function(mix) {
//     mix.scripts([
//         "flat-ui.min.js",
//         "vendor/html5shiv.js",
//         "vendor/jquery.min.js",
//         "vendor/respond.min.js",
//         "vendor/video.js"
//     ],  'public/assets/js/scripts.js');
// });
// elixir(function(mix) {
//     mix.version([
//         'assets/css/styles.css',
//         'assets/js/scripts.js']);
// });