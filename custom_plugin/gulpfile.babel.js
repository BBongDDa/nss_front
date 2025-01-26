const gulp = require('gulp')
const $ = require('gulp-load-plugins')()
const Path = require('path')
let generateSourceMaps = process.env.NODE_ENV !== 'production'

if (process.env.SOURCEMAPS === 'true' || process.env.SOURCEMAPS === '1') {
  generateSourceMaps = true
}


const themeTaskSass = function () {
  return gulp.src(['./src/Components/Themes//**/*.scss'])
      .pipe($.if(generateSourceMaps, $.sourcemaps.init()))
      .pipe($.plumber())
      .pipe($.sass({
        // includePaths: sassPaths,
        outputStyle: (generateSourceMaps) ? 'expanded' : 'compressed'
      }).on('error', $.sass.logError))
      .pipe($.autoprefixer())
      .pipe($.rename(function (filepath) {
        filepath.dirname = Path.join(filepath.dirname, 'css')
      }))
      .pipe($.if(generateSourceMaps, $.sourcemaps.write('.')))
      .pipe(gulp.dest('./src/Components/Themes/CustomTheme/assets'))
}
themeTaskSass.displayName = 'theme_sass'


const taskWatch = function () {
  gulp.watch(['./views/**/assets/src/scss/**/*.scss'], gulp.series(taskSass))
  gulp.watch(['./assets/themes/scss/**/*.scss'], gulp.series(themeTaskSass))
}

// gulp.task('default', gulp.series(taskSass, taskScript)) => taskScript 사용 안해서 제외
gulp.task('default', gulp.series( themeTaskSass))
gulp.task('build', gulp.series( themeTaskSass))
gulp.task('watch', taskWatch)

gulp.task( themeTaskSass)
