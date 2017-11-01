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

mix.scripts([
	'public/js/vendor/jquery-3.2.1.min.js',
	'public/js/vendor/modernizr-3.5.0.min.js',
	'public/js/vendor/bootstrap.min.js',
	'public/js/vendor/bootstrap-tagsinput.min.js',
	'public/js/vendor/bootstrap-select.min.js',
	'public/js/vendor/typeahead.bundle.min.js',
	'public/js/plugins.js',
	'public/js/catalogue.js',
	'public/js/main.js'
], 'public/js/all.js');

//mix.copyDirectory('resources/assets/images', 'public/images');

mix.sass('resources/assets/sass/theme.scss', 'public/css');
mix.styles([
	'public/css/typography.css',
	'public/css/browserfix.css',
	'public/css/normalize.css',
	'public/css/bootstrap.min.css',
	'public/css/bootstrap-select.min.css',
	'public/css/bootstrap-tagsinput.min.css',
	'public/css/theme.css'
], 'public/css/all.css');