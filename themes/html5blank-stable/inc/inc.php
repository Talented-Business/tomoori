<?php

function ajax_qty_cart() {
	global $woocommerce;
	$cart_item_key = $_POST['cart_item_key'];
	$quantity = $_POST['quantity'];
	$is_cart_page = $_POST['is_cart_page'];
	$woocommerce->cart->set_quantity($cart_item_key, intval($quantity));
	if ($is_cart_page) {
		?>
		<div class="row">
			<div class="col-12 mb-4">
				<h1 class="font-weight-bold">مجموع السلة</h1>
			</div>
			<div class="col-12 cart-items" style="display: none;">
				<?php
				global $woocommerce;
			    $items = $woocommerce->cart->get_cart();
		        foreach($items as $item => $values) {
		        	$_product =  wc_get_product( $values['data']->get_id()); ?>
		        	<div class="row py-3 justify-content-between" data-product_id="<?php echo $_product->get_id(); ?>">
						<div class="col-auto"><h5><?php echo wc_get_product( $_product->get_id() )->get_price() * $values['quantity']; echo get_woocommerce_currency_symbol(); ?></h5></div>
						<div class="col-auto text-muted"><h5><?php echo $_product->get_title();?></h5></div>
					</div>
		        <?php } ?>
			</div>
			<div class="col-12">
				<hr>
			</div>
			<div class="col-12 cart-total" style="display: none;">
				<div class="row py-3 justify-content-between font-weight-bold">
					<div class="col-auto text-lime"><h5><?php echo $woocommerce->cart->total; echo get_woocommerce_currency_symbol(); ?></h5></div>
					<div class="col-auto text-muted"><h5>مجموع الطلبية</h5></div>
				</div>
			</div>
			<div class="col-12 mt-5">
				<a href="<?php echo get_site_url() . '/checkout';  ?>" class="btn-flat">متابعة عملية الشراء</a>
			</div>
		</div>
		<?php
	}
    die();
}
add_action('wp_ajax_qty_cart', 'ajax_qty_cart');
add_action('wp_ajax_nopriv_qty_cart', 'ajax_qty_cart');

function ajax_update_total() {
	global $woocommerce;
	$cart_item_key = $_POST['cart_item_key'];
	$quantity = $_POST['quantity'];
	$woocommerce->cart->set_quantity($cart_item_key, intval($quantity));
    header_cart_bottom_html();
    die();
}
add_action('wp_ajax_update_total', 'ajax_update_total');
add_action('wp_ajax_nopriv_update_total', 'ajax_update_total');

function ajax_checkout_wizzard_update_total() { 
	sleep(3);
	global $woocommerce;
	?>
	<div class="col-lg-12">
	<?php
    $items = $woocommerce->cart->get_cart();
    if (!empty($items)) {
        foreach($items as $item => $values){ 
        	$_product =  wc_get_product( $values['data']->get_id());
	// var_dump(wc_get_product( $_product->get_id() )->get_price()); 
	// var_dump($values['quantity']); 
	// var_dump($values['quantity'] * wc_get_product( $_product->get_id() )->get_price()); 

	$item_total = $values['quantity'] * wc_get_product( $_product->get_id() )->get_price();
	?>
        	<div class="row py-3 justify-content-between align-items-center">
				<div class="col-auto">
					<h3><?php echo $item_total; //echo get_woocommerce_currency_symbol(); ?></h3>
				</div>
				<div class="col-auto">
					<h4><?php echo $_product->get_title()?></h4>
				</div>
			</div>
        <?php }
    } ?>
	</div>
	<?php
    die();
}
add_action('wp_ajax_checkout_wizzard_update_total', 'ajax_checkout_wizzard_update_total');
add_action('wp_ajax_nopriv_checkout_wizzard_update_total', 'ajax_checkout_wizzard_update_total');

function delete_item_from_cart() {
	global $woocommerce;
	$cart_item_key = $_POST['cart_item_key'];
	
	WC()->cart->remove_cart_item($cart_item_key);
	// echo $cart_item_key;
	header_cart_html();
	die();
}
add_action('wp_ajax_delete_item_from_cart', 'delete_item_from_cart');
add_action('wp_ajax_nopriv_delete_item_from_cart', 'delete_item_from_cart');

function ajax_add_to_cart_single_product() {
	global $woocommerce;

	$vid = $_REQUEST['variation_id'];
	$pid = $_REQUEST['product_id'];
	$qty = $_REQUEST['quantity'];

	// var_dump($vid);
	if ( is_array($vid) ) {
		for ($i=0; $i < count($vid); $i++) { 
			$woocommerce->cart->add_to_cart( $pid, $qty, $vid[$i] );
		}
	}else{
		$woocommerce->cart->add_to_cart( $pid, $quantity, $vid );
	}

	$product_title = get_the_title( $pid );

	return $pid;

	// if ($vid > 0) $woocommerce->cart->add_to_cart( $product_id, $quantity, $vid );         
	// else $woocommerce->cart->add_to_cart( $product_id, $quantity ); 

	// echo "hi from server";
    die();
}
add_action('wp_ajax_add_to_cart_single_product', 'ajax_add_to_cart_single_product');
add_action('wp_ajax_nopriv_add_to_cart_single_product', 'ajax_add_to_cart_single_product');
function tomoori_scripts(){
	wp_register_script('notify', get_template_directory_uri() . '/js/bootstrap-notify.min.js', array('jquery'), '1.0.0');
	wp_enqueue_script('notify');
}

add_action( 'wp_enqueue_scripts', 'tomoori_scripts' );
function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'slider-item' => __( 'Slider Item Image' ),
    ) );
}
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

add_image_size( 'product-cat-featured-image', 105, 105, true );
function my_custom_sizes_1( $sizes ) {
    return array_merge( $sizes, array(
        'product-cat-featured-image' => __( 'Slider Item Image' ),
    ) );
}
add_filter( 'image_size_names_choose', 'my_custom_sizes_1' );

add_action('wp_head', 'myplugin_ajaxurl');

function myplugin_ajaxurl() {

   echo '<script type="text/javascript">
           var tom_ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

add_image_size( 'slider-item', 1838, 678, true );
function header_cart_html(){
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();
	if (!empty($items)) {
		foreach($items as $item => $values) { 
			$_product =  wc_get_product( $values['data']->get_id()); ?>
			<div class="row">
				<div class="col-lg-2 col-md-2 col-sm-2">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );?>
					<img src="<?php  echo $image[0]; ?>" data-id="<?php echo $_product->get_id(); ?>">
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4">
					<h4><?php echo $_product->get_title()?></h4>
					<h3><?php echo wc_get_product( $_product->get_id() )->get_price(); echo get_woocommerce_currency_symbol(); ?></h3>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 item-counter" data-cart-item-hash="<?php echo $item; ?>" data-home-url="<?php echo get_home_url(); ?>" >
					<div class="number">
						<span class="minus">-</span>
						<input type="text" value="<?php echo $values['quantity'];?>"/>
						<span class="plus">+</span>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2">
					<a href="#" class="cart-trash" data-cart-item-hash="<?php echo $item; ?>" data-home-url="<?php echo get_home_url(); ?>"><span class="dashicons dashicons-trash"></span></a>
				</div>
			</div>
			
			<?php
		} 
	?>
	<hr>
	<div class="row bottom-section">
		<div class="col-lg-4 col-md-4 col-sm-4">
			<!-- <button type="button" class="btn">تقديم النموذج</button> -->
			<a href="<?php echo wc_get_page_permalink( 'checkout' ); ?>" class="btn"><?php _e('Proceed to checkout','woocommerce'); ?></a>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?php header_cart_bottom_html();?>
		</div>
	</div>
	<?php }else echo '<h3 style="text-align: center; color: #B1CF3B; font-size: 1.3em; font-weight: bold; margin-top: 0px; margin-bottom: 10px;">سلة التسوق الخاصة بك فارغة</h3>'; 
}
function header_cart_bottom_html(){
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();
	foreach($items as $item => $values) { 
		$_product =  wc_get_product( $values['data']->get_id());?>
		<div class="row <?php echo $item; ?>"> 
			<div class="col-lg-6 col-md-6 col-sm-6">
				<h4><?php echo $_product->get_title()?></h4>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 bottom-left">
				<h3><?php echo wc_get_product( $_product->get_id() )->get_price() * $values['quantity']; echo get_woocommerce_currency_symbol(); ?></h3>
			</div>
		</div>
		<?php
	}
}
// Update Header Cart on home add to cart click
function update_header_cart() {
	sleep(1.5);
	header_cart_html();
	die();
}
add_action('wp_ajax_update_header_cart', 'update_header_cart');
add_action('wp_ajax_nopriv_update_header_cart', 'update_header_cart');

function update_mini_cart_checkout_page() {
	// global $woocommerce;

	// $vid = $_REQUEST['variation_id'];
	// $pid = $_REQUEST['product_id'];
	// $qty = $_REQUEST['quantity'];

	// // var_dump($vid);
	// if ( is_array($vid) ) {
	// 	for ($i=0; $i < count($vid); $i++) { 
	// 		$woocommerce->cart->add_to_cart( $pid, $qty, $vid[$i] );
	// 	}
	// }else{
	// 	$woocommerce->cart->add_to_cart( $pid, $quantity, $vid );
	// }

	// $product_title = get_the_title( $pid );

	// return $pid;

	// // if ($vid > 0) $woocommerce->cart->add_to_cart( $product_id, $quantity, $vid );         
	// // else $woocommerce->cart->add_to_cart( $product_id, $quantity ); 

	// echo "hi from server";
 //    die();
}
add_action('wp_ajax_update_mini_cart_checkout_page', 'ajax_update_mini_cart_checkout_page');
add_action('wp_ajax_nopriv_update_mini_cart_checkout_page', 'ajax_update_mini_cart_checkout_page');

function ajax_get_variation_price() {
	$product_id = $_REQUEST['product_id'];
	$variation_id = $_REQUEST['variation_id'];
	$product_var = new WC_Product_Variable( $product_id );
	$variation = wc_get_product($variation_id);
	echo wc_price($variation->regular_price);
    die();
}
add_action('wp_ajax_get_variation_price', 'ajax_get_variation_price');
add_action('wp_ajax_nopriv_get_variation_price', 'ajax_get_variation_price');

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
