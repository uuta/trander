const mix = require('laravel-mix')

mix.browserSync('trander.net')
   .js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .version()