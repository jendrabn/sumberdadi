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

let asset = 'public/assets/';
let css = asset + '/css';
let js = asset + '/js';

mix.sass('resources/sass/app.scss', css)
    .sass('resources/sass/components.scss', css)
    .sass('resources/sass/front/ui.scss', css)
    .sass('resources/sass/front/responsive.scss', css)
    .sass('resources/sass/front/bootstrap.scss', css)
    .js('resources/js/app.js', js)
    .js('resources/js/front.js', js)
    .extract();

// if (mix.inProduction()) {
//     mix.version();
// }
