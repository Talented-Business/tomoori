<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<div class="shop-page-title">
		<h1><?php woocommerce_page_title(); ?></h1>
		
	</div>
	<div class="shop-default-filters">
		<div class="filter-block">
			<?php do_action( 'woocommerce_before_shop_loop' );?>
		</div>
		<div class="filter-block" style="display:none">
			<span><?php _e('Dates Jewls','html5blank'); ?></span>
			<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" style="padding:0 10px;"><?php _e('All','html5blank'); ?></a>
			<i class="fas fa-angle-down"></i>
		</div>
	</div>
<div class="row">