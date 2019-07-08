<?php /* Template Name: Home Page Template */?>
<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<div class="container-fluid">
			<div class="row">
				<section id="section-1">
					<div class="home-slider">
						<?php
						if( have_rows('home_sliders') ): 
							while( have_rows('home_sliders') ): the_row(); 
								$rows = get_field('home_sliders');
								foreach($rows as $key=>$row){
									if( have_rows($key) ){ 

										while( have_rows($key) ): the_row(); 
												$title = get_sub_field('title');
												$description = get_sub_field('description');
												$image = get_sub_field('image');
												$link = get_sub_field('link');
											if ($title == '' || $image == '' || $description == '') {
												// show nothing
											}
											else{ ?>
												<div>
													<?php echo apply_filters('post_thumbnail_html','<img src="'.$image.'">');?>
													<div class="title-wrap">
														<a href="<?php echo $link; ?>"><h1 class="rtl font-weight-bold"><?php echo $title; ?></h1></a>
														<a href="<?php echo $link; ?>"><h4 class="rtl"><?php echo $description; ?></h4></a>
													</div>
												</div>
										<?php }
										endwhile; ?>
										
									<?php }
									else break;
								}
							endwhile; 
						endif;
						?>
					</div>
				</section>
			</div>
		</div>
		
		<!-- /section 0-->
		<!-- section 1-->
		<div class="container">
		<section id="section-2">
			<div class="row">
				<?php if( have_rows('featured_categories') ): 
				while( have_rows('featured_categories') ): the_row(); 
					$cat1 = get_sub_field('category_1');
					$cat2 = get_sub_field('category_2');
					$image_1_url = wp_get_attachment_url( get_term_meta( $cat1->term_id, 'thumbnail_id', true ), array('228','228') );
					$image_2_url = wp_get_attachment_url( get_term_meta( $cat2->term_id, 'thumbnail_id', true ), array('228','228') );
					// echo "<pre>";
					// var_dump($cat1);
					// echo "</pre>";
					if(!empty($cat1)){
					?>
					<div class="col-lg-6 col-md-6 col-sm-12 small-block">
						<div class=" block-left">
							<img src="<?php echo $image_1_url; ?>" class="img-left">
							<h1><?php echo $cat1->name; ?></h1>
							<h4><?php echo $cat1->description; ?></h4>
							<a href="<?php echo get_term_link($cat1->term_id); ?>"><?php _e('Read More','html5blank'); ?></a>
						</div>
					</div>
					<?php
					}
					if(!empty($cat2)){
					?>
					<div class="col-lg-6 col-md-6 col-sm-12 small-block">
						<div class="block-right">
							<img src="<?php echo $image_2_url; ?>" class="img-right">
							<h1><?php echo $cat2->name; ?></h1>
							<h4><?php echo $cat2->description; ?></h4>
							<a href="<?php echo get_term_link($cat2->term_id); ?>"><?php _e('Read More','html5blank'); ?></a>
						</div>
					</div>
					<?php }?>
				<?php endwhile; ?>
				
			<?php endif; ?>
				
			</div>
		</section>
		<!-- /section 1-->
		<!-- section 2-->
	<?php if( have_rows('configurable_product_list1') ): 
			while( have_rows('configurable_product_list1') ): the_row();
			$enabled = get_sub_field('enabled');
			if($enabled):
				product_filter_by_configurable(get_sub_field('product_filter'),'section-3');
			endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>
		<!-- /section 2-->
		<!-- section 3 -->
		<!-- <section id="section-4">
			<div class="section-wrap">
				<div class="row">
					<div class="col-lg-6 px-5 col-md-6 mb-4 col-sm-12">
						<div class="section-block-big">
							<div class="row h-100 no-gutters justify-content-between align-items-end">
								<div class="col-12 text-center py-4">
									<img src="<?php echo get_template_directory_uri(); ?>/img/dates_6.png">
								</div>
								<div class="col-12">
									<div class="row h-100 align-items-end">
										<div class="col-12">
											<div class="meta-price">
												<div class="row no-gutters justify-content-between align-items-end">
													<div class="col-auto">
														<a class="btn-cart" href="#"><i class="fas fa-cart-plus"></i></a>
													</div>
													<div class="col-auto">
														<h1 class="rtl m-n mb-3">تمر حلقوم</h1>
														<p class="m-0">17.00 SR</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="row small-row small-row-top small-row-top-first">
							<div class="col-lg-6 col-md-6 mb-4 col-sm-12 section-block-small">
								<div class="section-block-small">
									<div class="section-block-small-inner custom-el">
										<img src="<?php echo get_template_directory_uri(); ?>/img/dates_28.png">
										<div class="meta-price">
											<div class="row no-gutters justify-content-between align-items-end">
												<div class="col-auto">
													<a class="btn-cart" href="#"><i class="fas fa-cart-plus"></i></a>
												</div>
												<div class="col-auto">
													<h1 class="rtl m-n mb-3">تمر حلقوم</h1>
													<p class="m-0">17.00 SR</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 mb-4 col-sm-12 section-block-small hidden-xs text-right">
								<div class="rtl section-block-small-inner inner-text">
									<h2>نتحات</h2>
									<h2>مميزة</h2>
									<a href="#">عرض المزيد</a>
								</div>
							</div>
						</div>
						<div class="row small-row small-row-top small-row-top-second">
							<div class="col-lg-6 col-md-6 mb-4 col-sm-12 section-block-small">
								<div class="section-block-small-inner">
									<img src="<?php echo get_template_directory_uri(); ?>/img/dates_34.png">
									<div class="meta-price">
										<div class="row no-gutters justify-content-between align-items-end">
											<div class="col-auto">
												<a class="btn-cart" href="#"><i class="fas fa-cart-plus"></i></a>
											</div>
											<div class="col-auto">
												<h1 class="rtl m-n mb-3">تمر حلقوم</h1>
												<p class="m-0">17.00 SR</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 mb-4 col-sm-12 section-block-small">
								<div class="section-block-small-inner">
									<img src="<?php echo get_template_directory_uri(); ?>/img/dates_33.png">
									<div class="meta-price">
										<div class="row no-gutters justify-content-between align-items-end">
											<div class="col-auto">
												<a class="btn-cart" href="#"><i class="fas fa-cart-plus"></i></a>
											</div>
											<div class="col-auto">
												<h1 class="rtl m-n mb-3">تمر حلقوم</h1>
												<p class="m-0">17.00 SR</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> -->
		<!-- /section 3 -->
		<!-- section 4 -->
		<?php 
		$banner_image = get_field( "banner_image" );
		if(!empty($banner_image)){
			?>
		</div>
			<section id="section-15">
					<img src="<?php echo $banner_image['url']; ?>" />
			</section>
		<div class="container">	
		<?php	
		}
		?>
		<!-- section 5 -->
		<?php if( have_rows('configurable_product_list2') ): 
			while( have_rows('configurable_product_list2') ): the_row();
				$enabled = get_sub_field('enabled');
				if($enabled):
					product_filter_by_configurable(get_sub_field('product_filter'),'section-14');
				endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
		<!-- /section 5 -->
		<?php if( have_rows('featured_product_sale_countdown') ): 
				while( have_rows('featured_product_sale_countdown') ): the_row(); 
					$enabled = get_sub_field('enabled');
					if($enabled):
						$title = get_sub_field('title');
						$description = get_sub_field('description');
						$product = get_sub_field('product');
						$countdown_end = get_sub_field('countdown_end');
						$post_id = get_the_ID();
						$countdown_end = get_post_meta($post_id,'featured_product_sale_countdown_countdown_end',true);
						if(strtotime($countdown_end)>time()){
							?>
		<!-- section 6 -->
		<section id="section-7">
				<?php
					
					?>
					<div class="row countdown">
						<div class="col-md-8">
							<div class="banner">
								<?php echo apply_filters('post_thumbnail_html','<img src="'.wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' )[0].'">');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="timer">
								<h1 class="rtl text-right mb-2 font-weight-bold"><?php echo $title; ?></h1>
								<p class="rtl text-right mb-5 text-muted"><?php echo $description; ?></p>
								<div class="row counter">
									<div class="col-lg-3 col-md-3 col-3">
										<p id="seconds">58</p>
										<span class="rtl"><?php _e('Seconds','html5blank'); ?></span>
									</div>
									<div class="col-lg-3 col-md-3 col-3">
										<p id="minutes">44</p>
										<span class="rtl"><?php _e('Minutes','html5blank');?></span>
									</div>
									<div class="col-lg-3 col-md-3 col-3">
										<p id="hours">09</p>
										<span class="rtl"><?php _e('hours','html5blank'); ?></span>
									</div>
									<div class="col-lg-3 col-md-3 col-3">
										<p id="days">01</p>
										<span class="rtl"><?php _e('Days','html5blank'); ?></span>
									</div>
									<a href="<?php echo get_permalink($product->ID); ?>" class="cta-btn rtl mt-5"><?php _e('Shop','html5blank'); ?></a>
								</div>
							</div>
						</div>
					</div>
			<script>
				var countDownDate = new Date("<?php echo $countdown_end; ?> gmt <?php if(get_option('gmt_offset')>=0) echo "+";echo get_option('gmt_offset');?>").getTime();
		   
				// Update the count down every 1 second
				var x = setInterval(function() {

				  // Get todays date and time
				  var now = new Date().getTime();

				  // Find the distance between now and the count down date
				  var distance = countDownDate - now;
				  // Time calculations for days, hours, minutes and seconds
				  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				  // Display the result in the element with id="demo"
				  // document.getElementById("demo").innerHTML = days + "d " + hours + "h "
				  // + minutes + "m " + seconds + "s ";

				  jQuery('.timer #days').text(days);
				  jQuery('.timer #hours').text(hours);
				  jQuery('.timer #minutes').text(minutes);
				  jQuery('.timer #seconds').text(seconds);

				  // If the count down is finished, write some text 
				  if (distance < 0) {
				    clearInterval(x);
				    //document.getElementById("demo").innerHTML = "EXPIRED";
				  }
				}, 1000);
			</script>
			
		</section>
			<?php }
				endif; ?>
		<?php endwhile; ?>
	
	<?php endif; ?>
	
		<!-- /section 6 -->
		<?php
			$taxonomy     = 'date_type';
			$orderby      = 'name';  
			$show_count   = 0;      // 1 for yes, 0 for no
			$pad_counts   = 0;      // 1 for yes, 0 for no
			$hierarchical = 1;      // 1 for yes, 0 for no  
			$title        = '';  
			$empty        = 0;

			$args = array(
				'taxonomy'     => $taxonomy,
				'orderby'      => $orderby,
				'show_count'   => $show_count,
				'pad_counts'   => $pad_counts,
				'hierarchical' => $hierarchical,
				'title_li'     => $title,
				'hide_empty'   => $empty
			);
			$all_categories = get_categories( $args );
			if(!empty($all_categories)){	
		?>
		<!-- section 7 -->
		<section id="section-8">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-5">
					<h4 class="title-left"><?php _e('Show All','html5blank'); ?></h4>
				</div>
				<div class="col-lg-6 col-md-6 col-7">
					<h4 class="title-right"><?php _e('Dates types','html5blank'); ?></h4>
				</div>
			</div>
			<div class="product-carousel-sm">
				<?php
					foreach ($all_categories as $cat) {
						$thumbnail_id = get_term_meta( $cat->term_id, 'showcase-taxonomy-image-id', true );
						$image_url = wp_get_attachment_url( $thumbnail_id );
						// echo "<pre>";
						// var_dump($cat);
						// echo "</pre>";?>
						<div>
							<div class="carousel-block">
								<img src="<?php echo $image_url; ?>" class="product-image">
								<a href="<?php echo get_term_link($cat->term_id); ?>" date-id="" class="rtl overlay"><?php _e('Shop','html5blank'); ?></a>
							</div>
							<h4 class="product-title rtl"><?php echo $cat->name; ?></h4>
						</div>
					<?php }
				?>
			</div>
		</section>
		<!-- /section 7 -->
		<!-- section 8 -->
		<?php
			}
		$featured_article = get_field( "featured_article" );
		// echo "<pre>";
		// var_dump($featured_article);
		// echo "</pre>";
		?>
		<section id="section-9" class=" img-banner" style="margin-left: calc(-50vw + 50%);">
			<div class="row jumbo-banner">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<style>
						.img-banner{
							background-image:url("<?php echo wp_get_attachment_url( get_post_thumbnail_id( $featured_article->ID ), array('1744','872') ); ?>");
							background-size: cover;
							background-position: right;
							height: 300px;
							padding-top: 300px;
						}
					</style>
				</div>
				<div class="col-12">
					<div class="row">
						<div class="col-lg-4 offset-lg-8">
							<div class="outer">
								<h1 class="rtl font-weight-normal text-right"><?php echo $featured_article->post_title; ?></h1>
								<p class="rtl subline text-muted text-right"><?php echo wp_trim_words($featured_article->post_content, 10); ?></p>
								<a href="<?php echo get_permalink($featured_article->ID); ?>" class="rtl font-weight-bold readmore">
									<?php _e('Read More','html5blank'); ?>
									<i class="mr-4 fas fa-long-arrow-alt-left"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /section 8 -->
		<?php if(false){?>
		<!-- section 9 -->
		<section id="section-10" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern.png'); display:none">
			<div class="row h-100">
				<div class="col-lg-6 col-md-6 col-12 banner-fade">
					<img src="<?php echo get_template_directory_uri(); ?>/img/man.png"/>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="row h-100 justify-content-center align-items-center">
						<div class="col-12 text-center">
							<h1 class="rtl"><?php _e('Join Us And Work With Us','html5blank'); ?></h1>
							<a href="<?php echo get_permalink(10); ?>" class="rtl flat-btn"><?php _e('Join Now','html5blank'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /section 9 -->
		<?php } ?>
		<!-- section 10 -->
		<section id="section-11">
			<h1 class="rtl"><?php _e('Follow Us','html5blank'); ?></h1>
			<div class="social">
				<a href="https://www.instagram.com/TomooriSA/" target="_blank"><span class="iconify ig" data-icon="dashicons-instagram" data-inline="false"></span></a>
				<a href="https://twitter.com/TomooriSA/" target="_blank"><span class="dashicons dashicons-twitter"></span></a>
				<a href="https://www.facebook.com/Tomoor-Dates-555223201509793/" target="_blank"><span class="dashicons dashicons-facebook-alt"></span></a>
			</div>
			<p class="rtl"><?php _e('Find out about our offers, find out about our products, and explore the virtues and benefits of adorning the world Enor through our follow-up on the means of communication','html5blank'); ?></p>
			<?php 
				$gallery = get_field( "gallery" );
				if(!empty($gallery)){
					?>
					<div class="full-carousel-images">
					<?php
							foreach($gallery as $image){
								$image_attributes = wp_get_attachment_image_src( $image,'medium' );
								if ( $image_attributes ) : ?>
										<img src="<?php echo $image_attributes[0]; ?>" width="<?php echo $image_attributes[1]; ?>" height="<?php echo $image_attributes[2]; ?>" />
								<?php endif; ?>
								<?php
							}
					?>
					</div>
					<?php
				}
			?>
			<div class="pattern" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern2.png');"></div>
		</section>
		<!-- /section 10 -->
		</div>
		
	</main>
	<script>
		function tom_add_to_cart(placeholder) {
			var product_title = jQuery(placeholder).attr('data-title');
			var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: placeholder.dataset.id,
            product_sku: '',
            quantity: 1,
				};
				var $thisbutton = $(placeholder);
			// console.log(product_title);
		    jQuery.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
                $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function (response) {
 
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
										print_notify(product_title);
                }
            },
        });
	    	return false;
	  	}
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
		jQuery('.btn-favorite').on('click', function(e){
			e.preventDefault();
			e.stopPropagation();
			console.log(jQuery(this).closest('div').find('.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a'));
			jQuery(this).closest('div').find('.yith-wcwl-add-to-wishlist .yith-wcwl-add-button a').click();
		})
	</script>
	<style type="text/css">
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
		.yith-wcwl-add-to-wishlist{
			position: absolute;
		}
	</style>
<?php get_footer(); ?>
