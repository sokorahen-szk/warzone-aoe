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

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@atoms': path.resolve(__dirname, 'resources/js/components/atoms'),
            '@molecules': path.resolve(__dirname, 'resources/js/components/molecules'),
            '@organisms': path.resolve(__dirname, 'resources/js/components/organisms'),
            '@pages': path.resolve(__dirname, 'resources/js/components/pages'),
            '@templates': path.resolve(__dirname, 'resources/js/components/templates'),
        }
    }
});