var gulp = require('gulp');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var cleanCss = require('gulp-clean-css');

var scripts =  [
    './node_modules/datatables.net/js/jquery.dataTables.min.js',
    './assets-src/scripts/datatables.manager.js',
    './assets-src/scripts/init.js'
];

var scripts_bootstrap_3 = [
    './node_modules/datatables.net/js/jquery.dataTables.min.js',
    './node_modules/datatables.net-bs/js/dataTables.bootstrap.js',
    './assets-src/scripts/datatables.manager.js',
    './assets-src/scripts/init.js'
];

var scripts_bootstrap_4 = [
    './node_modules/datatables.net/js/jquery.dataTables.min.js',
    './node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
    './assets-src/scripts/datatables.manager.js',
    './assets-src/scripts/init.js'
];


var conf = {
    bootstrap_3: ['./node_modules/datatables.net-bs/css/*.css', './node_modules/datatables.net-bs/css/*.scss'],
    bootstrap_4: ['./node_modules/datatables.net-bs4/css/*.css', './node_modules/datatables.net-bs4/css/*.scss'],
    fontAwesome: ['./assets-src/sass/datatables_font_awesome.scss']
};

gulp.task('scripts', function () {
    return gulp.src(scripts, {base: '.'})
        .pipe(concat('datatables.js'))
        .pipe(gulp.dest('./assets-src/compiled/'))
        .pipe(rename({extname: '.min.js'}))
        .pipe(gulp.dest('./src/Resources/public/js/'));
});

gulp.task('scripts-bootstrap-3', function () {
    return gulp.src(scripts_bootstrap_3, {base: '.'})
        .pipe(concat('datatables-bootstrap-3.js'))
        .pipe(gulp.dest('./assets-src/compiled/'))
        .pipe(rename({extname: '.min.js'}))
        .pipe(gulp.dest('./src/Resources/public/js/'));
});

gulp.task('scripts-bootstrap-4', function () {
    return gulp.src(scripts_bootstrap_4, {base: '.'})
        .pipe(concat('datatables-bootstrap-4.js'))
        .pipe(gulp.dest('./assets-src/compiled/'))
        .pipe(rename({extname: '.min.js'}))
        .pipe(gulp.dest('./src/Resources/public/js/'));
});


gulp.task('sass-bootstrap-3', function(done){
    gulp.src(conf.bootstrap_3)
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('datatables-bootstrap-3.css'))
        .pipe(cleanCss())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest('./src/Resources/public/css/'))
        .on('end', done)
});

gulp.task('sass-bootstrap-4', function(done){
    gulp.src(conf.bootstrap_4)
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('datatables-bootstrap-4.css'))
        .pipe(cleanCss())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest('./src/Resources/public/css/'))
        .on('end', done)
});

gulp.task('sass-font-awesome', function(done){
    gulp.src(conf.fontAwesome)
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('datatables-font-awesome.css'))
        .pipe(cleanCss())
        .pipe(rename({extname: '.min.css'}))
        .pipe(gulp.dest('./src/Resources/public/css/'))
        .on('end', done)
});

gulp.task('watch', function(){
    gulp.watch('./assets-src/scripts/*.js', ['scripts', 'scripts-bootstrap-3', 'scripts-bootstrap-4']);
    gulp.watch('./assets-src/scripts/*.scss', ['sass-bootstrap-3','sass-bootstrap-4', 'sass-font-awesome'])
});

gulp.task('default', ['scripts', 'scripts-bootstrap-3', 'scripts-bootstrap-4', 'sass-bootstrap-3', 'sass-bootstrap-4', 'sass-font-awesome']);
