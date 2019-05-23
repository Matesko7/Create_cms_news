$(document).ready(function(){

  // Scroll down button
  $('.arrow-down').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('#about-us').offset().top + 5}, 1200);
  });

// Scroll up button
  $('.arrow-top').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('header').offset().top + 0}, 1200);
  });
  
// Nav buttons
  $('#uvod').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('#about-us').offset().top + 5}, 1200);
  });
  
  $('#Kontakt').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('#benefits').offset().top + 5}, 1200);
  });
  
  $('#galeria').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('#gallery').offset().top + 5}, 1200);
  });
  
  $('#novinky').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('#subscribe').offset().top + 20}, 1200);
  });
  
  $('#kontakt').click(function(event){
    event.preventDefault();
    $('html, body').animate(
      {scrollTop: $('#more-info').offset().top + 5}, 1200);
  });
  
});
