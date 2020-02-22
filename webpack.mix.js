const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .js([
        'resources/js/admin/app.js',
    ], 'public/assets/admin/js/app.js')
   .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin/app.scss', 'public/assets/admin/css')
    .copyDirectory('node_modules/dropify/dist', 'public/assets/admin/plugin/dropify')
    .copyDirectory('node_modules/select2/dist', 'public/assets/admin/plugin/select2')
;
