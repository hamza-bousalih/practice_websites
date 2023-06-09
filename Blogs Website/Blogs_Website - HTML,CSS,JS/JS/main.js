

$( document ).ready( function () {
  $( 'nav .nav__btn' ).click( function () {
    $( this ).toggleClass( 'active' );
    $( 'nav .nav__items' ).toggleClass( 'active' );
  } );


  $( '.dashboard .sidebar__toggle' ).click( function () {
    $( this ).toggleClass( 'active' );
    $( '.dashboard aside' ).toggleClass( 'active' );
  } );
} );