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
/* frontpage */
mix.styles([
      'html5blank-stable/css/bootstrap-reboot.min.css',
      'html5blank-stable/css/bootstrap.min.css',
      'html5blank-stable/css/bootstrap-grid.min.css',
      'html5blank-stable/normalize.css',
      'html5blank-stable/css/main.css',
      'html5blank-stable/css/slick.css',
      'html5blank-stable/css/slick-theme.css',
      'html5blank-stable/css/home.css',
      'html5blank-stable/css/page-14.css',
      'html5blank-stable/css/search.css',
      'html5blank-stable/css/mobile-header.css',
      'html5blank-stable/css/main.css',
      'html5blank-stable/style.css',
   ], 'html5blank-stable/css/min/front.css');
/* product */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/page-14.css',
   'html5blank-stable/css/page-33.css',
   'html5blank-stable/css/slick.css',
   'html5blank-stable/css/slick-theme.css',
   'html5blank-stable/css/single.css',
   'html5blank-stable/css/shop.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
   ], 'html5blank-stable/css/min/product.css');
/* single */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/page-14.css',
   'html5blank-stable/css/single.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
], 'html5blank-stable/css/min/single.css');
/* shop */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/shop.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
], 'html5blank-stable/css/min/shop.css');
/* cart */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/cart.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
], 'html5blank-stable/css/min/cart.css');
/* checkout */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/checkout.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
], 'html5blank-stable/css/min/checkout.css');
/* page */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/page-branches.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
], 'html5blank-stable/css/min/page.css');
/* common */
mix.styles([
   'html5blank-stable/css/bootstrap-reboot.min.css',
   'html5blank-stable/css/bootstrap.min.css',
   'html5blank-stable/css/bootstrap-grid.min.css',
   'html5blank-stable/normalize.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/css/page-14.css',
   'html5blank-stable/css/search.css',
   'html5blank-stable/css/mobile-header.css',
   'html5blank-stable/css/main.css',
   'html5blank-stable/style.css',
], 'html5blank-stable/css/min/common.css');