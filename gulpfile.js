confName = 'ct-translations'; // Will be used in url and references

devDir = 'dev';
buildDir = 'build';

var path = require('path');
var fs = require('fs');
var util = require('util');
var browserSync = require('browser-sync').create(confName);
var del = require('del');
var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var cache = require('gulp-cache');
var connect = require('gulp-connect-php');
var cssnano = require('gulp-cssnano');
var gulpIf = require('gulp-if');
var imagemin = require('gulp-imagemin');
var plumber = require('gulp-plumber');
var prompt = require('gulp-prompt');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var useref = require('gulp-useref');
var gutil = require('gulp-util');
var runSequence = require('run-sequence');
var ftp = require('gulp-invipo-deploy');

confLocal = false;
confPhp = true;
confSSL = false;
confWP = true;
confFoundation = false;
confFtpTarget = 'development'; // Please set default (check .ftp-config.json)
confFtpRoot = '/webroot/wp-content/themes/ct';

confProxy = util.format('http%s://%s.dev', confSSL ? 's' : '', confName);

error = gutil.colors.red;
warning = gutil.colors.yellow;
info = gutil.colors.blue;
success = gutil.colors.green;

gutil.env.tunnel ? confTunnel = confName : confTunnel = false;

gulp.task('default', function(callback) {
	runSequence(['sass', 'browserSync', 'watch'],
		callback);
});

gulp.task('build', function(callback) {
	log('Building!', 'info');

	runSequence('clean:dist',
		['css', 'useref', 'images', 'fonts', 'languages', 'phpCp'],
		'ftp',
		callback);
	gutil.beep();
});

gulp.task('watch', ['browserSync', 'sass'], function() {
	gulp.watch(globDeclaration('.scss', 'sass'), ['sass'])
	gulp.watch(globDeclaration('.html'), browserSync.reload)
	gulp.watch(globDeclaration('.js', 'js'), browserSync.reload)
	gulp.watch(globDeclaration('.php'), browserSync.reload)
});

gulp.task('sass', function() {
	sassProcess();
});

gulp.task('css', function() {
	sassProcess();
	autoprefix();
});

gulp.task('browserSync', ['php'], function() {
	browserSync.init({
		proxy: confPhp ? confProxy : false,
		server: !confPhp ? { baseDir: devDir } : false,
		tunnel: confTunnel,
		reloadOnRestart: true,
		port: 8010
	});

	if(gutil.env.ftp) {
		runSequence('ftp', callback);
	}
});

gulp.task('php', function() {
	if(confPhp) {
		connect.server({ base: devDir, port: 8010, keepalive: true});
	}
});

gulp.task('ftp', function() {
	/**
	 * Enables ftp features.
	 * 
	 * @use gulp ftp [-t ftpTarget| --target ftpTarget][-w | --watch]
	 */

	var target = gutil.env.target || gutil.env.t;
	var watch = gutil.env.watch || gutil.env.w;

	if(target) {
		confFtpTarget = target;
	}

	if(watch) {
		log('Watching');
		gulp.watch(buildDir, ['ftp']);
	}

	if(confFtpTarget === null || confFtpTarget === '') {
		log('No target server has been set!', 'error');
	} else {
		ftpOptions = {
			confFtpTarget: confFtpTarget,
			confFtpRoot: confFtpRoot,
		}

		setTimeout( function() {
			log(util.format('Syncronising %s environment!', confFtpTarget), 'info');

			return ftp({
					conn: require('./.ftp-config.json')[ftpOptions.confFtpTarget],
					src: buildDir,
					dest: ftpOptions.confFtpRoot,
					globs: [
						'./**/*.*',
					],
					clean: false,
				});
		}, 10000, ftpOptions);
	}
});

gulp.task('ftp-test', function() {
	/**
	 * Tests ftp features.
	 *
	 * @use gulp ftp test [-t ftpTarget | --target ftpTarget][-w | --watch]
	 */

	var target = gutil.env.target || gutil.env.t;
	var watch = gutil.env.watch || gutil.env.w;

	if(target) {
		confFtpTarget = target;
	}

	if(watch) {
		log('Watching');
		gulp.watch(buildDir, ['ftp-test'])
			.on('change', function() {
				log('Something changed in ftp test!', 'success');
		});
	}

	if(confFtpTarget === null || confFtpTarget === '') {
		log('No target server has been set!', 'error');
	} else {
		var date = new Date();
		var date = util.format(
			'%s_%s.%s.%s',
			date.getDate().toString(),
			date.getHours().toString(),
			date.getMinutes().toString(),
			date.getSeconds().toString()
		);

		fs.access(path.join(__dirname, 'temp/'), fs.constants.F_OK, (err) => {
			if(err) {
				fs.mkdir(path.join(__dirname, 'temp/'), (err) => {
					if(err) {
						return log(util.format('Could not make a temporary directory because: %s', err), 'error');
					} else {
						log('temp/ now exists', 'success');
					}
				});
			}

			fs.writeFile(path.join(__dirname, 'temp/', 'test-' + date + '.txt'), 'This is a test file and should be deleted.', 'utf-8', (err, data) => {
				if (err) {
					log(err, 'error');
				} else {
					log(util.format('File %s created!', data), 'success');


					log(util.format('Sending to %s environment!', confFtpTarget), 'info');
					return ftp({
						conn: require('./.ftp-config.json')[confFtpTarget],
						src: buildDir,
						dest: '/',
						globs: './temp/*',
						clean: false,
					});
				}
			});
		});
	}
});

gulp.task('useref', function(){
	if(!confWP) {
		return gulp.src( (confPhp) ? globDeclaration('.php') : globDeclaration('.html') )
			.pipe(useref())
			// Minifies only if it's a JavaScript file
			.pipe(gulpIf('*.js', uglify()))
			// Minifies only if it's a CSS file
			.pipe(gulpIf('*.css', cssnano()))
			.pipe(gulp.dest(buildDir))
	} else {
		var jsDir = globDeclaration('.js');

		log('Minifying JavaScript from: ' + jsDir, 'info');

		return gulp.src( jsDir )
			// Minifies only if it's a JavaScript file
			.pipe(gulpIf('*.js', uglify()))
			.pipe(gulp.dest(buildDir));
	}
});

gulp.task('images', function(){
	return gulp.src( (confWP) ? globDeclaration('.+(png|jpg|jpeg|gif|svg)', 'images') : globDeclaration('.+(png|jpg|jpeg|gif|svg)') )
		.pipe(cache(imagemin({
			// Setting interlaced to true
			interlaced: true
		})))
		.pipe(gulp.dest(buildDir + '/img'))
});

gulp.task('fonts', function() {
	return gulp.src(globDeclaration('', 'fonts'))
		.pipe(gulp.dest(buildDir + '/fonts'))
});

gulp.task('languages', function() {
	return gulp.src(globDeclaration('', 'languages'))
		.pipe(gulp.dest(buildDir + '/languages'))
});

gulp.task('phpCp', function() {
	if(confWP) return gulp.src( globDeclaration('.php') )
		.pipe(gulp.dest(buildDir));
});

gulp.task('clean:dist', function() {
	return del.sync(buildDir);
});

gulp.task('cache:clear', function (callback) {
	return cache.clearAll(callback);
});

function sassProcess() {
	var sassDir = globDeclaration('.scss', 'sass');

	log('Compiling [sass] from: ' + sassDir, 'info');

	return gulp.src( sassDir )
		.pipe(sass( confFoundation ? {includePaths: confFoundation + '/scss'} : {} )) // Using gulp-sass
		.pipe(gulp.dest(devDir + (confWP ? '' : '/css')))
		.pipe(browserSync.reload({
			stream: true
	}));
}

function autoprefix() {
	var cssDir = confWP ? globDeclaration('.css', false) : globDeclaration('.css', 'css');

	if(confWP) {
		var cssWPDir = globDeclaration('style.css', false);

		if( confFoundation ) {
			/* Add in foundation-sites compiled css in main directory */
			// cssDir.unshift(confFoundation + '/scss/**/*.scss');
			cssDir.push( '!' + cssWPDir[0] );
		}

		log('Autoprefixing from: ' + cssDir, 'info');

		gulp.src( cssDir )
			.pipe(autoprefixer({
				browsers: ['last 2 versions', 'ie >= 9', 'and_chr >= 2.3']
			}))
			// Minifies only if it's a CSS file
			.pipe(gulpIf('*.css', cssnano()))
			.pipe(gulp.dest(buildDir));

		gulp.src( cssWPDir )
			.pipe(autoprefixer({
				browsers: ['last 2 versions', 'ie >= 9', 'and_chr >= 2.3']
			}))
			// Minifies only if it's a CSS file
			.pipe(gulpIf('*.css', cssnano()))
			.pipe(gulp.dest(buildDir));

		return;
	} else {

		log('Autoprefixing', 'info');

		return gulp.src( cssDir )
			.pipe(autoprefixer({
				browsers: ['last 2 versions', 'ie >= 9', 'and_chr >= 2.3']
			}))
			.pipe(gulp.dest(buildDir + '/css'));
	}
}

function globDeclaration(fileType, folder = false) {
	srcGlob = [util.format('%s/%s**/*%s', devDir, folder ? folder +'/' : '', fileType),
		util.format('!%s/%s**/*-OLD*%s', devDir, folder ? folder +'/' : '', fileType)];

	return srcGlob;
}

function log(message, state = 'info') {
	switch(state) {
		case 'error':
			var preText = error.dim('xxxxxxx>');
			var postText = error.dim('<xxxxxxx');
			var message = message;
			break;

		case 'warning':
			var preText = warning.dim('-------------->');
			var message = warning(message);
			break;

		case 'success':
			var preText = success.dim('------->');
			var message = success(message);
			break;

		default:
			var preText = info.dim('------->');
			var message = info(message);
			break;

	}

	return gutil.log( util.format('Logging %s %s %s'), preText, message, postText ? postText : '' );
}

var gulp_src = gulp.src;
gulp.src = function() {
	return gulp_src.apply(gulp, arguments)
		.pipe(plumber(function(error) {
			// Output an error message
			log('Error (' + info(error.plugin) + '): ' + error.message, 'error');
			// emit the end event, to properly end the task (if not SASS! (for watch task))
			if( error.plugin !== 'gulp-sass' ) {
				this.emit('end');
			}
		})
	);
};
