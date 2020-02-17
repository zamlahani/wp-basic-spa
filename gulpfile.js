// browser-sync watched files
// automatically reloads the page when files changed
var browserSyncWatchFiles = [
    "./assets/css/*.css",
    "./assets/js/*.js",
    "./dists/**/*.php",
    "./libraries/**/*.php",
    "./modules/**/*.php",
    "./partials/**/*.php",
    "./setup/**/*.php",
    "./templates/**/*.php",
]

// browser-sync options
// see: https://www.browsersync.io/docs/options/
var browserSyncOptions = {
    proxy: "http://schoen.local/",
    host: "schoen.local",
    open: "external",
    notify: false,
}

// Defining requirements
var gulp = require("gulp")
var browserSync = require("browser-sync").create()

/* ================= WATCHER ================== */
gulp.task("bs", function() {
    browserSync.init(browserSyncWatchFiles, browserSyncOptions)
})

var sass = require("gulp-sass")
sass.compiler = require("node-sass")
var sourcemaps = require("gulp-sourcemaps")
var rename = require("gulp-rename")

gulp.task("sass", function() {
    return gulp
        .src("./assets/css/style.scss")
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
        .pipe(rename("style.min.css"))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("./assets/css"))
})

gulp.task("watchSass", function() {
    gulp.watch("./assets/css/sass/**/*.scss", gulp.series("sass"))
})

var concat = require("gulp-concat")
var babel = require("gulp-babel")
var babelConfig = {
    presets: ["@babel/env"],
}

gulp.task("bundleJS", function() {
    return gulp
        .src("./assets/js/src/*.js")
        .pipe(concat("theme.js"))
        .pipe(babel(babelConfig))
        .pipe(gulp.dest("./assets/js"))
})

gulp.task("compileSearchJS", function() {
    return gulp
        .src("./assets/js/search-source.js")
        .pipe(babel(babelConfig))
        .pipe(rename("search.js"))
        .pipe(gulp.dest("./assets/js"))
})

gulp.task("watchJS", function() {
    gulp.watch(
        "./assets/js/src/*.js",
        gulp.series("bundleJS", "compileSearchJS")
    )
})

exports.default = gulp.parallel("bs", "watchSass", "watchJS")
