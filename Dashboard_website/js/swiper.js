const swiperEl = document.querySelector( '.swiper .swiper-container' );
const swiperDotes = document.querySelector( '.swiper .swiper-dotes' );

const dotes_arr = [];
let active_dote;
let clicking_a_dote = false;

for ( let i = 0; i < swiperEl.children.length; i++ ) {
  let span = document.createElement( 'span' );
  if ( i == 0 ) { span.className = 'active'; active_dote = span; }
  let dote = {
    el: span,
    index: i,
    slide_info: {
      prevSlide: swiperEl.children[i - 1],
      slide: swiperEl.children[i],
      nextSlide: swiperEl.children[i + 1],
    }
  };
  swiperDotes.appendChild( span );
  dotes_arr.push( dote );
}

dotes_arr.forEach( dote => {
  dote.el.addEventListener( 'click', function () {
    clicking_a_dote = true;
    active_dote.classList.remove( 'active' );
    swiperEl.scrollLeft = ( swiperEl.clientWidth + parseInt( getComputedStyle( swiperEl ).gap ) ) * dote.index;
    // console.log( ( swiperEl.clientWidth + getComputedStyle( swiperEl ).gap ) * dote.index );
    this.classList.add( 'active' );
    active_dote = this;
  } );
} );

window.addEventListener( 'resize', _ => active_dote.click() );