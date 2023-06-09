// variables
const nav_items = document.querySelector( '#nav__items' );
const open_nav_btn = document.querySelector( '#open__nav-btn' );
const close_nav_btn = document.querySelector( '#close__nav-btn' );

// main functions
const open_nav = () => {
  nav_items.style.display = 'flex';
  close_nav_btn.style.display = 'inline-block';
  open_nav_btn.style.display = 'none';
};

const close_nav = () => {
  nav_items.style.display = 'none';
  open_nav_btn.style.display = 'inline-block';
  close_nav_btn.style.display = 'none';
};



//============= SCRIPT FOR NAV SECTION ==============//
open_nav_btn.addEventListener( 'click', open_nav );

close_nav_btn.addEventListener( 'click', close_nav );

if ( window.innerWidth <= 900 ) {
  document.querySelectorAll( '#nav__items li a' ).forEach( nav_item => {
    nav_item.addEventListener( 'click', close_nav );
  } );
}

window.addEventListener( 'scroll', () => { // change the background of the navbar when scrolling.
  document.querySelector( 'nav' ).classList.toggle( "window-scroll", window.scrollY > 0 );
} );

//============= SCRIPT FOR WRAPPER ELEMENT ==============//
const wrapper = document.querySelector( '.wrapper' ); // get the wrapper element.
let pressed = false; // var to check if the element pressed.
let startX = 0; // var to store.
wrapper.addEventListener( 'mousedown', function ( e ) {
  pressed = true; // the element pressed.
  startX = e.clientX; // get the horizontal client coordinate of the mouse pointer.
  this.style.cursor = 'grabbing'; // change the mouse cursor to grabbing (to show the pressed event).
} );
wrapper.addEventListener( 'mouseleave', function ( e ) {
  pressed = false; // the element not pressed (mouse leave it).
} );
wrapper.addEventListener( 'mouseup', function ( e ) {
  pressed = false; // the element not pressed (mouse inside the element but not pressed).
  this.style.cursor = 'grab'; // change the mouse cursor to grab (to show the end of  pressed event).
} );
wrapper.addEventListener( 'mousemove', function ( e ) {
  if ( !pressed ) { // don't do anything in case the element not pressed.
    return;
  }
  this.scrollLeft += startX - e.clientX; // scroll inside the element.
} );

//============= SCRIPT FOR PROGRESS BAR ==============//
const wrapper_prog_bar = document.querySelector( '#wrapper-prog-bar' ); // get the progress bar element.
let wrapper_width = wrapper.scrollWidth; // get the scroll width of wrapper element.
let init_percentage = wrapper.clientWidth / wrapper_width * 100; // calc the percentage of the viewport width.
wrapper_prog_bar.style.width = `${init_percentage}%`; // add width to the prog_bar.
wrapper.addEventListener( 'scroll', function () { // add scroll event to the wrapper element.
  let scroll_percentage = this.scrollLeft / wrapper_width * 100; // calc the percentage of the scroll.
  wrapper_prog_bar.style.width = `${init_percentage + scroll_percentage}%`; // change the prog_bar width.
} );