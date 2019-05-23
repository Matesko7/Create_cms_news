$(document).ready(function(){

  $('.owl-carousel').owlCarousel({

    loop:true,
    margin:60,
    responsiveClass:true,
    dots: true,
    dotsEach: true,
    responsive:{
        0:{
            items:1,
            nav:false,
        },

        600:{
            items:1,
            nav:false,
        },

        1200:{
            items:2,
            nav:false
        }
    }
  })
});
