var gulp 		= require( 'gulp' );				// Gulp!
var sass        = require( 'gulp-sass' );           // Sass
var sourcemaps 	= require( 'gulp-sourcemaps' );		// Sourcemaps
// var prefix 		= require( 'gulp-autoprefixer' );	// Autoprefixr
// var minifycss 	= require( 'gulp-minify-css' );		// Minify CSS
var cleancss    = require( 'gulp-clean-css' );      // Minify CSS
var concat 		= require( 'gulp-concat' );			// Concat files
var uglify 		= require( 'gulp-uglify' );			// Uglify javascript
var rename 		= require( 'gulp-rename' );			// Rename files
var util 		= require( 'gulp-util' );			// Writing stuff
var livereload 	= require( 'gulp-livereload' );		// LiveReload
// var browserSync = require('browser-sync').create();
var server 		= require( 'tiny-lr' );
var jshint 		= require( 'gulp-jshint' );			// jshint
var del 		= require( 'del' );

sass.compiler = require('node-sass');

/**
 * Compile Main CSS
 */
gulp.task( 'theme-style', function() {
    return gulp.src('assets/scss/main.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe( sourcemaps.write() )                               // Generate sourcemaps
        .pipe( concat( 'main.css' ) )                             // Concat all css
        .pipe( gulp.dest( 'assets/dist/' ) )                     // Set the destination to assets/css
        .pipe( rename( { suffix: '.min' } ) )                     // Rename
        .pipe( cleancss( { 'keepSpecialComments' : 0 } ) )        // Minify
        .pipe( gulp.dest( 'assets/dist/' ) );	                  // Save again

    util.log( util.colors.yellow( 'Sass compiled & minified' ) ); // Output to terminal
} );

/**
 * Compile all CSS for the site
 */
// gulp.task( 'admin-style', function() {
// 	return sass( 'assets/scss/admin.scss', { // Compile sass
// 			sourcemap: true
// 			// loadPath: process.cwd()
// 		} ) // Compile sass
// 		.on( 'error', function ( err ) {
// 			console.error( 'Error!', err.message );
// 		} )
// 		.pipe( sourcemaps.write() )				// Generate sourcemaps
// 		.pipe( concat( 'admin.css' ) )         	// Concat all css
// 		.pipe( gulp.dest( 'assets/dist/' ) )   	// Set the destination to assets/css
// 		.pipe( rename( { suffix: '.min' } ) )   	// Rename
// 		.pipe( minifycss() )                  	// Minify
// 		.pipe( gulp.dest( 'assets/dist/' ) ); 	// Save again
//
// 	util.log( util.colors.yellow( 'Sass compiled & minified' ) ); // Output to terminal
// } );

/**
 * Get all the JS, concat and uglify
 */
gulp.task( 'javascripts', function() {
	gulp.src( [
		// dependencies
        'bower_components/jquery/dist/jquery.min.js',

		// moving on...
		'assets/js/_*.js'] )					// Gets all the user JS _*.js from assets/js
		.pipe( concat( 'scripts.js' ) )			// Concat all the scripts
		.pipe( gulp.dest( 'assets/dist/' ) )	// Set destination to assets/js
		.pipe( rename( { suffix: '.min' } ) )	// Rename it
		.pipe( uglify() )						// Uglify & minify it
		.pipe( gulp.dest( 'assets/dist/' ) )	// Set destination to assets/js

		util.log(util.colors.yellow( 'Javascripts compiled and minified' ));
} );

/**
 * Get all the JS, concat and uglify
 */
gulp.task( 'admin-js', function() {
	gulp.src( [
		'assets/js/admin.js'] )					// Gets all the user JS _*.js from assets/js
		.pipe( concat( 'admin.js' ) )			// Concat all the scripts
		.pipe( rename( { suffix: '.min' } ) )	// Rename it
		.pipe( uglify() )						// Uglify & minify it
		.pipe( gulp.dest( 'assets/dist/' ) )	// Set destination to assets/js

		util.log(util.colors.yellow( 'Javascripts compiled and minified' ));
} );

/**
 * JS hint
 */
gulp.task( 'jshint', function() {
	gulp.src( 'assets/js/_*.js' )
		.pipe( jshint() )
		.pipe( jshint.reporter( 'jshint-stylish' ) );
} );

/**
 * Minify all SVGs and images
 */
gulp.task( 'svgmin', function() {
	gulp.src( 'assets/img/*.svg' )						// Gets all SVGs
	.pipe( svgmin() )									// Minifies SVG
	.pipe( gulp.dest( 'assets/img_min/' ) );			// Set destination to assets/img_min/
	util.log( util.colors.yellow( 'SVGs minified' ) );	// Output to terminal
} );

/**
 * Move files
 */
gulp.task( 'move', ['clean'], function() {
	// gulp.src( ['bower_components/linearicons/dist/web-font/style.css'] )
	// .pipe( rename( { prefix: '_', extname: '.scss' } ) )
	// .pipe( gulp.dest( 'assets/fonts/linearicons' ) );

	gulp.src( ['bower_components/linearicons/dist/web-font/fonts/*.*'] )
	.pipe( gulp.dest( 'assets/fonts/linearicons' ) );

	util.log( util.colors.yellow( 'Files and fonts copied' ));	// Output to terminal
} );

/**
 * Clean up
 */
gulp.task( 'clean', function() {
	del( ['**/.DS_Store'] );
	util.log( util.colors.yellow( 'Cleaning done' ) );	// Output to terminal
} );

gulp.task( 'watch-browser-sync', [ 'theme-style' ], function() {
	browserSync.init( {
		server: {
		    baseDir: "/."

		}
	} );

	gulp.watch( 'assets/scss/**/*.scss', [ /* 'admin-style', */ 'theme-style' ] );		// Watch and run sass on changes
	gulp.watch( 'assets/js/_*.js', [ 'jshint', 'javascripts' ] ); // Watch and run javascripts on changes
	gulp.watch( 'assets/js/admin.js', [ 'jshint', 'admin-js' ] ); // Watch and run javascripts on changes

	// Handy message
	util.log( 'Watching source files for changes... Press ' + util.colors.cyan( 'CTRL + C' ) + ' to stop.' );

	// Reload when php files, compiled css, compiled js and images change.
	gulp.watch( [ '**/*.php', 'assets/dist/**', 'assets/img/**' ] ).on( 'change', function( file ) {
		browserSync.reload
		util.log( util.colors.yellow( 'File changed' + ': ' + file.path ) );
	} );

	// gulp.watch( "app/*.html").on('change', browserSync.reload);
} );

/**
 * Default gulp task.
 */
gulp.task( 'watch', function() {
	// Watch and listen
	gulp.watch( 'assets/scss/**/*.scss', [ /* 'admin-style', */ 'theme-style' ] );		// Watch and run sass on changes
	gulp.watch( 'assets/js/_*.js', [ 'jshint', 'javascripts' ] ); // Watch and run javascripts on changes
	gulp.watch( 'assets/js/admin.js', [ 'jshint', 'admin-js' ] ); // Watch and run javascripts on changes
	livereload.listen();

	// Handy message
	util.log( 'Watching source files for changes... Press ' + util.colors.cyan( 'CTRL + C' ) + ' to stop.' );

	// Reload when php files, compiled css, compiled js and images change.
	gulp.watch( [ '**/*.php', 'assets/dist/**', 'assets/js/**', 'assets/img/**' ] ).on( 'change', function( file ) {
		gulp.src( file.path ).pipe( livereload() ); // Trigger LiveReload
		util.log( util.colors.yellow( 'File changed' + ': ' + file.path ) );
	} );

} );

gulp.task( 'default', [ /* 'admin-style', */ 'theme-style', 'jshint', /*'admin-js',*/ 'javascripts', 'move', 'clean', 'watch' ] );
