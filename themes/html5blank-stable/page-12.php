<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<div class="container-fluid">
			<div class="row">
				<section id="section-1">
					<div class="home-slider">
						<?php
						for ($i=1; $i <= 5; $i++) { 
							$row = 'home_slider_item_'.$i;
							// echo '$i = ' . $i;
							if( have_rows($row) ){ 

								while( have_rows($row) ): the_row(); 
										$title = get_sub_field('title');
										$description = get_sub_field('description');
										$image = get_sub_field('image');
										$link = get_sub_field('link');
									if ($title == '' || $image == '' || $description == '') {
										// show nothing
									}
									else{ ?>
										<div>
											<img src="<?php echo $image; ?>">
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
					$strings = get_field('translatable_strings');
					?>
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="small-block block-left">
							<img src="<?php echo $image_2_url; ?>" class="img-left">
							<h1><?php echo $cat1->name; ?></h1>
							<h4><?php echo $cat1->description; ?></h4>
							<a href="<?php echo get_term_link($cat2->term_id); ?>"><?php echo $strings['read_more']; ?></a>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="small-block block-right">
							<img src="<?php echo $image_1_url; ?>" class="img-right">
							<h1><?php echo $cat1->name; ?></h1>
							<h4><?php echo $cat1->description; ?></h4>
							<a href="<?php echo get_term_link($cat1->term_id); ?>"><?php echo $strings['read_more']; ?></a>
						</div>
					</div>
				<?php endwhile; ?>
				
			<?php endif; ?>
				
			</div>
		</section>
		<!-- /section 1-->
		<!-- section 2-->
		<section id="section-3">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-5">
					<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
						<h4 class="title-left float-left rtl"><?php echo $strings['show_all']; ?></h4>
					</a>
				</div>
				<div class="col-lg-6 col-md-6 col-7">
					<h4 class="title-right float-right rtl"><?php echo $strings['new_products']; ?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="product-carousel latest-carousel">
						<?php
						 $args = array(
						        'post_type'      => 'product',
							    'orderby' => 'publish_date',
							    'order' => 'ASC',
						        'posts_per_page' => 10
						    );
						    $loop = new WP_Query( $args );
						    while ( $loop->have_posts() ) : $loop->the_post();
						        global $product; ?>
						        <div>
									<a href="#" class="btn-favorite"><i class="far fa-heart"></i></a>
									<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
									<a href="<?php echo get_permalink(); ?>" class="product-button rtl">
										<?php echo $strings['details']; ?>
									</a>
									<?php echo woocommerce_get_product_thumbnail(); ?>
									<h4 class="product-title rtl"><?php echo get_the_title(); ?></h4>
									<div class="cart-meta">
										<a href="<?php echo get_site_url() . '?add-to-cart=' . $product->get_id();?>" class="btn-atc button product_type_simple add_to_cart_button ajax_add_to_cart" data-quantity=1  data-title="<?php echo get_the_title(); ?>">
											<i class="fas fa-cart-plus"></i>
											ضف إلى السلة
										</a>
										<div class="price">
											<?php echo wc_price(wc_get_product( $product->get_id() )->get_regular_price()); ?>
										</div>
									</div>
								</div>
						    <?php endwhile;
						wp_reset_query(); ?>
					</div>
				</div>
			</div>
		</section>
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
		<section id="section-5" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern.png');">
			<div class="container">
			<div class="row h-100 justify-content-center align-items-center text-white">
				<div class="col-lg-auto col-12">
					<div class="row h-100 justify-content-center align-items-end">
						<div class="col-auto">
						<h3 class="py-2"><?php echo $strings['sale_offer_section']['left_title']; ?></h2>
						</div>
					</div>
				</div>
				<div class="col-lg-3 text-center col-12">
					<img class="img-offset" src="<?php echo get_template_directory_uri(); ?>/img/dates_7.png"> 
				</div>
				<div class="col-lg-4 col-12 text-lg-right text-center">
					<div class="row h-100 justify-content-center align-items-center">
						<div class="col-auto">
							<h3 class="rtl mb-4"><?php echo $strings['sale_offer_section']['center_title']; ?></h2>
							<a href="#" class="rtl flat-btn"><?php echo $strings['sale_offer_section']['button_text']; ?></a>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-12 text-lg-right text-center font-weight-bold">
					<div class="row h-100 justify-content-center align-items-center">
						<div class="col-auto col-jumbo">
							<h2><?php echo $strings['sale_offer_section']['right_title']; ?></h2>
							<h1>10%</h1>
						</div>
					</div>
				</div>
			</div>
			</div>
			
		</section>
		<!-- /section 4 -->
		<!-- section 5 -->
		<section id="section-3">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-5">
					<a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">
						<h4 class="title-left float-left rtl"><?php echo $strings['show_all']; ?></h4>
					</a>
				</div>
				<div class="col-lg-6 col-md-6 col-7">
					<h4 class="title-right float-right rtl"><?php echo $strings['new_products']; ?></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="product-carousel poppular-carousel">
						<?php
						 $args = array(
						        'post_type'      => 'product',
						 	    'meta_key' => 'total_sales',
    							'orderby' => 'meta_value_num',
						        'posts_per_page' => 10
						    );
						    $loop = new WP_Query( $args );
						    while ( $loop->have_posts() ) : $loop->the_post();
						        global $product; ?>
						        <div>
									<a href="#" class="btn-favorite"><i class="far fa-heart"></i></a>
									<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
									<a href="<?php echo get_permalink(); ?>" class="product-button rtl">
										<?php echo $strings['details']; ?>
									</a>
									<?php echo woocommerce_get_product_thumbnail(); ?>
									<h4 class="product-title rtl"><?php echo get_the_title(); ?></h4>
									<div class="cart-meta">
										<a href="<?php echo get_site_url() . '?add-to-cart=' . $product->get_id();?>" class="btn-atc button product_type_simple add_to_cart_button ajax_add_to_cart" data-quantity=1 data-title="<?php echo get_the_title(); ?>">
											<i class="fas fa-cart-plus"></i>
											ضف إلى السلة
										</a>
										<div class="price">
											<?php echo wc_price(wc_get_product( $product->get_id() )->get_regular_price()); ?>
										</div>
									</div>
								</div>
						    <?php endwhile;
						wp_reset_query(); ?>
					</div>
				</div>
			</div>
		</section>
		<!-- /section 5 -->
		<!-- section 6 -->
		<section id="section-7">
			<?php if( have_rows('featured_product_sale_countdown') ): 
				while( have_rows('featured_product_sale_countdown') ): the_row(); 
					$title = get_sub_field('title');
					$description = get_sub_field('description');
					$product = get_sub_field('product');
					$countdown_end = get_sub_field('countdown_end');

					echo "<pre>";
					// var_dump($product);
					echo "</pre>";
					
					?>
					<div class="row countdown">
						<div class="col-md-8">
							<div class="banner">
								<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' )[0]; ?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="timer">
								<h1 class="rtl text-right mb-2 font-weight-bold"><?php echo $title; ?></h1>
								<h4 class="rtl text-right mb-5 text-muted"><?php echo $description; ?></h4>
								<div class="row counter">
									<div class="col-lg-3 col-md-3 col-3">
										<p id="seconds">58</p>
										<span class="rtl"><?php echo $strings['seconds']; ?></span>
									</div>
									<div class="col-lg-3 col-md-3 col-3">
										<p id="minutes">44</p>
										<span class="rtl"><?php echo $strings['minutes']; ?></span>
									</div>
									<div class="col-lg-3 col-md-3 col-3">
										<p id="hours">09</p>
										<span class="rtl"><?php echo $strings['hours']; ?></span>
									</div>
									<div class="col-lg-3 col-md-3 col-3">
										<p id="days">01</p>
										<span class="rtl"><?php echo $strings['days']; ?></span>
									</div>
									<a href="<?php echo get_permalink($product->ID); ?>" class="cta-btn rtl mt-5"><?php echo $strings['add_to_cart']; ?> <i class="fas fa-shopping-cart"></i></a>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				
			<?php endif; ?>
			<script>
				var countDownDate = new Date("<?php echo $countdown_end; ?>").getTime();

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
		<!-- /section 6 -->
		<!-- section 7 -->
		<section id="section-8">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-5">
					<h4 class="title-left float-left rtl"><?php echo $strings['show_all']; ?></h4>
				</div>
				<div class="col-lg-6 col-md-6 col-7">
					<h4 class="title-right float-right rtl"><?php echo $strings['new_products']; ?></h4>
				</div>
			</div>
			<div class="product-carousel-sm">
				<?php
				  	$taxonomy     = 'product_cat';
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
					foreach ($all_categories as $cat) {
						$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
						$image_url = wp_get_attachment_url( $thumbnail_id );
						// echo "<pre>";
						// var_dump($cat);
						// echo "</pre>";?>
						<div>
							<div class="carousel-block">
								<img src="<?php echo $image_url; ?>" class="product-image">
								<a href="<?php get_term_link($cat->term_id); ?>" class="rtl overlay">تسوق</a>
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
		$featured_article = get_field( "featured_article" );
		// echo "<pre>";
		// var_dump($featured_article);
		// echo "</pre>";
		?>
		<section id="section-9">
			<div class="row jumbo-banner">
				<div class="col-lg-12 col-md-12 col-sm-12 img-banner">
					<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $featured_article->ID ), array('1744','872') ); ?>">
				</div>
				<div class="col-12">
					<div class="row">
						<div class="col-lg-4 offset-lg-8">
							<div class="outer">
								<h1 class="rtl font-weight-normal text-right"><?php echo $featured_article->post_title; ?></h1>
								<p class="rtl subline text-muted text-right"><?php echo wp_trim_words($featured_article->post_content, 10); ?></p>
								<a href="<?php echo get_permalink($featured_article->ID); ?>" class="rtl font-weight-bold readmore">
									<i class="mr-4 fas fa-long-arrow-alt-left"></i>
									<?php echo $strings['read_more']; ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /section 8 -->
		<!-- section 9 -->
		<section id="section-10" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern.png');">
			<div class="row h-100">
				<div class="col-lg-6 col-md-6 col-12 banner-fade">
					<img src="<?php echo get_template_directory_uri(); ?>/img/man.png"/>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="row h-100 justify-content-center align-items-center">
						<div class="col-12 text-center">
							<h1 class="rtl"><?php echo $strings['join_us_and_work_with_us']; ?></h1>
							<a href="<?php echo get_permalink(10); ?>" class="rtl flat-btn"><?php echo $strings['join_now']; ?></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /section 9 -->
		<!-- section 10 -->
		<section id="section-11">
			<h1 class="rtl"><?php echo $strings['follow_us']; ?></h1>
			<div class="social">
				<span class="iconify ig" data-icon="dashicons-instagram" data-inline="false"></span>
				<span class="dashicons dashicons-twitter"></span>
				<span class="dashicons dashicons-facebook-alt"></span>
			</div>
			<p class="rtl"><?php echo $strings['follow_us_description']; ?></p>
			<div class="full-carousel-images">
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup30.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup31.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup32.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup33.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup30.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup31.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup32.png">
				</div>
				<div>
					<img src="<?php echo get_template_directory_uri(); ?>/img/MaskGroup33.png">
				</div>
			</div>
			<div class="pattern" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern2.png');"></div>
		</section>
		<!-- /section 10 -->
		</div>
		
	</main>
	<script>
		function tom_add_to_cart(placeholder) {
			var product_title = jQuery(placeholder).attr('data-title');
			// console.log(product_title);
		    jQuery.ajax({
		        url: jQuery(placeholder).attr('rel'),
		        type: "GET",
		        success:function(){
		            // alert("done");
		            jQuery(document.body).trigger('wc_fragment_refresh');
		            // console.log(product_title);
		            print_notify(product_title);
		        },
		        error:function (){
		            alert("There seems to be some error. Refresh the page and try again.");
		        }
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
