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

mix.browserSync({proxy: "http://127.0.0.1:8000"})
   .sass('resources/assets/sass/app.scss', 'public/css')
   .js('resources/assets/js/assets.js', 'public/js')
   .js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/front.js', 'public/js')
   .version();