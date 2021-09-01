//////////CONFIG //////////////

var DEVELOPMENT = false;

var locs = {
	js: {
		src: './js/src/**/*.js',
		lintSrc: './js/src/*.js', //dont want to lint modernizr etc.
		dist: './js'
	},
	sass: {
		src: './scss/**/*.scss',
		dist: './'
	},
	imgs: {
		src: './img/src/**/*',
		dist: './img'
	}
};

//create possible options for plugins per environment
//to include plugin in gulp, create at least key with empty obj (after install..)
var	pluginsConfig = {
	sourcemaps: {},
	sass: {
		dev: {
			outputStyle: 'expanded',
			sourceComments: true
		},
		dist: {
			outputStyle: 'compressed'
		}
	},
	jshint: {
		dev: {
			unused:false,
			lastsemic: true,
			loopfunc: true
		},
		dist: {
			unused:false,
			asi: true,
			loopfunc: true
		}
	},
	plumber: {},
	uglify: {},
	concat: {},
	imagemin: {},
	autoprefixer: {
		dev: {
			browsers: ['last 2 versions']
		},
		dist: {
			browsers: ['last 2 versions']
		}
	}
};

//return obj with camelCase ref to function.
function getPlugins() {

	var a, b, c, i, j, p = [], r = {};
	for (var k in pluginsConfig) {p.push(k);}

	for (i = p.length - 1; i >= 0; i--) {
		a = p[i];
		c = '';

		//no non-letters found
		if (/^[a-z]+$/i.test(a)) {
			c = a;
		} else {
			//nonletters found, rewrite to camelcase
			b = a.replace(/\W/g, '_').split('_');
			for (j = 0; j < b.length; j++) {
				if (!j) {
					c += b[j];
				} else {
					c += b[j].charAt(0).toUpperCase() + b[j].slice(1);
				}
			}
		}

		//assuming regular gulp names! gulp-plugin-name
		r[c] = require('gulp-'+a);
	}

	return r;
}

var
	gulp = require('gulp'),
	plugins = getPlugins(),
	pluginsOpts = {},
	envStr = DEVELOPMENT ? "dev" : "dist";


//set pluginOpts depending on environment
for (var pn in pluginsConfig) { pluginsOpts[pn] = pluginsConfig[pn][envStr]; }

//////////END CONFIG ///////
///////// - - - - - //////////
////////// TRIGGERS ////////////

gulp.task('default', function(){

});

gulp.task('init', ['watch-sass', 'watch-js']);

////////// END TRIGGERS /////////
///////// - - - - - //////////
///////// SASS /////////////

gulp.task('sass', function () {
  return gulp.src(locs.sass.src)
  	.pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass(pluginsOpts.sass).on('error', plugins.sass.logError))
    .pipe(plugins.autoprefixer(pluginsOpts.autoprefixer))
    .pipe(plugins.sourcemaps.write('./maps'))
    .pipe(gulp.dest(locs.sass.dist));
});

gulp.task('watch-sass', function () {
  gulp.watch('./scss/**/*.scss', ['sass']);
});

///////// END SASS /////////////
///////// - - - - - //////////
///////// JS //////////////

gulp.task('watch-js', function(){
	gulp.watch(locs.js.src, ['check-js', 'concat-js']);
});

gulp.task('check-js', function(){
	return gulp.src(locs.js.lintSrc)
	.pipe(plugins.plumber(pluginsOpts.plumber))
	.pipe(plugins.jshint(pluginsOpts.jshint))
	.pipe(plugins.jshint.reporter('default'));
});

gulp.task('concat-js', function() {
	//no minify in development
	if (DEVELOPMENT) {
	  return gulp.src(locs.js.src)
	    .pipe(plugins.concat('all.js'))
	    .pipe(gulp.dest(locs.js.dist));
	} else {
	  return gulp.src(locs.js.src)
	    .pipe(plugins.concat('all.js'))
	    .pipe(plugins.uglify(pluginsOpts.uglify))
	    .pipe(gulp.dest(locs.js.dist));
	}
});


///////// END JS /////////////
///////// - - - - - //////////
///////// MINIFY IMGS /////////////

gulp.task('minify-images', function(){
    gulp.src(locs.imgs.src)
        .pipe(plugins.imagemin(pluginsOpts.imagemin))
        .pipe(gulp.dest(locs.imgs.dist));
});


///////// END MINIFY IMGS /////////////
///////// - - - - - //////////