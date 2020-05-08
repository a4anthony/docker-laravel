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
    .sass('resources/sass/app.scss', 'public/css');
mix.combine([
    'public/css/bootstrap.min.css',
    'public/css/font-awesome.min.css',
    'public/css/owl.carousel.min.css',
    'public/css/animate.css',
    'public/css/jquery-ui.css',
    'public/css/metisMenu.css',
    'public/css/slicknav.min.css',
    'public/css/swiper.min.css',
    'public/css/styles.css',
    'public/css/custom.css',
    'public/css/responsive.css',
], 'public/css/mart-app.css').version();
mix.combine([
    'public/js/vendor/jquery-2.2.4.min.js',
    'public/js/bootstrap.min.js',
    'public/js/owl.carousel.min.js',
    'public/js/mouse_scroll.js',
    'public/js/scrollup.js',
    'public/js/slicknav.js',
    'public/js/jquery.zoom.min.js',
    'public/js/swiper.min.js',
    'public/js/metisMenu.min.js',
    'public/js/jquery-ui.min.js',
    'public/js/scripts.js',
    'public/js/subscribe.js',
    'public/js/search.js',
], 'public/js/mart-app.js').version();
mix.js('resources/js/cart.js', 'public/js/cart.js').version();
mix.js('resources/js/checkout.js', 'public/js/checkout.js').version();
mix.js('resources/js/shop.js', 'public/js/shop.js').version();