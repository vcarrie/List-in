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

mix.js(['resources/assets/js/app.js',
    'resources/assets/js/mCustomScrollbar.min.js',
    'resources/assets/js/modernizr-3.5.0.min.js',
    'resources/assets/js/main.js',
    'resources/assets/js/plugins.js',
    'resources/assets/js/typeahead.bundle.min.js'
], 'public/js');

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.copyDirectory('resources/assets/images', 'public/images');
mix.copyDirectory('resources/assets/fonts', 'public/fonts');