<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<?php if ( !is_user_logged_in() ) {?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="text-align:center; width: 100%; display: block;"><?php _e('User login','html5blank');?></h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
      	<?php echo do_shortcode('[login_widget]'); ?>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<?php } ?>
<form name="checkout" method="post" class="checkout wizard woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="steps-wrap" style="background:url('<?php echo get_template_directory_uri() . '/img/Pattern.png' ?>') center top no-repeat; background-size:cover;">
		<div class="container h-100">
			<div class="row h-100  no-gutters text-center justify-content-center align-items-center">
				<div class="col-6">
					<div data-step="1" class="step rtl"><?php _e('Shipping Information','html5blank');?></div>
				</div>
				<!-- <div class="col-4">
					<div data-step="2" class="step rtl">الدفع</div>
				</div> -->
				<div class="col-6">
					<div data-step="3" class="step rtl"><?php _e('Confirmation','html5blank');?></div>
				</div>
			</div>
		</div>
	</div>
	<div class="container step-panes">
		<!-- STEP CONTENT -->
		<div data-step="1" class="row step-content  py-5">
				<?php if ( $checkout->get_checkout_fields() ) : ?>
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-12">
								<h4 class="text-lightgray font-weight-bold py-3"><i class="fas fa-shopping-cart mr-3"></i><?php _e('Shopping Cart','html5blank');?></h4>
							</div>
						</div>
						<div class="dynamic-cart-wrap" aria-labelledby="navbarDropdownCart">
							<?php
							global $woocommerce;
						    $items = $woocommerce->cart->get_cart();
					        if (!empty($items)) {
						        foreach($items as $item => $values){ 
						        	$_product =  wc_get_product( $values['data']->get_id()); ?>
						        	<div class="row py-4">
										<div class="col-9">
											<div class="row justify-content-between align-items-center">
												<div class="col-2">
													<a href="#" class="cart-trash" data-cart-item-hash="<?php echo $item; ?>" data-home-url="<?php echo get_home_url(); ?>"><i class="fas fa-trash"></i></a>
												</div>
												<div class="col-8">
													<h4 data-id="<?=$values['data']->get_id()?>"><?php echo $_product->get_title()?></h4>
												</div>
											</div>
											<div class="row justify-content-between align-items-center">
												<div class="col-6 item-counter" data-cart-item-hash="<?php echo $item; ?>" data-home-url="<?php echo get_home_url(); ?>">
													<div class="number">
														<span class="minus">-</span>
														<input type="text" value="<?php echo $values['quantity'];?>"/>
														<span class="plus">+</span>
													</div>
												</div>
												<div class="col-6">
													<h3><?php echo wc_get_product( $_product->get_id() )->get_price(); echo get_woocommerce_currency_symbol(); ?></h3>
												</div>
											</div>
										</div>
										<div class="col-3 py-2">
											<div class="row no-gutters h-100 justify-content-between align-items-center">
												<div class="col-12">
													<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );?>
													<img src="<?php  echo $image[0]; ?>" data-id="<?php echo $_product->get_id(); ?>">
												</div>
											</div>	
										</div>
									</div>

									<div class="row no-gutters">
										<div class="col-lg-12">
											<hr>
										</div>
									</div>
						        <?php }
						    }
							?>
							<div class="row bottom-section">
								<div class="col-lg-12">
									<?php
									global $woocommerce;
								    $items = $woocommerce->cart->get_cart();
							        if (!empty($items)) {
								        foreach($items as $item => $values){ 
								        	$_product =  wc_get_product( $values['data']->get_id()); ?>
								        	<div class="row py-3 justify-content-between align-items-center">
												<div class="col-auto">
													<h3><?php echo wc_get_product( $_product->get_id() )->get_price() * $values['quantity']; echo get_woocommerce_currency_symbol(); ?></h3>
												</div>
												<div class="col-auto">
													<h4 data-id="<?=$_product->get_id()?>"><?php echo $_product->get_title()?></h4>
												</div>
											</div>
								        <?php }
								    } ?>
								</div>
							</div>
							<div class="row no-gutters">
								<div class="col-lg-12">
									<hr>
								</div>
							</div>
							<div class="row py-3 justify-content-between align-items-center total">
								<div class="col-auto">
									<h3><?php echo WC()->cart->cart_contents_total; ?></h3>
								</div>
								<div class="col-auto">
									<h4><?php _e('Special packaging','html5blank');?></h4>
								</div>
							</div>
						</div>
					</div>
						<div class="col-lg-8" id="customer_details">
							<?php if ( !is_user_logged_in() ) {?>
							<!-- Button trigger modal -->
								<div id="modal-btn">
									<h5><?php _e('For a better shopping experience','html5blank');?></h5>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
										<?php _e('Log in','html5blank');?>
									</button>
								</div>
								<hr>
							<?php } ?>

							<div class="row checkout-fields">
								<div class="col-lg-12">
									<?php do_action( 'woocommerce_checkout_billing' ); ?>
								</div>
								<div class="col-lg-12">
									<?php do_action( 'woocommerce_checkout_shipping' ); ?>
								</div>
							</div>
						</div>
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				<?php endif; ?>

				
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			<div class="col-12">
				<div class="row checkout-actions py-5  justify-content-between align-items-center">
					<div class="col-auto">
						<a href="#" class="btn-flat outline prev-step"><?php _e('Go back to shopping','html5blank');?></a>
					</div>
					<div class="col-auto">
						<a href="#" class="btn-flat next-step"><?php _e('Complete the process','html5blank');?></a>
					</div>
				</div>
			</div>
		</div>
		<script>
			// var $ = jQuery;
			// $('.next-step').on('click', function(e){
			// 	$('.woocommerce-checkout input').each(function(){
			// 		if ( $(this).text() == '' ) {
			// 			$(this).css('border', '1px solid red');
			// 		}
			// 	})
			// })
		</script>

		<!-- STEP CONTENT -->
		<!-- <div data-step="2" class="row step-content  py-5">
			<div class="col-lg-8">
			<div class="row pt-4">
				<div class="col-lg-12 text-right mb-3">
					<div class="form-check payment">
						<label class="form-check-label mr-5">
						بطاقة إثتمان
						</label>
						<input class="form-check-input mt-3" type="radio" value="option1" checked>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<div class="control-label rtl text-right">
						الاسم الكامل
						</div>
						<input type="email" class="form-control">
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<div class="control-label rtl text-right">
						رفم البطاقة
						</div>
						<input type="text" class="form-control">
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<div class="control-label rtl text-right">
						كلمة المرور
						</div>
						<input type="text" class="form-control">
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group">
						<div class="control-label rtl text-right">
						تاريخ الإنتهاء
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group arrow">
									<select type="text" class="form-control">
										<option value="" selected disabled>Select option</option>
										<option value=""></option>
										<option value=""></option>
										<option value=""></option>
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group arrow">
									<select type="text" class="form-control">
										<option value="" selected disabled>Select option</option>
										<option value=""></option>
										<option value=""></option>
										<option value=""></option>
									</select>
								</div>
							</div>
						</div>
						
					</div>
				</div>

				<div class="col-lg-12 text-right py-5">
					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label mr-5" for="defaultCheck1">
							حفظ معلومات البطاقة
							</label>
							<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
						</div>
					</div>
				</div>

				<div class="col-lg-12 mt-3">
					<hr>
				</div>

				<div class="col-lg-12 text-right">
					<h5><span class="text-lightgray mr-3 rtl">عملية دفع آمنة باستخدام بطاقتك الإتمانية فيزا ماستر أو مدى</span><i class="fas fa-lock"></i></h5>
				</div>

				<?php get_template_part('templates/', 'content-paytabs'); ?>

			</div>
			</div>
			<div class="col-lg-4">
				<img src="<?php echo get_template_directory_uri(); ?>/img/payment-laptop.png">
			</div>

			<div class="col-12">
				<div class="row checkout-actions py-5  justify-content-between align-items-center">
					<div class="col-auto">
						<a href="#" class="btn-flat outline prev-step">العودة للتسوق</a>
					</div>
					<div class="col-auto">
						<a href="#" class="btn-flat next-step">إكمال العملية</a>
					</div>
				</div>
			</div>
		</div> -->

		<!-- STEP CONTENT -->
		<div data-step="3" class="row step-content  py-5">
		<div class="col-lg-6">
				<div class="row">
					<div class="col-12">
						<h4 class="rtl text-lightgray font-weight-bold py-3"><i class="fas fa-shopping-cart mr-3"></i><?php _e('Shopping Cart','html5blank');?></h4>
					</div>
				</div>
				<!-- <div class="dynamic-cart-wrap" aria-labelledby="navbarDropdownCart">
					<div class="row py-4">
						<div class="col-9">
							<div class="row justify-content-between align-items-center">
								<div class="col-2">
									<a href="#" class="cart-trash"><i class="fas fa-trash"></i></a>
								</div>
								<div class="col-8">
									<h4>عبوات خاصة</h4>
								</div>
							</div>
							<div class="row justify-content-between align-items-center">
								<div class="col-6 item-counter">
									<div class="number">
										<span class="minus">-</span>
										<input type="text" value="1"/>
										<span class="plus">+</span>
									</div>
								</div>
								<div class="col-6">
									<h3>ريال 156.00</h3>
								</div>
							</div>
						</div>
						<div class="col-3 py-2">
							<div class="row no-gutters h-100 justify-content-between align-items-center">
								<div class="col-12">
									<img src="<?php echo get_template_directory_uri(); ?>/img/dates_1.png">
								</div>
							</div>	
						</div>
					</div>

					<div class="row no-gutters">
						<div class="col-lg-12">
							<hr>
						</div>
					</div>

					<div class="row py-4">
						<div class="col-9">
							<div class="row justify-content-between align-items-center">
								<div class="col-2">
									<a href="#" class="cart-trash"><i class="fas fa-trash"></i></a>
								</div>
								<div class="col-8">
									<h4>عبوات خاصة</h4>
								</div>
							</div>
							<div class="row justify-content-between align-items-center">
								<div class="col-6 item-counter">
									<div class="number">
										<span class="minus">-</span>
										<input type="text" value="1"/>
										<span class="plus">+</span>
									</div>
								</div>
								<div class="col-6">
									<h3>ريال 156.00</h3>
								</div>
							</div>
						</div>
						<div class="col-3">
							<div class="row no-gutters h-100 justify-content-between align-items-center">
								<div class="col-12">
									<img src="<?php echo get_template_directory_uri(); ?>/img/dates_1.png">
								</div>
							</div>	
						</div>
					</div>

					<div class="row no-gutters">
						<div class="col-lg-12">
							<hr>
						</div>
					</div>

					<div class="row py-4">
						<div class="col-9">
							<div class="row justify-content-between align-items-center">
								<div class="col-2">
									<a href="#" class="cart-trash"><i class="fas fa-trash"></i></a>
								</div>
								<div class="col-8">
									<h4>عبوات خاصة</h4>
								</div>
							</div>
							<div class="row justify-content-between align-items-center">
								<div class="col-6 item-counter">
									<div class="number">
										<span class="minus">-</span>
										<input type="text" value="1"/>
										<span class="plus">+</span>
									</div>
								</div>
								<div class="col-6">
									<h3>ريال 156.00</h3>
								</div>
							</div>
						</div>
						<div class="col-3 py-2">
							<div class="row no-gutters h-100 justify-content-between align-items-center">
								<div class="col-12">
									<img src="<?php echo get_template_directory_uri(); ?>/img/dates_1.png">
								</div>
							</div>	
						</div>
					</div>

					<div class="row no-gutters">
						<div class="col-lg-12">
							<hr>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="row py-3 justify-content-between align-items-center">
								<div class="col-auto">
									<h3>598.00 ريال</h3>
								</div>
								<div class="col-auto">
									<h4>عبوات خاصة</h4>
								</div>
							</div>
							<div class="row py-3 justify-content-between align-items-center">
								<div class="col-auto">
									<h3>156.00 ريال</h3>
								</div>
								<div class="col-auto">
									<h4>عبوات خاصة</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="row no-gutters">
						<div class="col-lg-12">
							<hr>
						</div>
					</div>
					<div class="row py-3 justify-content-between align-items-center total">
						<div class="col-auto">
							<h3>156.00 ريال</h3>
						</div>
						<div class="col-auto">
							<h4>عبوات خاصة</h4>
						</div>
					</div>
				</div> -->
				<div class="dynamic-cart-wrap" aria-labelledby="navbarDropdownCart">
							<?php
							global $woocommerce;
						    $items = $woocommerce->cart->get_cart();
					        if (!empty($items)) {
						        foreach($items as $item => $values){ 
						        	$_product =  wc_get_product( $values['data']->get_id()); ?>
						        	<div class="row py-4">
										<div class="col-9">
											<div class="row justify-content-between align-items-center">
												<div class="col-2">
													<a href="#" class="cart-trash" data-cart-item-hash="<?php echo $item; ?>" data-home-url="<?php echo get_home_url(); ?>"><i class="fas fa-trash"></i></a>
												</div>
												<div class="col-8">
													<h4><?php echo $_product->get_title()?></h4>
												</div>
											</div>
											<div class="row justify-content-between align-items-center">
												<div class="col-6 item-counter" data-cart-item-hash="<?php echo $item; ?>" data-home-url="<?php echo get_home_url(); ?>">
													<div class="number">
														<span class="minus">-</span>
														<input type="text" value="<?php echo $values['quantity'];?>"/>
														<span class="plus">+</span>
													</div>
												</div>
												<div class="col-6">
													<h3><?php echo wc_get_product( $_product->get_id() )->get_price(); echo get_woocommerce_currency_symbol(); ?></h3>
												</div>
											</div>
										</div>
										<div class="col-3 py-2">
											<div class="row no-gutters h-100 justify-content-between align-items-center">
												<div class="col-12">
													<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'single-post-thumbnail' );?>
													<img src="<?php  echo $image[0]; ?>" data-id="<?php echo $_product->get_id(); ?>">
												</div>
											</div>	
										</div>
									</div>

									<div class="row no-gutters">
										<div class="col-lg-12">
											<hr>
										</div>
									</div>
						        <?php }
						    }
							?>
							<div class="row">
								<div class="col-lg-12">
									<?php
									global $woocommerce;
								    $items = $woocommerce->cart->get_cart();
							        if (!empty($items)) {
								        foreach($items as $item => $values){ 
								        	$_product =  wc_get_product( $values['data']->get_id()); ?>
								        	<div class="row py-3 justify-content-between align-items-center">
												<div class="col-auto">
													<h3><?php echo wc_get_product( $_product->get_id() )->get_price(); echo get_woocommerce_currency_symbol(); ?></h3>
												</div>
												<div class="col-auto">
													<h4><?php echo $_product->get_title()?></h4>
												</div>
											</div>
								        <?php }
								    } ?>
								</div>
							</div>
							<div class="row no-gutters">
								<div class="col-lg-12">
									<hr>
								</div>
							</div>
							<div class="row py-3 justify-content-between align-items-center total">
								<div class="col-auto pt-5">
									<h3><?php echo WC()->cart->cart_contents_total; ?></h3>
								</div>
								<div class="col-auto pt-5">
									<h4><?php _e('Special packaging','html5blank');?></h4>
								</div>
							</div>
						</div>
			</div>
			<div class="col-lg-6 pt-5">
				<!-- <div class="row mt-3 justify-content-between align-items-top">
					<div class="col-auto"><a href="#" class="text-dark edit"><i class="fas fa-edit"></i> تعديل</a></div>
					<div class="col-auto"><h2 class="font-weight-bold text-forest m-0">الشحن إلى</h2></div>
				</div>
				<div class="row py-5 text-right">
					<div class="col-12">
						<h3 class="text-muted rtl">معمر السوافيري</h3>
					</div>
					<div class="col-12">
						<h3 class="text-muted rtl">السعودية - الرياض - طريق الملك عبد العزيز - بجوار أسواق طببة</h3>
					</div>
					<div class="col-12">
						<h3 class="text-muted rtl">1234567890</h3>
					</div>
				</div>
				<div class="row py-5">
					<div class="col-12">
						<hr>
					</div>
				</div>
				<div class="row mt-3 justify-content-between align-items-top">
					<div class="col-auto"><a href="#" class="text-dark edit"><i class="fas fa-edit"></i> تعديل</a></div>
					<div class="col-auto"><h2 class="font-weight-bold text-forest m-0">الشحن إلى</h2></div>
				</div>
				<div class="row py-5 text-right">
					<div class="col-lg-2">
						<img src="<?php echo get_template_directory_uri(); ?>/img/visa.png">
					</div>
					<div class="col-lg-10">
						<div class="row">
							<div class="col-12">
								<h2 class="text-muted rtl">Moamer Sawafiri</h2>
							</div>
							<div class="col-12">
								<h2 class="text-muted rtl">**** **** **** 1234</h2>
							</div>
						</div>
					</div>
				</div>

				<div class="row checkout-actions py-5 justify-content-end align-items-center">
					<div class="col-auto">
						<a href="#" class="btn-flat btn-checkout">إكمال العملية</a>
					</div>
				</div> -->

				<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

				<div class="row checkout-actions py-5 justify-content-end align-items-center" style="display:none">
					<div class="col-auto">
						<a href="#" class="btn-flat outline prev-step"><?php _e('Go back to shopping','html5blank');?></a>
					</div>
				</div>

			</div>
		</div>
	</div>
	

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
