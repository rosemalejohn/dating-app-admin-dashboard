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
	    	'global/plugins-md.scss'
	    ], 'public/assets/css/global.css')

	    .styles(['custom.css', 'default.css', 'layout.css'])

	    .sass([
	    	'grey.scss', 'layout.scss'
	    ], 'public/css/themes.css')

	    .sass('pages/error.scss', 'public/assets/pages/css')
	    .sass('pages/profile.scss', 'public/assets/pages/css')

	    .browserify('app.js', null, 'vue');
});
