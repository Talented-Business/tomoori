<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="container">
	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
			<thead>
				<tr>
					<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
					<th>&nbsp;</th>
					<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>					
					<th class="product-remove">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-thumbnail text-right">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail; // PHPCS: XSS ok.
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							}
							?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
							} else {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							// Meta data.
							echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
							}
							?>
								<div class="show-for-small mobile-product-price">
									<span class="mobile-product-price__qty"><?=$cart_item['quantity']?> x </span>
									<span class="woocommerce-Price-amount amount">
									<?php
										echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
									?>										
									</span>							
								</div>    
							</td>

							<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</td>

							<td class="product-quantity" data-cart-item-hash="<?php echo $cart_item_key; ?>" data-home-url="<?php echo get_home_url(); ?>" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">

								<div class="number">
									<span class="minus">-</span>
									<input type="text" value="<?= $cart_item['quantity']; ?>"/>
									<span class="plus">+</span>
								</div>
							</td>

							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</td>


							<td class="product-remove text-center">
								<?php
									// @codingStandardsIgnoreLine
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
								?>
							</td>


							

						</tr>
						<?php
					}
				}
				?>

				<?php do_action( 'woocommerce_cart_contents' ); ?>

				<tr>
					<td colspan="6" class="actions">

						<?php if ( wc_coupons_enabled() ) { ?>
							<div class="coupon">
								<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div>
						<?php } ?>

						<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
					</td>
				</tr>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
			</tbody>
		</table>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>

	<div class="row">
		<div class="col-lg-8">
			<div class="cart-collaterals">
				<div class="row" style="display:none">
					<div class="col-12 mb-4">
						<h1 class="font-weight-bold">مجموع السلة</h1>
					</div>
					<div class="col-12 cart-items">
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
					<div class="col-12 cart-total">
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
					/**
					 * Cart collaterals hook.
					 *
					 * @hooked woocommerce_cross_sell_display
					 * @hooked woocommerce_cart_totals - 10
					 */
					do_action( 'woocommerce_cart_collaterals' );
				?>
			</div>
		</div>
		<div class="col-lg-4 pl-5 text-right">
			<div class="row py-5 cart-gift-code">
				<div class="col-12">
					<div class="form-group">
						<div class="control-label text-dark">
							<h2 class="pb-3">حساب تكلفة الشح</h2>
						</div>
						<input type="text" class="form-control" placeholder="العنوان بالكامل">
					</div>
				</div>
				<div class="col-2">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="الرهز البريدي">
					</div>
				</div>
				<div class="col-5">
					<div class="form-group arrow">
						<select name="select" id="select" class="form-control">
							<option value="" selected disabled>العدينة</option>
							<option value="">العدينة</option>
							<option value="">العدينة</option>
						</select>
					</div>
				</div>
				<div class="col-5">
					<div class="form-group arrow">
						<select name="select" id="select" class="form-control">
							<option value="" selected disabled>المملكة المتحدة</option>
							<option value="">العدينة</option>
							<option value="">العدينة</option>
						</select>
					</div>
				</div>
				<div class="col-12 mt-5">
					<div class="form-group">
					<div class="control-label text-dark">
							<h2 class="pb-3">لديك كوبون؟</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<a href="#" class="btn-flat">استخدم الكوبون</a>
						</div>
						<div class="col-8">
							<input type="text" class="form-control mt-0" placeholder="ادخل كود الكوبون هنا">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
