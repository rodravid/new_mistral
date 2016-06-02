var elixir = require('laravel-elixir');
//var bowerDir = 'vendor/bower_components/';

elixir(function(mix) {

    //elixir.config.assetsDir = 'app/Vinci/App/Website/resources/assets';

    mix.sass('style.scss', 'public/assets/website/css/style.min.css', 'app/Vinci/App/Website/resources/assets');

   //mix.copy(bowerDir + 'bootstrap-sass/assets/fonts/bootstrap', 'public/fonts')
   //
   //    .copy(bowerDir + 'jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
   //    .copy(bowerDir + 'bootstrap-sass/assets/javascripts/bootstrap.min.js', 'public/js/bootstrap.min.js');
   //
   //mix.scripts([
   //    'jquery.min.js',
   //    'bootstrap.min.js',
   //    'app.js'
   //],
   //    'public/js/all.js', 'public/js');
   //
   //mix.sass('app.scss');
   //
   //mix.browserSync({
   //    proxy: 'vinci.app'
   //});
});
