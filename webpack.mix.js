let mix = require('laravel-mix');

mix.setPublicPath('public');

mix.sass('resources/sass/app.scss', 'public/css')
.version()
.sourceMaps();

mix.js('resources/js/app.js', 'public/js')

.extract([
	'lodash',
	'popper.js',
	'jquery',
	'axios',
	'bootstrap',
	'@fancyapps/fancybox'
])
.version();

