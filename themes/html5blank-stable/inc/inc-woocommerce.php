<?php
add_action( 'after_setup_theme', 'setup_woocommerce_support' );

function setup_woocommerce_support()
{
  add_theme_support('woocommerce');
}
//add_filter('post_class','post_class_tommori',10,3);
function post_class_tommori($classes, $class, $product_id){
    if(is_cart()==false && is_account_page()==false)$classes[] = "row";
    return $classes;
}
function product_categories_tomoori(){
    $args = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent'   => 0
    );
    $product_cat = get_terms( $args );

    foreach ($product_cat as $parent_product_cat){
        $child_args = array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'parent'   => $parent_product_cat->term_id
        );
        $child_product_cats = get_terms( $child_args ); 
        if (empty($child_product_cats)) { ?>
        <a href="<?= get_term_link($parent_product_cat->term_id); ?>"><p><?= $parent_product_cat->name; ?></p></a>
        <?php }else{
            foreach ($child_product_cats as $child_product_cat){ ?>
            <p>
                  <a class="btn btn-primary" data-toggle="collapse" data-target="#<?= $child_product_cat->term_id; ?>Collapse" aria-expanded="true" aria-controls="<?= $child_product_cat->term_id; ?>Collapse">
                    <span class="dashicons dashicons-arrow-down"></span> <?= $parent_product_cat->name; ?>
                  </a>
            </p>
        <div class="collapse show" id="<?= $child_product_cat->term_id; ?>Collapse">
            <div class="card card-body">
                <a href="<?= get_term_link($child_product_cat->term_id); ?>"><?= $child_product_cat->name; ?></a>
            </div>
        </div>
        <?php
            }
        }
    }
}
// Remove default wrappers.
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

function woocommerce_new_arrive_product_badge($product,$classes="onnew"){
    $id = $product->get_id();
    $content = '';
	$newness_days = 60;
	$created = strtotime( $product->get_date_created() );
	if ( ( time() - ( 60 * 60 * 24 * $newness_days ) ) < $created ) {
		$content = '<span class="'.$classes.'">' . esc_html__( 'New', 'html5blank' ) . '</span>';
    }
    return $content;
}
add_action( 'wp_print_styles', 'deregister_woocommerce_styles', 100 );
 
function deregister_woocommerce_styles() {
	wp_deregister_style( 'woocommerce-smallscreen' );
}
remove_all_actions('woocommerce_view_order',6);
//add_action('woocommerce_view_order','woocommerce_view_order_tomoori',9);
function woocommerce_view_order_tomoori($order_id){
    $shipmentId = get_post_meta($order_id, 'wf_woo_dhl_shipmentId', true);
    if( !empty( $shipmentId ) ) {
        $dhl_company_name = 'DHL';
        $dhl_delivery_estimated_time = '';
        $dhl_tracking_link = "https://www.dhl.com/en/express/tracking.html?AWB=$shipmentId&brand=DHL";    
        $available_services = get_post_meta( $order_id, '_wf_dhl_available_services', true );
        $service_code = get_post_meta( $order_id, 'wf_woo_dhl_service_code', true);
        if(isset($available_services[$service_code])==false){
            $service_code = key($available_services);
        }
        $dhl_delivery_estimated_time = $available_services[$service_code]['meta_data']['dhl_delivery_time']
        ?>
        <div class="dhl_shipping mb5">
            <div class="shipping_name">
                <?php  _e( 'Shipping Company', 'html5blank' );?>
            </div>
            <div class="content">
                <div class="shipping_company_thumbnail">
                    <img src="<?=get_template_directory_uri()?>/img/dhl-logo.svg">
                </div>
                <div class="sub_content">
                    <div class="shipping_company_name">
                        <?php  echo  $dhl_company_name;?>
                    </div>
                    <div class="shipping_estimate_time">
                        <div class="icon">
                            <img src="<?=get_template_directory_uri()?>/img/calendar-clock-icon-white.png">
                        </div>
                        <div class="description">
                            <div><?php  _e( 'Delivery Estimated Time', 'html5blank' );?></div>
                            <div style="color:#B5BC6B"><?=$dhl_delivery_estimated_time?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shipping_tracking_link">
                <a href="<?=$dhl_tracking_link?>" target="_blank" class="button">
                    <?php _e( 'Tracking Link', 'html5blank' );?>
                </a>
            </div>
        </div>
        <?php
    }else{
        echo "no shippings";
    }
}
/*add_action( 'add_meta_boxes','add_meta_boxes_orders_tomoori', 30 );
function add_meta_boxes_orders_tomoori(){
    add_meta_box( 'dhl-tracking-box', __( 'Tracking info', 'html5blank' ), 'dhl_tracking_info_view', 'shop_order', 'side', 'core' );
}
function dhl_tracking_info_view(){    
    global $post;
    $dhl_company_name = get_post_meta( $post->ID, '_dhl_company_name', true ) ? get_post_meta( $post->ID, '_dhl_company_name', true ) : '';
    $dhl_delivery_estimated_time = get_post_meta( $post->ID, '_dhl_delivery_estimated_time', true ) ? get_post_meta( $post->ID, '_dhl_delivery_estimated_time', true ) : '';
    $dhl_tracking_link = get_post_meta( $post->ID, '_dhl_tracking_link', true ) ? get_post_meta( $post->ID, '_dhl_tracking_link', true ) : '';
    ?>
    <div>
        <label><?php _e( 'Company Name', 'html5blank' );?></label>
        <input name="dhl_company_name" type="text" value="<?=$dhl_company_name?>">
    </div>
    <div>
        <label><?php _e( 'Delivery Estimated Time', 'html5blank' );?> </label>
        <input name="dhl_delivery_estimated_time" type="date" value="<?=$dhl_delivery_estimated_time?>">
    </div>
    <div>
        <label><?php _e( 'Tracking Link', 'html5blank' );?> </label><br>
        <input name="dhl_tracking_link" type="text" value="<?=$dhl_tracking_link?>">
    </div>
    <input type="hidden" name="dhl_tracking_info_nonce" value="<?= wp_create_nonce() ?>">
    <?php
}
add_action( 'save_post', 'dhl_tracking_info_save', 10,1);
function dhl_tracking_info_save($post_id){
// Check if our nonce is set.
    if ( ! isset( $_POST[ 'dhl_tracking_info_nonce' ] ) ) {
        return $post_id;
    }
    $nonce = $_REQUEST[ 'dhl_tracking_info_nonce' ];

    //Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce ) ) {
        return $post_id;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    // Check the user's permissions.
    if ( 'page' == $_POST[ 'post_type' ] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        }
    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
    }
    // --- Its safe for us to save the data ! --- //

    // Sanitize user input  and update the meta field in the database.
    update_post_meta( $post_id, '_dhl_company_name', $_POST[ 'dhl_company_name' ] );
    update_post_meta( $post_id, '_dhl_delivery_estimated_time', $_POST[ 'dhl_delivery_estimated_time' ] );
    update_post_meta( $post_id, '_dhl_tracking_link', $_POST[ 'dhl_tracking_link' ] );

}*/
function product_filter_by_configurable($product_filter,$id){
    global $wp;
    $current_url =  home_url( $wp->request );
    ?>
    <section id="<?=$id?>" class="configurable-product-list">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h3 class="title-right"><?php _e($product_filter['label'],'html5blank'); ?></h3>
            </div>
            <div class="col-lg-6 col-md-6 col-5">
                <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
                    <h4 class="title-left"><?php _e('Show All','html5blank'); ?></h4>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="woocommerce product-carousel latest-carousel">
                    <?php
                        switch($product_filter['value']){
                            case "new":
                                $args = array(
                                    'post_type' => 'product',
                                    'orderby' => 'publish_date',
                                    'order' => 'ASC',
                                    'posts_per_page' => 10
                                );
                                break;
                            case "best":
                                $args = array(
                                    'post_type' => 'product',
                                    'meta_key' => 'total_sales',
                                    'orderby' => 'meta_value_num',
                                    'posts_per_page' => 10,
                                );
                            break;
                            case "feature":
                                $tax_query[] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'name',
                                    'terms'    => 'featured',
                                    'operator' => 'IN', // or 'NOT IN' to exclude feature products
                                );
                                $args = array(
                                    'post_type'           => 'product',
                                    'post_status'         => 'publish',
                                    'ignore_sticky_posts' => 1,
                                    'posts_per_page'      => 10,
                                    'tax_query'           => $tax_query // <===
                                );								
                            break;
                        }
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            global $product; ?>
                            <div>
                                <div class="product-card">
                                    <?php
                                        echo woocommerce_new_arrive_product_badge($product);
                                    ?>	
                                    <a href="#" class="btn-favorite" style="display:none"><i class="far fa-heart"></i></a>
                                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                                    <a href="<?php echo get_permalink(); ?>" class="">
                                        <?php 										
                                            do_action( 'woocommerce_before_shop_loop_item_title' );
                                        ?>
                                        <h4 class="product-title"><?php echo get_the_title(); ?></h4>
                                    </a>
                                    <div class="cart-meta">
                                        <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
                                        <a href="javascript:;" class="btn-atc button add_to_cart_button ajax_add_to_cart" data-quantity=1 data-product_id="<?=$product->get_id()?>" data-title="<?php echo get_the_title(); ?>" rel="<?php echo $current_url . '?add-to-cart=' . $product->get_id();?>">
                                            <?php _e('Add to cart','woocommerce') ?>
                                            <i class="fas fa-cart-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                    wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </section>
    <?php    
}
add_filter ( 'woocommerce_account_menu_items', 'remove_my_account_links_tomoori' );
function remove_my_account_links_tomoori( $menu_links ){
 
	unset( $menu_links['downloads'] ); // Disable Downloads
	return $menu_links;
 
}
/**
 * default length widht height weight for shipping
 */

// To set Default Length
add_filter( 'woocommerce_product_get_length', 'tomoori_product_default_length' );
add_filter( 'woocommerce_product_variation_get_length', 'tomoori_product_default_length' );	// For variable product variations

if( ! function_exists('tomoori_product_default_length') ) {
	function tomoori_product_default_length( $length) {

		$default_length = 10;			// Provide default Length
		if( empty($length) ) {
			return $default_length;
		}
		else {
			return $length;
		}
	}
}

// To set Default Width
add_filter( 'woocommerce_product_get_width', 'tomoori_product_default_width');
add_filter( 'woocommerce_product_variation_get_width', 'tomoori_product_default_width' );	// For variable product variations

if( ! function_exists('tomoori_product_default_width') ) {
	function tomoori_product_default_width( $width) {

		$default_width = 10;			// Provide default Width
		if( empty($width) ) {
			return $default_width;
		}
		else {
			return $width;
		}
	}
}

// To set Default Height
add_filter( 'woocommerce_product_get_height', 'tomoori_product_default_height');
add_filter( 'woocommerce_product_variation_get_height', 'tomoori_product_default_height' );	// For variable product variations

if( ! function_exists('tomoori_product_default_height')) {
	function tomoori_product_default_height( $height) {

		$default_height = 10;			// Provide default Height
		if( empty($height) ) {
			return $default_height;
		}
		else {
			return $height;
		}
	}
}

// To set Default Weight
add_filter( 'woocommerce_product_get_weight', 'tomoori_product_default_weight' );
add_filter( 'woocommerce_product_variation_get_weight', 'tomoori_product_default_weight' );	// For variable product variations

if( ! function_exists('tomoori_product_default_weight') ) {
	function tomoori_product_default_weight( $weight) {

		$default_weight = 1;			// Provide default Weight
		if( empty($weight) ) {
			return $default_weight;
		}
		else {
			return $weight;
		}
	}
}
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page_tomoori', 20 );

function new_loop_shop_per_page_tomoori( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 50;
  return $cols;
}
add_action('woocommerce_add_to_cart', 'add_to_cart_tomoori',100);
function add_to_cart_tomoori(){
    if(isset($_POST['direct_cart'])){
        global $woocommerce;
        wp_redirect(wc_get_cart_url());
        exit;
    }
}
add_action('woocommerce_checkout_process', 'custom_validate_billing_phone');
function custom_validate_billing_phone() {
    $is_correct = preg_match('/^[0-9]{6,20}$/', $_POST['billing_phone']);
    if ( $_POST['billing_phone'] && !$is_correct) {
        wc_add_notice( __( 'The Phone field should be <strong>between 6 and 20 digits</strong>.' ), 'error' );
    }
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_filter('woocommerce_get_item_data','woocommerce_get_item_data_tomoori',10,2);
function woocommerce_get_item_data_tomoori($item_data1, $cart_item ){
	if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
		foreach ( $cart_item['variation'] as $name => $value ) {
            $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );
            $term_id = null;
			if ( taxonomy_exists( $taxonomy ) ) {
				// If this is a term slug, get the term's nice name.
				$term = get_term_by( 'slug', $value, $taxonomy );
                $term_id = $term->term_id;
				if ( ! is_wp_error( $term ) && $term && $term->name ) {
                    $value = $term->name;
				}
				$label = wc_attribute_label( $taxonomy );
			} else {
				// If this is a custom option slug, get the options name.
				$value = apply_filters( 'woocommerce_variation_option_name', $value, null, $taxonomy, $cart_item['data'] );
				$label = wc_attribute_label( str_replace( 'attribute_', '', $name ), $cart_item['data'] );
			}

			// Check the nicename against the title.
			if ( '' === $value || wc_is_attribute_in_product_name( $value, $cart_item['data']->get_name() ) ) {
				continue;
			}
            
			$item_data[] = array(
				'key'   => $label,
                'value' => $value,
                'term_id'=>$term_id,
			);
		}
	}else{
		$item_data = $item_data1;
	}
    return $item_data;
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_before_single_variation', 'woocommerce_template_single_price', 6 );
add_action( 'woocommerce_before_single_simple', 'woocommerce_template_single_price', 6 );