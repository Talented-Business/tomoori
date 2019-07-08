var $ = jQuery;
$(document).ready(function(){
    let rtl = $("body").css("direction")=='rtl';
    $('.home-slider').on('init', function () {
      $('.home-slider>div').css({
        height: 'auto',
        visibility: 'visible'
      });
    });
  	$('.home-slider').slick({
    	nextArrow: '<button type="button" class="slick-next">Next</button>',
    	prevArrow: '<button type="button" class="slick-prev">Previous</button>',
    	autoplay: false,
		  autoplaySpeed: 20000,
		  cssEase: 'linear',
      dots: true,
      rtl: rtl
  	});
  	$('.product-carousel').slick({
    	nextArrow: '',
    	prevArrow: '',
    	autoplay: true,
  		autoplaySpeed: 20000,
  		cssEase: 'linear',
  		slidesToShow: 4,
      dots: false,
      rtl: rtl,
      responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
      }
    }
    ]
  	});
  	$('.product-carousel-sm').slick({
    	nextArrow: '',
    	prevArrow: '',
    	autoplay: true,
  		autoplaySpeed: 20000,
  		cssEase: 'linear',
  		slidesToShow: 6,
      dots: false,
      rtl: rtl,
            responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
      }
    }
    ]
  	});
  	$('.full-carousel-images').slick({
    	nextArrow: '',
    	prevArrow: '',
    	autoplay: true,
  		autoplaySpeed: 20000,
  		cssEase: 'linear',
  		slidesToShow: 4,
      dots: false,
      rtl: rtl,
  	});
});