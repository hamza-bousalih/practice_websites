const { src, dest, watch, series } = require( 'gulp' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );

function buildStyles () {
  return src( 'css/sass/**/*.scss' )
    .pipe( sass() )
    .pipe( dest( 'css' ) );
}

function watchTask () {
  watch( ['css/sass/**/*.scss'], buildStyles );
}

exports.default = series( buildStyles, watchTask );