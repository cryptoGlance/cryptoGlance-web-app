var gulp = require('gulp')
var uglify = require('gulp-uglify')
var concat = require('gulp-concat')
var cssmin = require('gulp-cssmin')

gulp.task('styles', function () {
  gulp.src('css/**/*.css')
  .pipe(cssmin())
  .pipe(concat('styles.css'))
  .pipe(gulp.dest('build/css/'))
})

gulp.task('scripts', function () {
  gulp.src('js/dashboard/**/*.js')
  .pipe(uglify())
  .pipe(concat('cg.js', {newLine: '\r\n'}))
  .pipe(gulp.dest('build/js/dashboard/'))
})

gulp.task('watch', function() {
  gulp.watch('js/dashboard/**/*.js', ['scripts'])
  .on('change', function (evt) {
    console.log('File ' + evt.path + ' was ' + evt.type + ', running tasks...')
  })
})

gulp.task('default', ['watch', 'styles', 'scripts'])
