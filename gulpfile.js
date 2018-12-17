// project_root/gulpfile.js

var gulp = require('gulp');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var concatCss = require('gulp-concat-css');

sass.compiler = require('node-sass');

var cssPath = './web/css';
 
gulp.task('sass', function () {
    return gulp.src('styles/*.scss')
      .pipe(sass().on('error', sass.logError))
      .pipe(gulp.dest(cssPath));
});

gulp.task('minify-css', function () {
   return gulp.src(cssPath + '/*.css')
      .pipe(concatCss('/min/style.min.css'))
      .pipe(minifyCss())
      .pipe(gulp.dest(cssPath));
});

gulp.task('watch:scss', function () {
   gulp.watch('styles/*.scss', gulp.series('sass', 'minify-css'));
});

gulp.task('default', gulp.series('sass', 'minify-css', 'watch:scss'));