const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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

elixir(mix => {
    mix.sass('blog/app.scss')
    mix.sass('dashboard/dashboard.scss')
    mix.webpack('blog/app.js')
    mix.webpack('dashboard/dashboard.js', 'public/js/dashboard.js');


    mix.copy('node_modules/materialize-css/fonts/', 'public/build/fonts/');
    mix.copy('resources/assets/fonts/', 'public/build/fonts/');

    mix.version(['js/app.js', 'js/dashboard.js', 'css/app.css', 'css/dashboard.css']);
});
