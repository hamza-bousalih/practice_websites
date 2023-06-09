//================== VARIABLES ==================//
const header = document.querySelector( '.header' );
const navbar = document.querySelector( '.header .navbar' );
const open_nav_el = document.querySelector( '#menu-btn' );
const close_nav_el = document.querySelector( '#nav-close' );

const search_from = document.querySelector( '.search-form' );
const open_search = document.querySelector( '#search-btn' );
const close_search = document.querySelector( '#close-search' );

const home_wrapper = document.querySelector( '.home .wrapper' );
const home_slider = document.querySelector( '.home .wrapper .slide' );
const home_prev_btn = document.querySelector( '.home .wrapper .home_prev' );
const home_next_btn = document.querySelector( '.home .wrapper .home_next' );

const shop_wrapper = document.querySelector( '.shop .wrapper' );
const shop_slider = document.querySelector( '.shop .wrapper .slide' );
const shop_prev_btn = document.querySelector( '.shop .shop_prev' );
const shop_next_btn = document.querySelector( '.shop .shop_next' );

const reviews_wrapper = document.querySelector( '.reviews .wrapper' );
const reviews_slider = document.querySelector( '.reviews .wrapper .slide' );

const blogs_wrapper = document.querySelector( '.blogs .wrapper' );
const blogs_slider = document.querySelector( '.blogs .wrapper .slide' );

//================== FUNCTIONS ==================//
const show_hide = ( el, open_btn, close_btn ) => {
  open_btn.addEventListener( 'click', () => {
    el.classList.add( 'active' );
  } );
  close_btn.addEventListener( 'click', () => {
    el.classList.remove( 'active' );
  } );

};

const wrapper_function = ( wrapper, slide, prev_btn = '', next_btn = '', gap = 0, touch = true ) => {
  let pressed = false;
  let startX = 0;

  touch && wrapper.addEventListener( 'mousedown', function ( e ) {
    pressed = true;
    startX = e.clientX;
  } );
  touch && wrapper.addEventListener( 'mouseleave', function ( e ) {
    pressed = false;
  } );
  touch && wrapper.addEventListener( 'mouseup', function ( e ) {
    pressed = false;
  } );
  touch && wrapper.addEventListener( 'mousemove', function ( e ) {
    if ( !pressed ) {
      return;
    }

    if ( startX - e.clientX < 0 ) {
      this.scrollLeft -= slide.clientWidth;
    }
    else if ( startX - e.clientX > 0 ) {
      this.scrollLeft += slide.clientWidth;
    }
  } );

  prev_btn !== '' && prev_btn.addEventListener( 'click', () => {
    wrapper.scrollLeft -= slide.clientWidth + gap;
  } );
  next_btn !== '' && next_btn.addEventListener( 'click', () => {
    wrapper.scrollLeft += slide.clientWidth + gap;
  } );

};



//=================== SCRIPT: hide or show element ====================//
show_hide( navbar, open_nav_el, close_nav_el );
window.addEventListener( 'resize', () => {
  navbar.classList.remove( 'active' );
} );
show_hide( search_from, open_search, close_search );

window.addEventListener( 'scroll', () => {
  navbar.classList.remove( 'active' );
  if ( window.scrollY > 0 ) {
    header.classList.add( 'active' );
  } else {
    header.classList.remove( 'active' );
  }
} );

window.addEventListener( 'load', () => {
  if ( window.scrollY > 0 ) {
    header.classList.add( 'active' );
  } else {
    header.classList.remove( 'active' );
  }
} );

//======================= SCRIPT: slide effect =======================//
wrapper_function( home_wrapper, home_slider, home_prev_btn, home_next_btn );

let shop_gap = parseInt( getComputedStyle( shop_wrapper ).gap );
wrapper_function( shop_wrapper, shop_slider, shop_prev_btn, shop_next_btn, shop_gap, false );

let reviews_gap = parseInt( getComputedStyle( reviews_wrapper ).gap );
wrapper_function( reviews_wrapper, reviews_slider, '', '', reviews_gap );

let blogs_gap = parseInt( getComputedStyle( blogs_wrapper ).gap );
wrapper_function( blogs_wrapper, blogs_slider, '', '', blogs_gap );
