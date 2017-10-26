let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .sass([
        'resources/assets/sass/app.scss',
        'ressources/assets/sass/print.scss',
        'ressources/assets/sass/theme.scss',
        'ressources/assets/sass/speech.scss'], 'public/css')
    .combine(['public/css/vendor/browserfix.css',
             'public/css/vendor/theme.css',
             'public/css/vendor/theme.css.map'], 'public/css/all.css');
