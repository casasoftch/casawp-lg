var gulp = require('gulp');
var less = require('gulp-less');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');

gulp.task('less', function() {
  gulp.src('less/casawp-lg-admin.less').pipe(less({relativeUrls: false})).pipe(autoprefixer()).pipe(minifyCSS({'rebase' : false})).pipe(gulp.dest('./../css'));
  gulp.src('less/casawp-lg-front.less').pipe(less({relativeUrls: false})).pipe(autoprefixer()).pipe(minifyCSS({'rebase' : false})).pipe(gulp.dest('./../css'));
});

gulp.task('js', function(){
	gulp.src(['js/casawp-lg-front.js', 'node_modules/rangeslider.js/dist/rangeslider.js', 'node_modules/jssha/src/sha.js'])
		.pipe(uglify().on('error', function(e){
			console.log(e);
		}))
		.pipe(concat('casawp-lg-front.min.js'))
		.pipe(gulp.dest('./../js'))
	;
	gulp.src('node_modules/moment/min/moment.min.js')
		.pipe(gulp.dest('./../js'));

	// gulp.src('node_modules/rangeslider.js/dist/rangeslider.js').pipe(uglify()).pipe(gulp.dest('./../js'));
	// gulp.src('js/casawp-lg-front.js').pipe(uglify()).pipe(gulp.dest('./../js'));
	// gulp.src('js/casawp-lg-options.js').pipe(uglify()).pipe(gulp.dest('./../js'));
	// gulp.src('js/casawplg-meta-box.js').pipe(uglify()).pipe(gulp.dest('./../js'));
	// gulp.src('js/jquery.canvasAreaDraw.min.js').pipe(uglify()).pipe(gulp.dest('./../js'));
});

gulp.task('watch', function(){
	gulp.watch(['less/casawp-lg-front.less'], ['less']);
	gulp.watch(['js/*.js'], ['js']);
});

gulp.task('default', ['less', 'js', 'watch']);
