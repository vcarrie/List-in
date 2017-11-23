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
	'resources/assets/js/vendor/jquery-3.2.1.min.js',
	'resources/assets/js/vendor/jquery.rateyo.min.js',
	'resources/assets/js/vendor/modernizr-3.5.0.min.js',
	'resources/assets/js/vendor/bootstrap.min.js',
	'resources/assets/js/vendor/bootstrap-tagsinput.min.js',
	'resources/assets/js/vendor/bootstrap-select.min.js',
	'resources/assets/js/vendor/typeahead.bundle.min.js',
    'resources/assets/js/main.js',
    'resources/assets/js/plugins.js',
	'resources/assets/js/catalogue.js',
	'resources/assets/js/article-search.js',
    'resources/assets/js/admin.js',
    'resources/assets/js/account.js'
], 'public/js/all.js');

//mix.copyDirectory('resources/assets/images', 'public/images');

mix.sass('resources/assets/sass/theme.scss', 'public/css/')
   .styles([
	'resources/assets/css/typography.css',
	'resources/assets/css/browserfix.css',
	'resources/assets/css/normalize.css',
	'resources/assets/css/bootstrap.min.css',
	'resources/assets/css/bootstrap-select.min.css',
	'resources/assets/css/bootstrap-tagsinput.min.css',
	'resources/assets/css/jquery.rateyo.min.css',
	'public/css/theme.css'
], 'public/css/all.css');
