<?php
/* Api for mobile and getting data based on requirements. 
	Developer : Nitin Farwaha
*/

/* Including Wordpress loader*/
require_once("./wp-load.php");

require_once("./wp-blog-header.php");
//glonal $sitepress;

	//header_remove();
	$httpStatus = 200;
    header("Content-Type: application/json");
	//header("Access-Control-Allow-Origin: *");
    header('Status: ' . $httpStatus);

    http_response_code($httpStatus);

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol( $currency_symbol) {
     switch( $_REQUEST['lang'] ) {
          case 'en': $currency_symbol = 'USD'; break;
          case 'ar': $currency_symbol = 'SAR'; break;
     }

     return $currency_symbol;
}
// function wcml_custom_currency(){
//     if($_REQUEST['lang'] == 'en')
// 	{
// 		echo "i am here";
// 		exit;
// 		return 'USD';
// 	}
// 	else
// 	{
// 		return 'SAR';	
// 	}
// }

// add_filter('wcml_client_currency', 'wcml_custom_currency');


SWITCH ($_REQUEST['route']) 
{
	case "getShipingTotal":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
		/*getting Shipping Total here from Woocommerce*/
			$shipping_total = WC()->cart->get_cart_shipping_total();
				if($shipping_total == '')
				{
					$status = 'invalid';
				}
				else
				{
					$status = 'valid';
				}
		/* Generating Results here for Mobile API*/	
			$result = array('shippingTotal'=>$shipping_total,'status'=>$status);
				echo json_encode($result);
			exit;
	break;
	case "getProducts":
			/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				

		/* Getting best Sellers products from the shop*/
		
			$query = new WP_Query( array(
			        'posts_per_page' => 5,
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'meta_key' => 'total_sales',
			        'orderby' => 'meta_value_num',
			        'order' => 'DESC',
			    ) );

					$i = 0;
						$bestSellerProductList = array();
					
			while ( $query->have_posts() ) : $query->the_post(); global $product; 

				//Getting Product Image through products ID
					
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
					$product_added_date = date('m/d/Y',strtotime($product->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
					$bestSellerProductList[] = array('id' => $product->id,
						'enteredDate'=>$product_added_date,
						'imageUrl' => $featured_image[0],
						'name' => $product->name,
						'price' => $product->regular_price,
						'discountedPrice' => $discounted_price,
						'currency'=>get_woocommerce_currency());

				$i++;
			endwhile;
			//Returning results


		/* Getting Popular products from the shop*/
		
			$query = new WP_Query( array(
			        'posts_per_page' => 30,
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'meta_key' => 'total_sales',
			        'orderby' => 'rand',
			        //'order' => 'RAND',
			    ) );

					$i = 0;
						$popularProductList = array();
					
			while ( $query->have_posts() ) : $query->the_post(); global $product; 

				//Getting Product Image through products ID
					
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
					$product_added_date = date('m/d/Y',strtotime($product->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
					$popularProductList[] = array('id' => $product->id,
						'enteredDate'=>$product_added_date,
						'imageUrl' => $featured_image[0],
						'name' => $product->name,
						'price' => $product->regular_price,
						'discountedPrice' => $discounted_price,
						'currency'=>get_woocommerce_currency());

				$i++;
			endwhile;
			//Returning results

			/* Getting Latest products from the shop*/
		
			 $args = array( 'post_type' => 'product',
			  				'stock' => 1, 
			  				'posts_per_page' => 30, 
			  				'orderby' =>'date',
			  				'order' => 'DESC' );
						$latestProductList = array();
			$loop = new WP_Query( $args );
			
			while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
				//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$latestProductList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());
			endwhile;
			#get Featured Products
			$args = array(
	        'post_type'   => 'product',
	        'stock'       => 1,
	        'posts_per_page'   => 20,
	        'orderby'     => 'date',
	        'order'       => 'DESC' ,
	        'post__in'    => wc_get_featured_product_ids()
	        
	    );

    	$loop = new WP_Query( $args );
    		$featuredProductList = array();
    	while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$featuredProductList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());	
    	endwhile;

    	#get Discounted Products List

    	$query_args = array(
			    'posts_per_page'    => 30,
			    'no_found_rows'     => 1,
			    'post_status'       => 'publish',
			    'post_type'         => 'product',
			    'meta_query'        => WC()->query->get_meta_query(),
			    'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
			);
			$loop = new WP_Query( $query_args );
				$discountedProductList = array();
			while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$discountedProductList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());	
    		endwhile;
    		if(count($bestSellerProductList) == 0)
    		{
    			$bestSellerProductList = array('bestSellers'=>'1','status'=>'failed'); 
    		}
    		elseif(count($popularProductList) == 0)
    		{
    			$popularProductList = array('popularProductList'=>'1','status'=>'failed'); 
    		}
    		elseif(count($latestProductList) == 0)
    		{
    			$latestProductList = array('latestProductList'=>'1','status'=>'failed'); 
    		}
    		elseif(count($featuredProductList) == 0)
    		{
    			$featuredProductList = array('featuredProductList'=>'1','status'=>'failed'); 	
    		}
    		elseif(count($discountedProductList) == 0)
    		{
    			$discountedProductList = array('discountedProductList'=>'1','status'=>'failed'); 		
    		}
    		else
    		{
	    		$productList = array('bestsellers'=>$bestSellerProductList,
	    							'popularProducts'=>$popularProductList,
	    							'newProducts'=>$latestProductList,
	    							'featuredProducts'=>$featuredProductList,
	    							'discountedProducts'=>$discountedProductList,
	    							'status'=>'success');
    		}
    		echo json_encode($productList);
    		exit;

	break;
	case "getBestsellers":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				

		/* Getting best Sellers products from the shop*/
		
			$query = new WP_Query( array(
			        'posts_per_page' => 5,
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'meta_key' => 'total_sales',
			        'orderby' => 'meta_value_num',
			        'order' => 'DESC',
			    ) );

					$i = 0;
						$productList = array();
			if ( $query-> have_posts() ) :		
			while ( $query->have_posts() ) : $query->the_post(); global $product; 

				//Getting Product Image through products ID
					
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
					$product_added_date = date('m/d/Y',strtotime($product->date_created));

					$productList[] = array('productId' => $product->id,
						'enteredDate'=>$product_added_date,
						'imageUrl' => $featured_image[0],
						'name' => $product->name,
						'price' => $product->price,
						'currency'=>get_woocommerce_currency(),
						'status'=>'success');

				$i++;
			endwhile;
		else:
			$productList = array('status'=>'failed');
		endif;
			//Returning results

			echo json_encode($productList);
			exit;
	break;
	
	case "getPopularProducts":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				

		/* Getting best Sellers products from the shop*/
		
			$query = new WP_Query( array(
			        'posts_per_page' => 30,
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'meta_key' => 'total_sales',
			        'orderby' => 'rand',
			        //'order' => 'RAND',
			    ) );

					$i = 0;
						$productList = array();
			if ( $query-> have_posts() ) :							
			while ( $query->have_posts() ) : $query->the_post(); global $product; 

				//Getting Product Image through products ID
					
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
					$product_added_date = date('m/d/Y',strtotime($product->date_created));

					$productList[] = array('productId' => $product->id,
						'enteredDate'=>$product_added_date,
						'productImageUrl' => $featured_image[0],
						'productName' => $product->name,
						'productPrice' => $product->price,
						'currency'=>get_woocommerce_currency(),
						'status'=>'success');

				$i++;
			endwhile;
			else:
			$productList = array('status'=>'failed');
		endif;
			//Returning results

			echo json_encode($productList);
			exit;
	break;
	case "getNewProducts":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				

		/* Getting Latest products from the shop*/
		
			 $args = array( 'post_type' => 'product',
			  				'stock' => 1, 
			  				'posts_per_page' => 30, 
			  				'orderby' =>'date',
			  				'order' => 'DESC' );
						$productList = array();
			$loop = new WP_Query( $args );
			if ( $loop-> have_posts() ) :	
			while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
				//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							$productList[] = array('productId' => $product->id,
								'enteredDate'=>$product_added_date,
								'productImageUrl' => $featured_image[0],
								'productName' => $product->name,
								'productPrice' => $product->price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success');
			endwhile;
            else:
			$productList = array('status'=>'failed');
		endif;
			//Returning results
			echo json_encode($productList);
			exit;
	break;
	case "getFeaturedProducts":
			global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				
			$args = array(
	        'post_type'   => 'product',
	        'stock'       => 1,
	        'posts_per_page'   => 20,
	        'orderby'     => 'date',
	        'order'       => 'DESC' ,
	        'post__in'    => wc_get_featured_product_ids()
	        
	    );

    	$loop = new WP_Query( $args );
    	if ( $loop-> have_posts() ) :
    	while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							$productList[] = array('productId' => $product->id,
								'enteredDate'=>$product_added_date,
								'productImageUrl' => $featured_image[0],
								'productName' => $product->name,
								'productPrice' => $product->price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success');	
    	endwhile;
		else:
			$productList = array('status'=>'failed');
		endif;
    		//Returning results
			echo json_encode($productList);
			exit;
	case "getDiscountedProducts":
		global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				
			$query_args = array(
			    'posts_per_page'    => 30,
			    'no_found_rows'     => 1,
			    'post_status'       => 'publish',
			    'post_type'         => 'product',
			    'meta_query'        => WC()->query->get_meta_query(),
			    'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
			);
			$loop = new WP_Query( $query_args );
            if ( $loop-> have_posts() ) :
			while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							$productList[] = array('productId' => $product->id,
								'enteredDate'=>$product_added_date,
								'productImageUrl' => $featured_image[0],
								'productName' => $product->name,
								'oldPrice' => $product->regular_price,
								'discountedPrice' => $product->sale_price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success');	
    		endwhile;
			else:
			$productList = array('status'=>'failed');
		endif;
    		//Returning results
			echo json_encode($productList);
			exit;

	break;
	case "searchProducts":
	global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);

				
			$searchWord = $_REQUEST['searchText'];
			//Making search Query for products.
			$products = get_posts(array(
			        'fields' => 'id',
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'posts_per_page' => 30,
			        's' =>  $searchWord

			));
			//Loop to get products and put them into Array
			if(count($products)>0):
			foreach($products as $product_data)
			{
				$wooproduct = wc_get_product( $product_data->ID );
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($wooproduct->id));
						$product_added_date = date('m/d/Y',strtotime($wooproduct->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$productList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success');
			}
			else:
			$productList = array('status'=>'failed');
		endif;
			//Generating and returning results.
			echo json_encode($productList);
			exit;
	
	break;
	case "getProductDetails":
	global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
		//GEtting product info to a variable.
		$product = wc_get_product( $_REQUEST['productId'] );
			//Getting Product Image
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
				//Fetching Product Date Format
				$product_added_date = date('m/d/Y',strtotime($product->date_created));
					//Fetch Related Products
					$related_products = wc_get_related_products($product->id);
						$related_product_info = array();
						foreach($related_products as $related_product)
						{
							$rel_product = wc_get_product($related_product);
								$rel_product_image = wp_get_attachment_image_src( get_post_thumbnail_id($rel_product->id));
								$related_product_info[] = array('id'=>$rel_product->id,
									'name'=>$rel_product->name,
									'image'=>$rel_product_image[0]);
						}

						//Fetch Product Categories
							$products_categories = get_the_terms ( $product->id, 'product_cat' );
								$categories = array();
								foreach ( $products_categories as $product_cat ) {
								     $categories[] = $product_cat->name;
								}
								
								$cats = implode("','",$categories);
							//Fetching Group Products
							$group_products = $product->get_children();
							if(count($group_products) > 0)
							{
								$g_product_info = array();
								foreach($group_products as $group_product)
								{
									$g_product = wc_get_product($group_product);
										$g_product_image = wp_get_attachment_image_src( get_post_thumbnail_id($rel_product->id));
										$g_product_info[] = array('id'=>$g_product->id,
											'name'=>$g_product->name,
											'image'=>$g_product_image[0]);
								}
							}
								//Fetching Rating of Product
									$average = $product->get_average_rating();
    									$review_count = $product->get_review_count();
    									if($product->sale_price == '')
										{
											$discounted_price = 'null';
										}
										else
										{
											$discounted_price = $product->sale_price;
										}
							if(is_array($product->gallery_image_ids))
							{
								$gallery_urls = array();
								foreach($product->gallery_image_ids as $image_ids)
								{
									$images_urls = wp_get_attachment_image_src($image_ids);
										$gallery_urls[] = $images_urls[0];
								}
							}
							else
							{
								$gallery_urls[] = 'null';
							}
							
							if($product->description != '')		
							{
								$desc_product = $product->description;
							}
							else
							{
								$desc_product = 'null';
							}
				//Making Array of Product Details for App
			$productData = array('id'=>$product->id,
								'enteredDate'=>$product_added_date,
								'images' => $gallery_urls,
								'imageUrl'=>$featured_image[0],
								'name'=>$product->name,
								'categories'=>"'".$cats."'",
								'description'=>$desc_product,
								'price'=>$product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency(),
								'totalSales'=>$product->total_sales,
								'weight'=>$product->weight,
								'dimensions'=>array('height'=>$product->get_height().''.get_option( 'woocommerce_dimension_unit' ),
													'width'=>$product->get_width().''.get_option( 'woocommerce_dimension_unit' ),
													'length'=>$product->get_length().''.get_option( 'woocommerce_dimension_unit' )
													),
								'relatedProducts'=>$related_product_info,
								'rating'	=> array('average'=>$average,'reviewCount'=>$review_count),
								);
			
				if(count($g_product_info) > 0)
				{
					$productData['grouped_products'] = $g_product_info;
				}

				echo json_encode($productData);
				exit;
	break;
	case "addToCart":
		global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
			//check if product already in cart

				// if no products in cart, add it
				
				 WC()->cart->add_to_cart( $_REQUEST['productId'],$_REQUEST['quantity']);
			 
			 $productList = array();
			 $items = WC()->cart->get_cart();
			    if(count($items)>0):
			 	foreach($items as $item)
			 	{
			 		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($item['data']->id));
						//$product_added_date = date('m/d/Y',strtotime($wooproduct->date_created));
					
								$productList[] = array('products'=>array('id' => $item['data']->id,
								'qty'=>$item['quantity'],
								'imageUrl' => $featured_image[0],
								'name' => $item['data']->name,
								'price' => $item['data']->regular_price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success')
							);
			 	}
				else:
		            $productList = array('status'=>'failed');
			    endif;
					$productList['cartCurrency'] = get_woocommerce_currency_symbol();
								$productList['subTotal'] = WC()->cart->get_subtotal();
							if (!empty(WC()->cart->get_applied_coupons())) 
							{	
								foreach ( WC()->cart->get_applied_coupons() as $code ) {
										$couponCode = new WC_Coupon( $code );
									}
								$productList['discountCouponCode'] = $couponCode->code;
									$productList['discountCouponAmount'] = WC()->cart->get_coupon_discount_amount($couponCode->code);
							}
							if(WC()->cart->get_cart_shipping_total() != '')
							{
								$productList['shippingTotal'] = WC()->cart->get_shipping_total();
								//echo wc_cart_totals_shipping_method_label(WC()->cart->get_shipping_total());
							}
							$productList['cartTotal'] =wp_kses_data( WC()->cart->get_total());
			 	
			 	echo json_encode($productList);
			 	exit;
	break;
	case "deleteFromCart":

			$cartId = WC()->cart->generate_cart_id( $_REQUEST['productId'] );

				$cartItemKey = WC()->cart->find_product_in_cart( $cartId );
				//print_r($cartItemKey);
				if($cartItemKey != '') 
				{
					WC()->cart->remove_cart_item($cartItemKey);
				}

					$productList = array();
					$items = WC()->cart->get_cart();
				if(count($items)>0):
			 	foreach($items as $item)
			 	{
			 		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($item['data']->id));
						//$product_added_date = date('m/d/Y',strtotime($wooproduct->date_created));
					
								$productList[] = array('products'=>array('id' => $item['data']->id,
								'qty'=>$item['quantity'],
								'imageUrl' => $featured_image[0],
								'name' => $item['data']->name,
								'price' => $item['data']->regular_price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success')
							);
			 	}
				else:
		            $productList = array('status'=>'failed');
			    endif;
			 					$productList['cartCurrency'] = get_woocommerce_currency_symbol();
								$productList['subTotal'] = WC()->cart->get_subtotal();
							if (!empty(WC()->cart->get_applied_coupons())) 
							{	
								foreach ( WC()->cart->get_applied_coupons() as $code ) {
										$couponCode = new WC_Coupon( $code );
									}
								$productList['discountCouponCode'] = $couponCode->code;
									$productList['discountCouponAmount'] = WC()->cart->get_coupon_discount_amount($couponCode->code);
							}
							if(WC()->cart->get_cart_shipping_total() != '')
							{
								$productList['shippingTotal'] = WC()->cart->get_shipping_total();
								//echo wc_cart_totals_shipping_method_label(WC()->cart->get_shipping_total());
							}
							$productList['cartTotal'] =wp_kses_data( WC()->cart->get_total());
			 	
			 	echo json_encode($productList);
			 	exit;

	break;
	case "changeQuantity":
		global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
			//check if product already in cart
			$cartId = WC()->cart->generate_cart_id( $_REQUEST['productId'] );

				if(WC()->cart->find_product_in_cart($cartId) != '')
				{
					
					//$new_qty = 1;
					foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				        $product_id = $cart_item['data']->id;
				        //echo $product_id;
				        // Check for specific product IDs and change quantity
				        if( $_REQUEST['productId'] == $product_id && $cart_item['quantity'] != $_REQUEST['productQty'] ){
				        	//echo $cart_item_key.'<br>';
				            WC()->cart->set_quantity( $cart_item_key, $_REQUEST['productQty'] ); // Change quantity
				        }
				    }
				}
				//exit;
			 
			 $productList = array();
			 $items = WC()->cart->get_cart();
			    if(count($items)>0):
			 	foreach($items as $item)
			 	{
			 		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($item['data']->id));
						//$product_added_date = date('m/d/Y',strtotime($wooproduct->date_created));
					
								$productList[] = array('products'=>array('id' => $item['data']->id,
								'qty'=>$item['quantity'],
								'imageUrl' => $featured_image[0],
								'name' => $item['data']->name,
								'price' => $item['data']->regular_price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success')
							);
			 	}
				else:
		            $productList = array('status'=>'failed');
			    endif;
			 					$productList['cartCurrency'] = get_woocommerce_currency_symbol();
								$productList['subTotal'] = WC()->cart->get_subtotal();
							if (!empty(WC()->cart->get_applied_coupons())) 
							{	
								foreach ( WC()->cart->get_applied_coupons() as $code ) {
										$couponCode = new WC_Coupon( $code );
									}
								$productList['discountCouponCode'] = $couponCode->code;
									$productList['discountCouponAmount'] = WC()->cart->get_coupon_discount_amount($couponCode->code);
							}
							if(WC()->cart->get_cart_shipping_total() != '')
							{
								$productList['shippingTotal'] = WC()->cart->get_shipping_total();
								//echo wc_cart_totals_shipping_method_label(WC()->cart->get_shipping_total());
							}
							$productList['cartTotal'] =wp_kses_data( WC()->cart->get_total());
			 	
			 	echo json_encode($productList);
			 	exit;
			 	echo json_encode($productList);
			   exit;
	break;
	case "getCart":
		global $available_methods, $sitepress;
				
			$sitepress->switch_lang($_REQUEST['lang']);

			
		$items = WC()->cart->get_cart();
			if(!empty($items))
			{
			 	$productList = array();
				if(count($items)>0):
			 	foreach($items as $item)
			 	{
			 		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($item['data']->id));
						//$product_added_date = date('m/d/Y',strtotime($wooproduct->date_created));
					
								$productList[] = array('products'=>array('id' => $item['data']->id,
								'qty'=>$item['quantity'],
								'imageUrl' => $featured_image[0],
								'name' => $item['data']->name,
								'price' => $item['data']->regular_price,
								'currency'=>get_woocommerce_currency(),
								'status'=>'success')
							);
			 	}
				else:
		            $productList = array('status'=>'failed');
			    endif;
			 					$productList['cartCurrency'] = get_woocommerce_currency_symbol();
								$productList['subTotal'] = WC()->cart->get_subtotal();
							if (!empty(WC()->cart->get_applied_coupons())) 
							{	
								foreach ( WC()->cart->get_applied_coupons() as $code ) {
										$couponCode = new WC_Coupon( $code );
									}
								$productList['discountCouponCode'] = $couponCode->code;
									$productList['discountCouponAmount'] = WC()->cart->get_coupon_discount_amount($couponCode->code);
							}
							if(WC()->cart->get_cart_shipping_total() != '')
							{
								$productList['shippingTotal'] = WC()->cart->get_shipping_total();
								//echo wc_cart_totals_shipping_method_label(WC()->cart->get_shipping_total());
							}
							$productList['cartTotal'] =wp_kses_data( WC()->cart->get_total());
			 	
			 	echo json_encode($productList);
			 	exit;
			 }
			 else
			 {
			 	$productList['cartEmpty'] = 'There is nothing in your Cart!';
			 }
	break; 
	case "applyCoupon":
		$coupon_code = $_REQUEST['discountCode']; 
 
			    if ( WC()->cart->has_discount( $coupon_code ) ) return;
			 
			    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				    // this is your product ID
				    $autocoupon = array( 745 );
				 
				    if( in_array( $cart_item['product_id'], $autocoupon ) ) {   
				        WC()->cart->add_discount( $coupon_code );
				        wc_print_notices();
				    }
 			  }
 			  exit;
	case "getOrders":
			global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				
			// Get all customer orders
				$args = array(
						    'meta_key' => '_customer_user',
						    'meta_value' => $_REQUEST['userId'],
						    'numberposts' => -1
						);
			    $customer_orders = wc_get_orders($args);
			    	$orderInfo = array();
			    	$i=0;
			   if(count($customer_orders) > 0)
			   {
			    foreach($customer_orders as $order ){

				    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
				    	$shipping_method = @array_shift($order->get_shipping_methods());
							$shipping_method_name = $shipping_method['method_title'];
								$lastUpdate_date = $order->get_date_modified($order->get_customer_id());
								$paid_date = $order->get_date_paid($order->get_customer_id());
								if(!empty($paid_date))
								{	
									$paid_date = $paid_date->date("F j, Y, g:i:s A T");
								}
								else
								{
									$paid_date = 0;
								}
						$orderInfo[] = array('orderId' => $order_id,
											 'orderStatus' => $order->get_status(),
											 'currency' => $order->get_currency(),
											 'customerName'=> get_user_meta( $order->get_customer_id(), 'billing_first_name', true ).' '.get_user_meta( $order->get_customer_id(), 'billing_last_name', true ),
											 'shippingAddress' => array('shippingFirstname'=>$order->get_shipping_first_name($order->get_customer_id()),
																		'shippingLastname'=>$order->get_shipping_last_name($order->get_customer_id()),
																		'shippingCompany'=>$order->get_shipping_company($order->get_customer_id()),
																		'shippingAddress1'=>$order->get_shipping_address_1($order->get_customer_id()),
																		'shippingAddress2'=>$order->get_shipping_address_2($order->get_customer_id()),
																		'shippingCity'=>$order->get_shipping_city($order->get_customer_id()),
																		'shippingState'=>$order->get_shipping_state($order->get_customer_id()),
																		'shippingCountry'=>$order->get_shipping_country($order->get_customer_id()),
																		'shippingMapUrl'=>$order->get_shipping_address_map_url($order->get_customer_id()),
																		),
											 'billingAddress' => array('billingFirstname'=>$order->get_billing_first_name($order->get_customer_id()),
																		'billingLastname'=>$order->get_billing_last_name($order->get_customer_id()),
																		'billingCompany'=>$order->get_billing_company($order->get_customer_id()),
																		'billingAddress1'=>$order->get_billing_address_1($order->get_customer_id()),
																		'billingAddress2'=>$order->get_billing_address_2($order->get_customer_id()),
																		'billingCity'=>$order->get_billing_city($order->get_customer_id()),
																		'billingState'=>$order->get_billing_state($order->get_customer_id()),
																		'billingPostcode'=>$order->get_billing_postcode($order->get_customer_id()),
																		'billingPincode'=>$order->get_billing_postcode($order->get_customer_id()),
																		'billingCountry'=>$order->get_billing_country($order->get_customer_id()),
																		'billingEmail'=>$order->get_billing_email($order->get_customer_id()),
																		'billingPhone'=>$order->get_billing_phone($order->get_customer_id()),
																		),
											 'shippingMethod'=>$shipping_method_name,
											 'paymentMethod' =>$order->get_payment_method_title($order->get_customer_id()),
											 'shippingTotal'=>$order->get_shipping_total($order->get_customer_id()),
											 'discountTotal'=>$order->get_discount_total($order->get_customer_id()),
											 'totalPrice'=>$order->get_total($order->get_customer_id()),
											 'lastUpdateDate'=>$lastUpdate_date->date("F j, Y, g:i:s A T"),
											 'paidDate'=>$paid_date,
											);

				    foreach($order->get_items() as $item_id => $item){
				    	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($item['product_id']));
				    		$_product = get_product($item['product_id']);
				    		
				    	$orderInfo[$i]['productList'] = array('id' => $item['product_id'] ,
								'qty'=>$item['quantity'],
								'imageUrl' => $featured_image[0],
								'name' => $_product->get_name(),
								'price' => $_product->get_price()
				    	);
				    }
				    $i++;
				}
			}
			else
			{
				$orderInfo['status'] = 'You have placed no orders yet!';
			}
			echo json_encode($orderInfo);
			    exit;
	break; 
	case "createOrder":
    	global $woocommerce, $sitepress;
    	//$currency   = $order->get_currency();
    	//Getting Current Logged IN user info

    		$sitepress->switch_lang($_REQUEST['lang']);
    		
    		$user = new WP_User(get_current_user_id());
    		//Getting Cart Values
    			$items = $woocommerce->cart->get_cart();
    if(get_current_user_id() != 0)
    {
    	if(count($items) > 0)
    	{
            $order_data = array(
		         'status' => apply_filters('woocommerce_default_order_status', 'processing'),
		         'customer_id' => $user_id
    		);
		    $new_order = wc_create_order($order_data);
		    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
		            $item_id = $new_order->add_product(
		                    $values['data'], $values['quantity'], array(
		                'variation' => $values['variation'],
		                'totals' => array(
		                    'subtotal' => $values['line_subtotal'],
		                    'subtotal_tax' => $values['line_subtotal_tax'],
		                    'total' => $values['line_total'],
		                    'tax' => $values['line_tax'],
		                    'tax_data' => $values['line_tax_data'] // Since 2.2
		                )
		                    )
		            );
					//print_r($new_order);
		        }
					$user_id = get_current_user_id();
				    $address_shipping = array();
				    	$address_shipping[first_name] = get_user_meta( $user_id, 'shipping_first_name', true );
				    		$address_shipping[last_name] = get_user_meta( $user_id, 'shipping_last_name', true );
							   $address_shipping[email] = get_user_meta( $user_id, '$shipping_email', true );
							       $address_shipping[phone] = get_user_meta( $user_id, '$shipping_phone', true );
				    			$address_shipping[company] = get_user_meta( $user_id, 'shipping_company', true );
				    				$address_shipping[address_1] = get_user_meta( $user_id, 'shipping_address_1', true );
				    			$address_shipping[address_2] = get_user_meta( $user_id, 'shipping_address_2', true );
				    		$address_shipping[city] = get_user_meta( $user_id, 'shipping_city', true );
				    	$address_shipping[state] = get_user_meta( $user_id, 'shipping_state', true );
				    $address_shipping[postcode] = get_user_meta( $user_id, 'shipping_postcode', true );
				    	$address_shipping[country] = get_user_meta( $user_id, 'shipping_country', true );
				    		$new_order->set_address( $address_shipping, 'shipping' );

   
			    $address_billing = array();
				    $address_billing[first_name] = get_user_meta( $user_id, 'billing_first_name', true );
			    		$address_billing[last_name] = get_user_meta( $user_id, 'billing_last_name', true );
						$address_billing[email] = get_user_meta( $user_id, '$billing_email', true );
						     $address_billing[phone] = get_user_meta( $user_id, '$billing_phone', true );
			    			      $address_billing[company] = get_user_meta( $user_id, 'billing_company', true );
			    				$address_billing[address_1] = get_user_meta( $user_id, 'billing_address_1', true );
			    			$address_billing[address_2] = get_user_meta( $user_id, 'billing_address_2', true );
			    		$address_billing[city] = get_user_meta( $user_id, 'billing_city', true );
			    	$address_billing[state] = get_user_meta( $user_id, 'billing_state', true );
			    		$address_billing[postcode] = get_user_meta( $user_id, 'billing_postcode', true );
			    	$address_billing[country] = get_user_meta( $user_id, 'billing_country', true );
			     		$new_order->set_address( $address_billing, 'billing' );


			     		//  WC()->shipping->load_shipping_methods();
						    // $shipping_methods = WC()->shipping->get_shipping_methods();

						    // // I have some logic for selecting which shipping method to use; your use case will likely be different, so figure out the method you need and store it in $selected_shipping_method

						    // $selected_shipping_method = $shipping_methods['wf_dhl_shipping'];
						    // print "<pre>";
						    // 	print_r($selected_shipping_method);
						    // 	exit;
						    //      //$rate = new WC_Shipping_Rate($selected_shipping_method->id, $selected_shipping_method->title, '10', $shipping_taxes, 'flat_rate');

						    
						    // 	$shipping_taxes = WC_Tax::calc_shipping_tax('10', WC_Tax::get_shipping_tax_rates());
     					// 			$rate = new WC_Shipping_Rate($selected_shipping_method->id, $selected_shipping_method->title, '10', $shipping_taxes, $selected_shipping_method->id);
									 //     $item = new WC_Order_Item_Shipping();
									 //     $item->set_props(array('method_title' => $rate->label, 'method_id' => $rate->id, 'total' => wc_format_decimal($rate->cost), 'taxes' => $rate->taxes, 'meta_data' => $rate->get_meta_data()));
     					// 			$new_order->add_item($item);

						 //   // $new_order->add_shipping('Flat_rate',0); 
						 // $new_order->calculate_shipping();
						 // 	$new_order->update_shipping();
						 // 		$new_order->calculate_taxes();
						 // 	$new_order->update_tax();
			     $new_order->calculate_totals();
  			$createOrderStatus['status'] = 'success';		  
    	} 
    	else
    	{
    		$createOrderStatus['status'] = 'failed';	
    	}
    }
    else
    {
    	
    	$useremail = $_REQUEST[email];
		//echo $useremail;
		if($useremail && filter_var($useremail, FILTER_VALIDATE_EMAIL)){ 
		$array =  explode('@', $useremail);
				
		    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			    $pass = array(); //remember to declare $pass as an array
			    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			    for ($i = 0; $i < 8; $i++) {
			        $n = rand(0, $alphaLength);
			        $pass[] = $alphabet[$n];
			    }
				    $password = implode($pass); //turn the array into a string	
			    	//echo $user_id = get_current_user_id();
			    	$username = $array[0];
			    	$user_id = wp_create_user( $username, $password, $useremail );
			if($user_id && is_numeric($user_id)){
					//print_r($user_id);   
					
							//$user_id = get_current_user_id();
								   
								    	add_user_meta( $user_id, 'shipping_first_name', $_REQUEST['first_name'] );
								    		add_user_meta( $user_id, 'shipping_last_name', $_REQUEST['last_name'] );
											   add_user_meta( $user_id, '$shipping_email', $_REQUEST['email'] );
											       add_user_meta( $user_id, '$shipping_phone', $_REQUEST['phone'] );
								    			add_user_meta( $user_id, 'shipping_company', $_REQUEST['company'] );
								    				add_user_meta( $user_id, 'shipping_address_1', $_REQUEST['address_1'] );
								    			add_user_meta( $user_id, 'shipping_address_2', $_REQUEST['address_2'] );
								    		add_user_meta( $user_id, 'shipping_city', $_REQUEST['city'] );
								    	add_user_meta( $user_id, 'shipping_state', $_REQUEST['state'] );
								    add_user_meta( $user_id, 'shipping_postcode', $_REQUEST['postcode'] );
								    	add_user_meta( $user_id, 'shipping_country', $_REQUEST['country'] );
								    		
				
								    add_user_meta( $user_id, 'billing_first_name', $_REQUEST['first_name'] );
							    		add_user_meta( $user_id, 'billing_last_name', $_REQUEST['last_name'] );
											add_user_meta( $user_id, '$billing_email', $_REQUEST['email'] );
										     add_user_meta( $user_id, '$billing_phone', $_REQUEST['phone'] );
							    			      add_user_meta( $user_id, 'billing_company', $_REQUEST['company'] );
							    				add_user_meta( $user_id, 'billing_address_1', $_REQUEST['address_1'] );
							    			add_user_meta( $user_id, 'billing_address_2', $_REQUEST['address_2'] );
							    		add_user_meta( $user_id, 'billing_city', $_REQUEST['city'] );
							    	add_user_meta( $user_id, 'billing_state', $_REQUEST['state'] );
							    		add_user_meta( $user_id, 'billing_postcode', $_REQUEST['postcode'] );
							    	add_user_meta( $user_id, 'billing_country', $_REQUEST['country'] );
							     		
	      $order_data = array(
			         'status' => apply_filters('woocommerce_default_order_status', 'processing'),
			         'customer_id' => $user_id
	    		);
			    $new_order = wc_create_order($order_data);
			    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
			            $item_id = $new_order->add_product( 
			                    $values['data'], $values['quantity'], array(
			                'variation' => $values['variation'],
			                'totals' => array(
			                    'subtotal' => $values['line_subtotal'],
			                    'subtotal_tax' => $values['line_subtotal_tax'],
			                    'total' => $values['line_total'],
			                    'tax' => $values['line_tax'],
			                    'tax_data' => $values['line_tax_data'] // Since 2.2
			                )
			                    )
			            );
								//print_r($new_order);
					        }
							$user_id = get_current_user_id();
						    $address_shipping = array();
						    	$address_shipping[first_name] = get_user_meta( $user_id, 'shipping_first_name', true );
						    		$address_shipping[last_name] = get_user_meta( $user_id, 'shipping_last_name', true );
									   $address_shipping[email] = get_user_meta( $user_id, '$shipping_email', true );
									       $address_shipping[phone] = get_user_meta( $user_id, '$shipping_phone', true );
						    			$address_shipping[company] = get_user_meta( $user_id, 'shipping_company', true );
						    				$address_shipping[address_1] = get_user_meta( $user_id, 'shipping_address_1', true );
						    			$address_shipping[address_2] = get_user_meta( $user_id, 'shipping_address_2', true );
						    		$address_shipping[city] = get_user_meta( $user_id, 'shipping_city', true );
						    	$address_shipping[state] = get_user_meta( $user_id, 'shipping_state', true );
						    $address_shipping[postcode] = get_user_meta( $user_id, 'shipping_postcode', true );
						    	$address_shipping[country] = get_user_meta( $user_id, 'shipping_country', true );
						    		$new_order->set_address( $address_shipping, 'shipping' );
		
		   
					    $address_billing = array();
						    $address_billing[first_name] = get_user_meta( $user_id, 'billing_first_name', true );
					    		$address_billing[last_name] = get_user_meta( $user_id, 'billing_last_name', true );
								$address_billing[email] = get_user_meta( $user_id, '$billing_email', true );
								     $address_billing[phone] = get_user_meta( $user_id, '$billing_phone', true );
					    			      $address_billing[company] = get_user_meta( $user_id, 'billing_company', true );
					    				$address_billing[address_1] = get_user_meta( $user_id, 'billing_address_1', true );
					    			$address_billing[address_2] = get_user_meta( $user_id, 'billing_address_2', true );
					    		$address_billing[city] = get_user_meta( $user_id, 'billing_city', true );
					    	$address_billing[state] = get_user_meta( $user_id, 'billing_state', true );
					    		$address_billing[postcode] = get_user_meta( $user_id, 'billing_postcode', true );
					    	$address_billing[country] = get_user_meta( $user_id, 'billing_country', true );
					     		$new_order->set_address( $address_billing, 'billing' );
					     	
					     $new_order->calculate_totals();
		  			$createOrderStatus['status'] = 'success';		     	
		         
		         }
     
     }   
	    else
	    {
	    		$createOrderStatus['status'] = 'failed';	
	    }
  }
 echo json_encode($createOrderStatus);
		exit;
 
	break;
	case "login":
		

	    $username =  $_REQUEST[ 'username' ];
	    $password =  $_REQUEST[ 'password' ];
	    $remember_me = 'on' == $_REQUEST[ 'remember_me' ] ? true : false;

	    $credentials = array(
	        'user_login'    => $username,
	        'user_password' => $password,
	        'remember'      => $remember_me
	    );

	    $user = wp_signon( $credentials, false );
	    $status = array();
	    if ( is_wp_error($user) ) {
	        $status = array('status'=> $user->get_error_message());
	    }
	    else {
	        if ( !$remember_me ) {
	            wp_setcookie( $username, $password, false, '', '', $remember_me );
	        }
	        $status = array('status'=> 'Login Success');
	    }
	    echo json_encode($status);
	    exit;
	break;
	case "signup":

		  // Post values
		    $username = $_REQUEST['username'];
		    $password = $_REQUEST['password'];
		    $email    = $_REQUEST['email'];
		    $name     = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
		    $nick     = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
		 
		    /**
		     * IMPORTANT: You should make server side validation here!
		     *
		     */
		 
		    $userdata = array(
		        'user_login' => $username,
		        'user_pass'  => $password,
		        'user_email' => $email,
		        'first_name' => $name,
		        'nickname'   => $nick,
		    );
		 
		    $user_id = wp_insert_user( $userdata ) ;
		 		update_user_meta( $user_id, 'billing_phone', $_REQUEST['phonenumber'] );
		 		update_user_meta( $user_id, 'gender', $_REQUEST['gender'] );
		 	$status = array();
		    // Return
		    if( !is_wp_error($user_id) ) {
		        $status = array('status'=>'1');
		    } else {
		        $status = array('status'=> $user_id->get_error_message());
		    }
		    echo json_encode($status);
		    exit;
		 
	break;
	case "forgotPassword":
		global $wpdb, $wp_hasher;

				$status = array();

			    $user_login = sanitize_text_field($_REQUEST['emailaddress']);

			    if ( empty( $user_login) ) {
			        $status = array('status'=>'Empty Email address field!') ;
			        	echo json_encode($status);
			   				exit; 

			    } else if ( strpos( $user_login, '@' ) ) {

			        $user_data = get_user_by( 'email', trim( $user_login ) );
			        //print_r($user_data);
			        if ( empty( $user_data ) ){

			           $status = array('status'=>"Email address doesn't exists.") ;
			       			echo json_encode($status);
			   					exit; 
			   				}
			    } else {
			        $login = trim($user_login);
			        $user_data = get_user_by('login', $login);
			    }

			    do_action('lostpassword_post');
			    if ( !$user_data ){ $status = array('status'=>"Email address doesn't exists.");
			    	echo json_encode($status);
			   			exit; 
			}

			    // redefining user_login ensures we return the right case in the email
			    $user_login = $user_data->user_login;
			    $user_email = $user_data->user_email;
			   // do_action('retreive_password', $user_login);  // Misspelled and deprecated
			    do_action('retrieve_password', $user_login);
			    $allow = apply_filters('allow_password_reset', true, $user_data->ID);
			    // if ( ! $allow )
			    //     $status = array('status'=>0) ;
			    // else if ( is_wp_error($allow) )
			    //     $status = array('status'=>0) ;
			    $key = wp_generate_password( 20, false );
			    do_action( 'retrieve_password_key', $user_login, $key );

			    if ( empty( $wp_hasher ) ) {
			        require_once ABSPATH . 'wp-includes/class-phpass.php';
			        $wp_hasher = new PasswordHash( 8, true );
			    }
			    $hashed = $wp_hasher->HashPassword( $key );    
			    $wpdb->update( $wpdb->users, array( 'user_activation_key' => time().":".$hashed ), array( 'user_login' => $user_login ) );
			    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
			    $message .= network_home_url( '/' ) . "\r\n\r\n";
			    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
			    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
			    $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

			    if ( is_multisite() )
			        $blogname = $GLOBALS['current_site']->site_name;
			    else
			        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

			    $title = sprintf( __('[%s] Password Reset'), $blogname );

			    $title = apply_filters('retrieve_password_title', $title);
			    $message = apply_filters('retrieve_password_message', $message, $key);

			    if ( $message && !wp_mail($user_email, $title, $message) )
			    {
			        $status = array('status'=> 'The e-mail could not be sent. Possible reason: your host may have disabled the mail() function...');
			        echo json_encode($status);
			   		exit; 
			    }

			    $status = array('status'=> 'Link for password reset has been emailed to you. Please check your email.');

			   echo json_encode($status);
			   exit; 	
	break;
	case "changePassword":
	   $usrId = get_current_user_id();
	   		$userInfo = get_userdata($usrId);
	   			
		   		$status = array();
        	$oldpassword = esc_attr($_REQUEST['oldPassword']);
        		$newpassword = esc_attr($_REQUEST['newPassword']);
        		if($oldpassword == '')
        		{
        			$status = array('status'=> 'Please enter your old password.');
        		}
        		elseif(!wp_check_password( $oldpassword, $userInfo->data->user_pass, $usrId))
        		{
        			$status = array('status'=> 'Your old password is not matching with our resords.');	
        		}
        		elseif($newpassword == '')
        		{
        			$status = array('status'=> 'Please enter your new password.');
        		}
        		else
        		{
        			wp_set_password($newpassword,$usrId);
        				$status = array('status'=>'Password Changed');
				}
			echo json_encode($status);
			exit;
	break;
	case "changeUserInfo":
		GLOBAL $woocommerce;
			$usrId = get_current_user_id();
				$firstName = $_REQUEST['firstName'];
					$lastName = $_REQUEST['lastName'];
						$displayName = $_REQUEST['displayName'];
						#Billing Info Variables
							$billingCompany = $_REQUEST['company'];
								$billingAddress_1 = $_REQUEST['billingAddress'];
									$billingCity = $_REQUEST['billingCity'];
								$billingState = $_REQUEST['billingState'];
							$billingCountry = $_REQUEST['billingCountry'];
						$billingPhone = $_REQUEST['billingPhone'];
					$billingPostalCode = $_REQUEST['billingPostalCode'];
					#Shipping Info Variables
						$shippingCompany = $_REQUEST['shippingCompany'];
								$shippingAddress_1 = $_REQUEST['shippingAddress'];
									$shippingCity = $_REQUEST['shippingCity'];
								$shippingState = $_REQUEST['shippingState'];
							$shippingCountry = $_REQUEST['shippinggCountry'];
						$shippingPostalCode = $_REQUEST['shippingPostalCode'];

			if($firstName != '')					
			{
				$woocommerce->customer->set_first_name($firstName);
					$woocommerce->customer->set_billing_first_name($firstName);
				$woocommerce->customer->set_shipping_first_name($firstName);
			}
			if($lastName != '')					
			{
				$woocommerce->customer->set_last_name($lastName);
					$woocommerce->customer->set_billing_last_name($lastName);
				$woocommerce->customer->set_shipping_last_name($lastName);
			}
			if($displayName != '')					
			{
				$woocommerce->customer->set_display_name($displayName);
			}
			#code for Shipping Address Change
			if($billingCompany != '')
			{
				$woocommerce->customer->set_billing_company($billingCompany);
			}
			if($billingAddress_1 != '')
			{
				$woocommerce->customer->set_billing_Address($billingAddress);
			}
			if($billingCity!= '')
			{
				$woocommerce->customer->set_billing_city($billingCity);
			}
			if($billingState!= '')
			{
				$woocommerce->customer->set_billing_state($billingState);
			}
			if($billingPhone != '')
			{
				$woocommerce->customer->set_billing_phone($billingPhone);
			}
			if($billingPostalCode != '')
			{
				$woocommerce->customer->set_billing_postcode($billingPostalCode);
			}
			if($billingCountry != '')
			{
				$woocommerce->customer->set_billing_country($billingCountry);
			}
			#code for Shipping Address Change
			if($shippingAddress_1 != '')
			{
				$woocommerce->customer->set_shipping_Address($shippingAddress_1);
			}
			if($shippingCompany != '')
			{
				$woocommerce->customer->set_shipping_company($shippingCompany);
			}
			if($shippingCity!= '')
			{
				$woocommerce->customer->set_shipping_city($shippingCity);
			}
			if($shippingState!= '')
			{
				$woocommerce->customer->set_shipping_state($shippingState);
			}
			
			if($shippingPostalCode != '')
			{
				$woocommerce->customer->set_shipping_postcode($shippingPostalCode);
			}
			if($shippingCountry != '')
			{
				$woocommerce->customer->set_shipping_country($shippingCountry);
			}
			 $status = array('status'=>'Profile Updated!');
			 	echo json_encode($status);
			 exit;


	break;
		case "getBestsellersAll":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				
				$sitepress->switch_lang($_REQUEST['lang']);

				

		/* Getting best Sellers products from the shop*/
		
			$query = new WP_Query( array(
			        'posts_per_page' => -1,
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'meta_key' => 'total_sales',
			        'orderby' => 'meta_value_num',
			        'order' => 'DESC',
			    ) );

					$i = 0;
						$productList = array();
					
			while ( $query->have_posts() ) : $query->the_post(); global $product; 

				//Getting Product Image through products ID
					
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
					$product_added_date = date('m/d/Y',strtotime($product->date_created));

							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$productList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());

				$i++;
			endwhile;
			//Returning results

			echo json_encode($productList);
			exit;
	break;
	case "getPopularProductsAll":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);

				

		/* Getting best Sellers products from the shop*/
		
			$query = new WP_Query( array(
			        'posts_per_page' => -1,
			        'post_type' => 'product',
			        'post_status' => 'publish',
			        'meta_key' => 'total_sales',
			        'orderby' => 'rand',
			        //'order' => 'RAND',
			    ) );

					$i = 0;
						$productList = array();
					
			while ( $query->have_posts() ) : $query->the_post(); global $product; 

				//Getting Product Image through products ID
					
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
					$product_added_date = date('m/d/Y',strtotime($product->date_created));

							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$productList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());

				$i++;
			endwhile;
			//Returning results

			echo json_encode($productList);
			exit;
	break;
	case "getNewProductsAll":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce, $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				

		/* Getting Latest products from the shop*/
		
			 $args = array( 'post_type' => 'product',
			  				'stock' => 1, 
			  				'posts_per_page' => -1, 
			  				'orderby' =>'date',
			  				'order' => 'DESC' );
						$productList = array();
			$loop = new WP_Query( $args );
			
			while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
				//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$productList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());
			endwhile;

			//Returning results
			echo json_encode($productList);
			exit;
	break;
	case "getFeaturedProductsAll":
			global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
			$args = array(
	        'post_type'   => 'product',
	        'stock'       => 1,
	        'posts_per_page'   => -1,
	        'orderby'     => 'date',
	        'order'       => 'DESC' ,
	        'post__in'    => wc_get_featured_product_ids()
	        
	    );

    	$loop = new WP_Query( $args );
    	
    	while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$productList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());	
    	endwhile;
    		//Returning results
			echo json_encode($productList);
			exit;
	case "getDoscountedProductsAll":
		global $sitepress;
				
				$sitepress->switch_lang($_REQUEST['lang']);
				
				
			$query_args = array(
			    'posts_per_page'    => -1,
			    'no_found_rows'     => 1,
			    'post_status'       => 'publish',
			    'post_type'         => 'product',
			    'meta_query'        => WC()->query->get_meta_query(),
			    'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
			);
			$loop = new WP_Query( $query_args );

			while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));
							if($product->sale_price == '')
							{
								$discounted_price = 'null';
							}
							else
							{
								$discounted_price = $product->sale_price;
							}
							$productList[] = array('id' => $product->id,
								'enteredDate'=>$product_added_date,
								'imageUrl' => $featured_image[0],
								'name' => $product->name,
								'price' => $product->regular_price,
								'discountedPrice' => $discounted_price,
								'currency'=>get_woocommerce_currency());	
    		endwhile;
    		//Returning results
			echo json_encode($productList);
			exit;

	break;
	default:
		echo '';
	break;
	
	
}




?>