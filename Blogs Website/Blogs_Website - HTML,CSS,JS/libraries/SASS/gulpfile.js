const { src, dest, watch, series } = require( 'gulp' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );
// const purgecss = require( 'gulp-purgecss' );

function buildStyles () {
  return src( '../../SASS/main/**/*.scss' )
    .pipe( sass() )
    // .pipe( purgecss( { content: ['*.html'] } ) )
    .pipe( dest( '../../CSS' ) );
}

function watchTask () {
  watch( ['../../SASS/**/*.scss', '*.html'], buildStyles );
}

exports.default = series( buildStyles, watchTask );