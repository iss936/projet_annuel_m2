// ===================
// Dependencies
// ===================
var path = require('path');
var appDir = path.resolve(__dirname);

var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rm = require( 'gulp-rm' );

// ===================
// Local variables
// ===================

var sassDir,compiledDir,jsDir;

sassDir = appDir + '/web/sass/';
jsDir = appDir + '/web/js/';
compiledDir = appDir + '/web/compiled/';

jsFrontFiles = [
    appDir + '/bower_components/jquery/dist/jquery.min.js',
    appDir + '/bower_components/jquery-ui/ui/jquery-ui.js',
    appDir + '/bower_components/bootstrap-select/dist/js/bootstrap-select.js',
    appDir + '/bower_components/jquery-debounce/jquery.debounce.js',
    appDir + '/bower_components/bootstrap/js/*.js',
    jsDir + '/front/**/*.js'
];

jsBackFiles = [
    appDir + '/bower_components/jquery/dist/jquery.min.js',
    appDir + '/bower_components/jquery-debounce/jquery.debounce.js',
    appDir + '/bower_components/bootstrap/js/*.js',
    jsDir + '/admin/**/*.js'
];

// ===================
// Tasks
// ===================

gulp.task( 'remove:css', function() {
    gulp.src( compiledDir + '/front/common.css', { read: false })
        .pipe( rm() );

    gulp.src( compiledDir + '/admin/common.css', { read: false })
        .pipe( rm() )
});

gulp.task( 'remove:js', function() {
    gulp.src( [compiledDir+'main.min.js' , compiledDir+"admin.min.js"], { read: false })
        .pipe( rm() )
});

// Compile sass and minify it to ./assets/compiled/stylesheets
// command : compile:sass
gulp.task('compile:sass', function () {
    gulp.start('remove:css');
    gulp.src(sassDir + 'admin/common.scss')
        .pipe(sass({
            sourceComments: false,
            outputStyle: 'compressed',
            errLogToConsole: true
        }))
        .pipe(gulp.dest(compiledDir + '/admin/'));

    gulp.src(sassDir + 'front/common.scss')
        .pipe(sass({
            sourceComments: false,
            outputStyle: 'compressed',
            errLogToConsole: true
        }))
        .pipe(gulp.dest(compiledDir + '/front/'));
});

gulp.task('compile:js', function () {

    gulp.start('remove:js');

    // compile all but exluded files
    gulp.src(jsFrontFiles)
        .pipe(uglify())// before compilation, preserve order
        .pipe(concat('main.min.js'))
        .pipe(gulp.dest(compiledDir + '/front/'));

    // compile all but exluded files
    gulp.src(jsBackFiles)
        .pipe(uglify())// before compilation, preserve order
        .pipe(concat('main.min.js'))
        .pipe(gulp.dest(compiledDir + '/admin/'));
});

// Default action
// command : gulp
gulp.task('default', function () {
    gulp.start('compile:sass');
    gulp.start('compile:js');
});

// ===================
// Watchers
// ===================

// Watcher on sass
// command : gulp watch:sass
gulp.task('watch:sass', function () {
    gulp.start('compile:sass');
    gulp.watch(sassDir + "**/*.scss", ['compile:sass'])
});

// Watcher on javascript
// command : gulp watch:js
gulp.task('watch:js', function () {
    gulp.start('compile:js');
    gulp.watch(jsDir + "**/*.js", ['compile:js'])
});
