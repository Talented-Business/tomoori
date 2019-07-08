(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		$(document).ready(function() {
			$(document).on('click','.minus',function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();
				return false;
			})
			$(document).on('click','.plus',function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
			$(document).on('change','.woocommerce-cart-form input',function (e) {
				e.preventDefault();
				e.stopPropagation();
				var qty = $(this).val();
				$(this).closest('.col-sm-12').children('a').each(function(){
					if ($(this).attr('data-quantity')) {
						$(this).attr('data-quantity', qty);
					}	
				})
				
			});

			// Remove Item From Cart (mini-cart)
			$( document ).on( 'click', '.cart-trash', function(e) {
				e.preventDefault();
				e.stopPropagation();

        		$(this).addClass('remove-clicked');
		        var cart_item_key = $( this ).attr('data-cart-item-hash');
		        var home_url = $( this ).attr('data-home-url');
		        
		        function delete_item_from_cart() {

		            $.ajax({
		                type: 'POST',
		                url: tom_ajaxurl,
		                data: {
		                    action: 'delete_item_from_cart',
		                    cart_item_key: cart_item_key
		                },
		                success: function(data) {
		                    $(document.body).trigger('wc_fragment_refresh');
		                    $(document.body).trigger( 'update_checkout' );
		                    $('.dynamic-cart-wrap').html(data);
		                    // if ( $('body').hasClass ) {}
		                    // $('.remove-clicked').parent().parent().fadeOut();
		                    // $('.'+data).fadeOut();
		                    // console.log('Cart Updated!');
		                    // console.log(data);
		                }
		            });  

		        }
		        delete_item_from_cart();
		    });
			// Update Cart Item Quantity
		    $( document ).on( 'change', 'article .woocommerce-cart-form .number input', function() {
		    	var is_cart_page = $('body').hasClass('cart');
		        var item_hash = wc_cart_fragments_params['cart_hash_key'];
		        var item_quantity = $( this ).val();
		        var currentVal = parseFloat(item_quantity);
		        var cart_item_key = $( this ).parent().parent().attr('data-cart-item-hash');
		        var home_url = $( this ).parent().parent().attr('data-home-url');
		        function qty_cart() {
		            $.ajax({
		                type: 'POST',
		                url: tom_ajaxurl,
		                data: {
		                    action: 'qty_cart',
		                    cart_item_key: cart_item_key,
		                    is_cart_page: is_cart_page,
		                    quantity: currentVal
		                },
		                success: function(data) {
		                    $(document.body).trigger( 'wc_fragment_refresh' );
							$(document.body).trigger( 'update_checkout' );
		                    if ($('body').hasClass('cart')||true) {
								$("[name='update_cart']").trigger("click"); 
		                    	$('.cart-collaterals .cart-items').hide(500);
		                    	$('.cart-collaterals .cart-total').hide(500);
		                    	setTimeout(function(){
			                    	$('.cart-collaterals .cart-items').toggle(500);
									$('.cart-collaterals .cart-total').toggle(500);
								}, 1000);

								setTimeout(function(){
		                    		$('.cart-collaterals').html(data);
								}, 500);
		                    }
		                    console.log('Cart Updated!');
		                    console.log('qty_cart');
		                }
		            });
		        }
		        qty_cart();
		    });
		    // Update Cart Totals
		    $( document ).on( 'change', '.dynamic-cart-wrap .number input', function() {
		    	var is_cart_page = $('body').hasClass('cart');
		        var item_hash = wc_cart_fragments_params['cart_hash_key'];
		        var item_quantity = $( this ).val();
		        var currentVal = parseFloat(item_quantity);
		        var cart_item_key = $( this ).parent().parent().attr('data-cart-item-hash');
		        var home_url = $( this ).parent().parent().attr('data-home-url');
		        function update_total() {

		            $.ajax({
		                type: 'POST',
		                url: tom_ajaxurl,
		                data: {
		                    action: 'update_total',
		                    cart_item_key: cart_item_key,
		                    is_cart_page: is_cart_page,
		                    quantity: currentVal
		                },
		                success: function(data) {
		                    $(document.body).trigger( 'wc_fragment_refresh' );
		                    $(document.body).trigger( 'update_checkout' );
		                    if ($('body').hasClass('cart')) {
								//$("[name='update_cart']").trigger("click"); 
		                    	$('.cart-collaterals .cart-items').hide(500);
		                    	$('.cart-collaterals .cart-total').hide(500);
		                    	setTimeout(function(){
			                    	$('.cart-collaterals .cart-items').toggle(500);
			                    	$('.cart-collaterals .cart-total').toggle(500);
								}, 1000);

		                    }
							//setTimeout(function(){
								$('.dynamic-cart-wrap .bottom-section .col-lg-8').html(data);
								// $('.checkout.wizard .dynamic-cart-wrap .bottom-section').html(data);
							//}, 500);
						console.log('Cart Updated!');
		                    console.log('update_total');
		                }
		            });
		        }
		        update_total();
		    });


		    /*$(".home .add_to_cart_button").on('click', function(e){
		    	// function update_header_cart(){
		    	$(this).css('color', 'gray')
		    	setTimeout(function(){
			    	$.ajax({
			    		type: 'POST',
			    		url: tom_ajaxurl,
			    		data:{
			    			action: 'update_header_cart'
			    		},
			    		success: function(data){
			    			$(document.body).trigger('wc_fragment_refresh');
			    			$('.dynamic-cart-wrap').html(data)
			    			console.log(data)
			    		}
			    	})
		    	}, 500);
		    })*/

		    $(".page-id-5 .add_to_cart_button").on('click', function(e){
		    	// function update_header_cart(){
		    	$(this).css('color', 'gray')
		    	setTimeout(function(){
			    	$.ajax({
			    		type: 'POST',
			    		url: tom_ajaxurl,
			    		data:{
			    			action: 'update_header_cart'
			    		},
			    		success: function(data){
			    			$(document.body).trigger('wc_fragment_refresh');
			    			$('.dynamic-cart-wrap').html(data)
			    			console.log(data)
			    		}
			    	})
		    	}, 500);
		    })

		    $(".single-product .ajax_add_to_cart").on('click', function(e){
		    	// function update_header_cart(){
		    	$(this).css('color', 'gray')
		    	setTimeout(function(){
			    	$.ajax({
			    		type: 'POST',
			    		url: tom_ajaxurl,
			    		data:{
			    			action: 'update_header_cart'
			    		},
			    		success: function(data){
			    			$(document.body).trigger('wc_fragment_refresh');
			    			$('.dynamic-cart-wrap').html(data)
			    			console.log(data)
			    		}
			    	})
		    	}, 500);
		    })
			$('.dropdown.woocommerce-ordering	span.filter').on('click',function(){
				$('.sidebar').fadeToggle('slow');
			})
		});
		function bindNavbar() {
			if ($(window).width() > 768) {
			  	$('.top-left-menu-wrap .dropdown').on('mouseover', function(){
					$(this).addClass("show");  
					$('.dropdown-toggle', this).next('.dropdown-menu').addClass('show');
					let width = $('.dropdown-toggle', this).next('.dropdown-menu').css('width');
					let width1=$(this).css('width');
					width = parseInt(width)-parseInt(width1);
					if($('body').hasClass('rtl'))width=0;
					$('.dropdown-toggle', this).next('.dropdown-menu').css('transform','translate3d(-'+width+'px, -1px, 0px)')
			  	}).on('mouseout', function(){
					$(this).removeClass("show");
					$('.dropdown-toggle', this).next('.dropdown-menu').removeClass('show');
			  	});
			   
			  	$('.dropdown-toggle').click(function() {
					if ($(this).next('.dropdown-menu').is(':visible')) {
				  		window.location = $(this).attr('href');
					}
			  	});
			}
			else {
			  	$('.top-left-menu-wrap .dropdown').off('mouseover').off('mouseout');
			}
		}	
		bindNavbar();	
		function footerFixed(){
			let first_height=document.body.offsetHeight;
			if(document.body.offsetHeight<window.innerHeight){
				if($("main section article").length==1){
					let height = jQuery("main section article").height();
					$("main section article").css('min-height',(window.innerHeight-first_height+height)+'px');
					let second_height = document.body.offsetHeight;
					let different = window.innerHeight-second_height;
					console.log(different);
					$("main section article").css('min-height',(window.innerHeight-first_height+height+different)+'px');
				}
			}else{
				if($("main section article").length==1){
					$("main section article").css('min-height','315px');
				}
			}	
		}
		footerFixed();
	});
	function close_search_form() {
		var form = document.getElementById("header-search");
		let is_mobile = $("#mobile-menu-header").css("display")!="none";
		if(is_mobile){
			document.querySelector("header.header").style.display = "none";
		}
		form.classList.remove("header-search-open");
		form.removeEventListener("keydown", search_form_keydown, !1);
	}
	function search_form_keydown(event) {
		document.getElementById("header-search-input").classList.remove("header-search-error");
		if("Escape" === event.key) {
			document.removeEventListener("keydown", arguments.callee);
			close_search_form();
		}
	}
	function open_search_form() {
		let header_search = document.getElementById("header-search");
		let header_search_input = document.getElementById("header-search-input");
		let is_mobile = $("#mobile-menu-header").css("display")!="none";
		if(is_mobile){
			document.querySelector("header.header").style.display = "block";
		}
		header_search_input.value = "",
		header_search_input.classList.remove("header-search-error"),
		header_search.classList.add("header-search-open"),
		document.getElementById("header-search-input").focus(),
		header_search.addEventListener("keydown", search_form_keydown, !1)
	}
	function search_products(event) {
		var header_search_input = document.getElementById("header-search-input");
		if(header_search_input.value)return;
		event.preventDefault();
		header_search_input.focus();
		header_search_input.classList.add("header-search-error");
	}
	document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("header-search") && (document.getElementById("header-search-button").addEventListener("click", open_search_form),
		document.getElementById("mobile-search-button").addEventListener("click", open_search_form),
		document.getElementById("header-search-close").addEventListener("click", close_search_form),
		document.getElementById("header-search").addEventListener("submit", search_products))
	})	
})(jQuery, this);