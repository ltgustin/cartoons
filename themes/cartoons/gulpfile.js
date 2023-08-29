const { src, dest, watch, series, parallel } = require('gulp');

const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const cssnano = require('cssnano');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

const onError = function (err) {
    notify.onError({
        title:    "Gulp",
        subtitle: "Failure!",
        message:  "Error: <%= error.message %>",
        sound:    "Beep"
    })(err);
    this.emit('end');
};

// File paths
const files = { 
    cssPath: './assets/scss/**/*.*ss',
    jsHeaderPath: './assets/js/modules/*.js',
    jsPath: './assets/js/partials/*.js',
    adminJsPath: './assets/js/admin/*.js'
}

// normal css
function css() {
    return src('./assets/scss/style.scss')
        .pipe(plumber({errorHandler: onError}))
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(),cssnano()], {syntax:require('postcss-scss')}))
        .pipe(sourcemaps.write())
        .pipe(dest('./dist/css'))
        .pipe(notify('SCSS! (っ◕‿◕)っ'));
}

// admin css
function cssAdmin() {
    return src('./assets/scss/admin-styles.scss')
        .pipe(plumber({errorHandler: onError}))
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(),cssnano()], {syntax:require('postcss-scss')}))
        .pipe(sourcemaps.write())
        .pipe(dest('./dist/css'))
        .pipe(notify('Admin SCSS! ᕦ(ˇò_ó)ᕤ'));
}

// editor css
function cssEditor() {
    return src('./assets/scss/style-editor.scss')
        .pipe(plumber({errorHandler: onError}))
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(),cssnano()], {syntax:require('postcss-scss')}))
        .pipe(sourcemaps.write())
        .pipe(dest('./'))
        .pipe(notify('Editor SCSS! ᕦ(ˇò_ó)ᕤ'));
}

// js
function js() {
    return src(files.jsPath, { sourcemaps: true })
        .pipe(plumber({errorHandler: onError}))
        .pipe(babel({
            presets: ['@babel/preset-env']
        }))
        .pipe(concat('scripts.min.js'))
        .pipe(uglify())
        .pipe(dest('./dist/js'), { sourcemaps: true })
        .pipe(notify('JavaScript Footer! (⌐■_■)'));
}

// js header
function jsHeader() {
    return src(files.jsHeaderPath, { sourcemaps: true })
        .pipe(plumber({errorHandler: onError}))
        .pipe(concat('header-scripts.min.js'))
        .pipe(uglify())
        .pipe(dest('./dist/js'), { sourcemaps: true })
        .pipe(notify('JavaScript Header! (⌐□_□)'));
}

// js admin
function jsAdmin() {
    return src(files.adminJsPath, { sourcemaps: true })
        .pipe(plumber({errorHandler: onError}))
        .pipe(concat('admin-scripts.min.js'))
        .pipe(uglify())
        .pipe(dest('./dist/js'), { sourcemaps: true })
        .pipe(notify('Admin JavaScript! (づ￣ ³￣)づ'));
}

function watchTask(){
    watch(files.cssPath,series(css));
    watch(files.cssPath,series(cssAdmin));
    watch(files.cssPath,series(cssEditor));
    watch(files.jsHeaderPath,series(jsHeader));
    watch(files.jsPath,series(js));
    watch(files.adminJsPath,series(jsAdmin)); 
}

exports.default = watchTask;