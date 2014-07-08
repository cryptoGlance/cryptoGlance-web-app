var gulp = require('gulp')
var uglify = require('gulp-uglify')
var concat = require('gulp-concat')
var cssmin = require('gulp-cssmin')
var processhtml = require('gulp-processhtml')

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

gulp.task('html', function () {
  gulp.src('includes/head.php')
  .pipe(processhtml('head.php'))
  .pipe(gulp.dest('build/includes/'))

  gulp.src('includes/scripts.php')
  .pipe(processhtml('scripts.php'))
  .pipe(gulp.dest('build/includes/'))
})

gulp.task('watch', function() {
  function notify(evt){
    console.log('File ' + evt.path + ' was ' + evt.type + ', running tasks...')
  }

  gulp.watch('js/dashboard/**/*.js', ['scripts'])
  .on('change', notify)

  gulp.watch('css/**/*.css', ['styles'])
  .on('change', notify)

  gulp.watch(['includes/head.php', 'includes/scripts.php'], ['html'])
})

gulp.task('default', ['watch', 'styles', 'scripts', 'html'])
