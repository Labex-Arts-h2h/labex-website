var gulp = require('gulp');
// Requires the gulp-sass plugin
var sass = require('gulp-sass');
var minifyHTML = require('gulp-minify-html');
var htmlclean = require('gulp-htmlclean');
var imagemin = require('gulp-imagemin');
var critical = require('critical').stream;

var browserSync = require('browser-sync');
var del = require('del');

// SASS TASK
gulp.task('sass', function(){
  return gulp.src('squelettes-dev/./**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('squelettes-dev/.'))
    .pipe(browserSync.reload({
      stream: true
    }))
});

// MINIFY HTML TASK
gulp.task('minify-html', function() {
  var opts = {
      empty: true,        // KEEP empty attributes
      cdata: true,        // KEEP CDATA from scripts
      comments: true,     // KEEP comments
      ssi: true,          // KEEP Server Side Includes
      conditionals: true, // KEEP conditional internet explorer comments
      spare: true,        // KEEP redundant attributes
      quotes: true,       // KEEP arbitrary quotes
      loose: true         // KEEP one whitespace
  };
  return gulp.src('squelettes-dev/**/*.html')
    .pipe(minifyHTML(opts))
    .pipe(gulp.dest('squelettes-dist/'));
});

// HTML CLEAN TASK
gulp.task('html-clean', function() {
  return gulp.src('squelettes-dev/**/*.html')
    .pipe(htmlclean())
    .pipe(gulp.dest('squelettes-dist/'));
});

// IMAGE OPTIM
gulp.task('imagemin', function() {
    return gulp.src(['squelettes-dev/img/*/**','squelettes-dev/img/**'])
    .pipe(imagemin({ progressive: true }))
    .pipe(gulp.dest('squelettes-dist/img/.'));
});


// browserSync
gulp.task('browserSync', function() {
  browserSync.init({
      proxy: "http://labex:8888/"
  });
});

gulp.task('watch', ['browserSync', 'sass'], function (){
	gulp.watch('squelettes-dev/*.scss', ['sass']); 
});



gulp.task('minify-html', function() {
  var opts = {
    conditionals: false,
    spare:false
  };
  return gulp.src('squelettes-dev/**/*.html')
    .pipe(minifyHTML(opts))
    .pipe(gulp.dest('squelettes-dist/'));
});

gulp.task('html-clean', function() {
  return gulp.src('squelettes-dev/**/*.html')
    .pipe(htmlclean())
    .pipe(gulp.dest('squelettes-dist/'));
});


// Generate & Inline Critical-path CSS
gulp.task('critical', function () {
    return gulp.src('squelettes-dist/contenu/*.html')
        .pipe(critical({base: 'squelettes-dist/contenu', inline: true, css: ['squelettes-dist/habillage.css','squelettes-dist/spip_style.css']}))
        .pipe(gulp.dest('squelettes-dist/contenu'));
});


// COPY LIB
gulp.task('libs-copy', function() {
  gulp.src(['squelettes-dev/libs/**/*']).pipe(gulp.dest('squelettes-dist/libs'));
});

// COPY HTML
gulp.task('html-copy', function() {
  gulp.src(['squelettes-dev/**/*.html']).pipe(gulp.dest('squelettes-dist/'));
});

// COPY PHP
gulp.task('php-copy', function() {
  gulp.src(['squelettes-dev/**/*.php']).pipe(gulp.dest('squelettes-dist/'));
});

gulp.task('build', ['clean', 'imagemin', 'sass', 'html-clean','php-copy','libs-copy']);
gulp.task('build-safe', ['clean', 'imagemin', 'sass', 'html-copy','php-copy','libs-copy']);



gulp.task('clean', function() {
  del('squelettes-dist/*/*/**');
});

/// MOVE
// var filesToMove = [
//         './_locales/**/*.*',
//         './icons/**/*.*',
//         './src/page_action/**/*.*',
//         './manifest.json'
//     ];

// gulp.task('move',['clean'], function(){
//   // the base option sets the relative root for the set of files,
//   // preserving the folder structure
//   gulp.src(filesToMove, { base: './' })
//   .pipe(gulp.dest('dist'));
// });



