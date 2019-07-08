<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'flex-row-reverse row', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>
	<div class="col-lg-6 col-md-6 col-sm-12">
		<div class="row">
			<div class="col-12">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>			
	</div>	

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
<script>

	jQuery('.quantity-wrap .number input').on('change', function(){
		jQuery('.ajax_add_to_cart').attr('data-quantity', jQuery(this).val() )
	})


	function print_notify(product_title){
		// console.log(product_title);
		jQuery.notify({
			// options
				icon: 'glyphicon glyphicon-shopping-cart',
				message: 'Product '+product_title+' is added to your cart.',
		},{
			// settings
			type: 'success',
			placement: {
				align: 'center'
			},
			animate:{
				enter: "animated fadeInUp",
				exit: "animated fadeOutDown"
			}
		});
	}
	jQuery('a.wishlist').on('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		console.log(jQuery(this).closest('div').find('.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a'));
		jQuery(this).closest('div').find('.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a').click();
	})
</script>
<style type="text/css">
	.num-selected{
		color: #551A28 !important;
	}
	.alert-success > [data-notify="message"] {
		font-size: 1.7em;
		text-align: center !important;
		display: block;
	}
	.alert-success {
		border-radius: 0px !important;
		background: #495226 !important;
		color: white !important;
		text-align: center !important;
		border: none !important;
	}
	.yith-wcwl-wishlistexistsbrowse{
		position: absolute;
	    top: 32px;
	    left: 57px;
	}
	#main div.number{
	    margin-top: 8px;
	    margin-bottom: 8px;
	}
	#main div.number .minus{
		margin-right: -4px;
	}
	#main div.number .minus,
	#main div.number .plus{
	    width: 40px;
	    height: 35px;
	    color: white;
	    border: 2px solid #495226;
	    color: #4E5341;
	    font-size: 1.1em;
	    font-weight: bold;
	    margin-top: -5px;
	    border-radius: 0;
	    padding: 3px 5px;
	    cursor: pointer;
	    display: inline-block;
	    vertical-align: middle;
		text-align: center;
		margin-left: -1px;
	}
	#main div.number input{
	    width: 40px;
		height: 35px;
		border:2px solid #4E5341;
	    text-align: center;
	    font-size: 1.1em;
	    font-weight: bold;
	    display: inline-block;
	    background: white;
	    padding: 5px;
	    color: #4E5341;/*#B1CF3B;*/
	    position: relative;
		left: 2px;
		margin:0 -4px;
		vertical-align:bottom;
	}
</style>