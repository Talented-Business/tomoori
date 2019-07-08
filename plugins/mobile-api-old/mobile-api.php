<?php
/**
 * Plugin Name: Mobile API
 * Plugin URI: http://www.agentycoder.com/
 * Description: This is API plugin to product Woocommerce data to Mobile App
 * Version: 1.0
 * Author: Nitin Farwaha
 * Author URI: http://www.agencycoder.com
 */
/* Including Wordpress loader*/
// $path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
// echo $path;
// require_once($path."/wp-load.php");

// require_once($path."/wp-blog-header.php");

SWITCH ($_REQUEST['r']) 
{
	case "getShipingTotal":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce;
				
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
	case "getBestsellers":

		/* Getting best Sellers products from the shop*/
		global $post;
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
			if ($query->have_posts()):
				while ( $query->have_posts() ) : $query->the_post(); global $product; 

					//Getting Product Image through products ID
						
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

						$productList[] = array('productId' => $product->id,
							'enteredDate'=>$product_added_date,
							'productImageUrl' => $featured_image[0],
							'productName' => $product->name,
							'productPrice' => $product->price);

					$i++;
				endwhile;
			endif;
			wp_reset_postdata(); 
			//Returning results
			echo json_encode($productList);
			exit;
	break;
	case "getNewProducts":
		/*Defining an instance of Woocommerce here*/
			global  $woocommerce;

		/* Getting Latest products from the shop*/
		
			 $args = array( 'post_type' => 'product',
			  				'stock' => 1, 
			  				'posts_per_page' => 30, 
			  				'orderby' =>'date',
			  				'order' => 'DESC' );
						$productList = array();
			$loop = new WP_Query( $args );
			
			while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
				//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							$productList[] = array('productId' => $product->id,
								'enteredDate'=>$product_added_date,
								'productImageUrl' => $featured_image[0],
								'productName' => $product->name,
								'productPrice' => $product->price);
			endwhile;

			//Returning results
			echo json_encode($productList);
			exit;
	break;
	case "getFeaturedProducts":

			$args = array(
	        'post_type'   => 'product',
	        'stock'       => 1,
	        'posts_per_page'   => 30,
	        'orderby'     => 'date',
	        'order'       => 'DESC' ,
	        'post__in'    => wc_get_featured_product_ids()
	        
	    );

    	$loop = new WP_Query( $args );
    	
    	while ( $loop->have_posts() ) : $loop->the_post(); global $product;
    		//Getting Product Image through products ID
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($product->id));
						$product_added_date = date('m/d/Y',strtotime($product->date_created));

							$productList[] = array('productId' => $product->id,
								'enteredDate'=>$product_added_date,
								'productImageUrl' => $featured_image[0],
								'productName' => $product->name,
								'productPrice' => $product->price);	
    	endwhile;
    		//Returning results
			echo json_encode($productList);
			exit;
	case "getDoscountedProducts":

			$query_args = array(
			    'posts_per_page'    => 30,
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

							$productList[] = array('productId' => $product->id,
								'enteredDate'=>$product_added_date,
								'productImageUrl' => $featured_image[0],
								'productName' => $product->name,
								'oldPrice' => $product->regular_price,
								'discountedPrice' => $product->sale_price);	
    		endwhile;
    		//Returning results
			echo json_encode($productList);
			exit;

	break;
	default:
		echo 'NO API';
		exit;
	break;
}

//add_action( 'init', 'my_rewrite' );
function my_rewrite() {
    global $wp_rewrite;

    add_rewrite_rule('get-api-data/$', WP_PLUGIN_URL . '/mobile-api/mobile-api.php', 'top');
    $wp_rewrite->flush_rules(true);  // This should really be done in a plugin activation
}



?>