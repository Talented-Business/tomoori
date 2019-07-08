<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item-data.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version 	2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(function_exists('woo_variation_swatches')){
?>
<ul class="variation">
	<?php foreach ( $item_data as $data ) : ?>
		<li data-wvstooltip="<?=$data['display']?>" class="image-variable-item image-variable-item-<?=$data['value']?>" title="<?=$data['display']?>" data-value="<?=$data['value']?>">
			<?php 
				$attachment_id = get_term_meta( $data['term_id'], 'product_attribute_image', true );
				$image_size    = woo_variation_swatches()->get_option( 'attribute_image_size' );
				$image_url     = wp_get_attachment_image_url( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size ) );
			?>
			<div><img alt="<?=$data['display']?>" src="<?=esc_url( $image_url )?>"></div>
			<span><?=$data['display']?></span>
		</li>	
	<?php endforeach; ?>
</ul>
<?php }?>
