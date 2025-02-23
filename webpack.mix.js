const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/js')
    .copy('node_modules/jquery/dist/jquery.js', 'public/js')
    .copy('node_modules/popper.js/dist/umd/popper.js', 'public/js')
    // copy files
    .copy('resources/assets', 'public')


    