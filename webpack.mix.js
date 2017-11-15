let mix = require('laravel-mix');

// see: https://github.com/JeffreyWay/laravel-mix/issues/879
mix.webpackConfig({devtool: 'source-map'});
//mix.sourceMaps();

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

// Back-end / administrative facing assets.
mix.sass(
    'modules/Core/Resources/scss/admin.scss'
    //'vendor/mesour/datagrid/public/mesour.grid.min.css'
, 'public/dist/css/admin.css');

mix.js([
    'modules/Core/Resources/js/admin.js',
    'vendor/mesour/datagrid/public/mesour.grid.min.js'
], 'public/dist/js/admin.js');

// front-end client facing assets
mix.sass(
    'modules/Core/Resources/scss/frontend.scss'
,'public/dist/css/frontend.css');

mix.js([
    'modules/Core/Resources/js/frontend.js'
], 'public/dist/js/frontend.js');