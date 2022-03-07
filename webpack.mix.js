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


// use tailwind instead of bootstrap
// mix.js('resources/js/app.js', 'public/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/css');

mix.js("resources/js/app.js", "public/js")
.vue()
.postCss("resources/css/app.css", "public/css", [
    require("tailwindcss"),
]);



// browser auto refresh
mix.browserSync('127.0.0.1:8000');
