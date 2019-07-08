var $ = jQuery;
$(document).ready(function(){
  /*let rtl = $("body").css("direction")=='rtl';
  $('.single-product-carousel').slick({
    	nextArrow: '<i class="fas fa-angle-right"></i>',
			prevArrow: '<i class="fas fa-angle-left"></i>',
			arrows:true,
    	autoplay: true,
  		autoplaySpeed: 3000,
  		cssEase: 'linear',
  		slidesToShow: 1,
      dots: false,
      rtl: rtl
  });
  $('.option-wrap a').first().click()
  $('.option-wrap a').on('click', function(e){
    var product_id = $(this).attr('data-product_id')
    var variation_id = $(this).attr('data-variation_id')
    // $('.woocommerce-Price-amount').text($(this).attr('data-variation_price') + $('.woocommerce-Price-currencySymbol').html())
    $.ajax({
        type: 'POST',
        url: tom_ajaxurl,
        data: {
            action: 'get_variation_price',
            product_id: product_id,
            variation_id: variation_id
        },
        success: function(data) {
          console.log(data);
          $('.woocommerce-Price-amount').html(data)
        }
    }); 
  })*/
});

