var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.sass('pages/login.scss', 'public/assets/pages/css')

		.sass([
	    	'global/components-md.scss',
	    	'global/plugins-md.scss',
	    ], 'public/css/global.css')

	    // .styles(['custom.css', 'default.css', 'layout.css'])

	    .sass([
    	 	'layout.scss', 'grey.scss'
	    ], 'public/css/themes.css')

	    .sass('pages/error.scss', 'public/assets/pages/css')
	    .sass('pages/profile.scss', 'public/assets/pages/css')

	    .browserify('app.js', null, 'vue');

	 mix.copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css');
	 mix.copy('resources/assets/js/offline.min.js', 'public/js/offline.min.js');
});
