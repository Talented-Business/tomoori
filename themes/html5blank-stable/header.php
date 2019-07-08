<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
		<link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
		<?php wp_head(); ?>
		<script>
			// conditionizr.com
			// configure environment tests
			conditionizr.config({
			    assets: '<?php echo get_template_directory_uri(); ?>',
			    tests: {}
			});
		</script>
	</head>
	<body <?php body_class(); ?>>
		<!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
		  	Successfully added item to cart!
		</div> -->
		<!-- wrapper -->
		<!-- header -->
		<header class="header clear" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-5 col-12 text-right top-right-menu-wrap">
						<ul id="menu-top-right">
							<li><?php _e('Tech Support','html5blank'); ?></li>
							<li><a href="tel:+966148457777"><span style="color:white">0</span>+966148457777</a></li>
						</ul>
					</div>
					<div class="logo col-md-2">
						<?php get_template_part( 'partials/header-logo' );?>
					</div>
					<div class="logo col-md-5 col-sm-12 top-left-menu-wrap">
						<div class="nav-item top-left-menu-icons">
							<a class="nav-link header-search-button" href="javascriptO:;void" id="header-search-button"></a>
						</div>
						<div class="nav-item top-left-menu-icons" style="display:none;">
							<a class="nav-link" href="<?php echo get_home_url() . '/wishlist'; ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/heart-icon.png"></a>
						</div>
						<div class="nav-item top-left-menu-icons">
							<a class="nav-link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/user-icon.png"></a>
						</div>
						<div class="nav-item top-left-menu-icons">
							<a class="nav-link"  href="<?= wc_get_cart_url(); ?>" ><img src="<?php echo get_template_directory_uri(); ?>/img/shopping-cart-icon.png" ></a>
							<div class="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
						</div>
						<div class="nav-item top-left-menu-icons">
							<?php 
							if(function_exists('icl_get_languages')){
								$languages = icl_get_languages('skip_missing=0&orderby=code');
								if(!empty($languages)){
									$choosed_language = null;
									foreach($languages as $lang){
										if( $lang['active'] == 0 ) {
											$choosed_language = $lang;
										}
									}
									?>
									<a href="<?=$choosed_language['url']?>" class="nav-link language">
										<?=icl_disp_language($choosed_language['native_name'])?>
									</a>
									<?php
									$content = '<select name="lang" id="lang" onchange="document.location.href=this.value">';
										foreach($languages as $l){
											if($l['country_flag_url']){
												$selected = '';
												if($l['active'])
													$selected = 'selected="selected"';
												$content .= '<option '.$selected.' value="'.$l['url'].'">'.icl_disp_language($l['native_name'], $l['translated_name']).'</option>';
											}
										}
									$content .= '</form>';
								}
								//echo $content;
							}	
							?>
						</div>
						<div class="nav-item top-left-menu-icons">
							<a class="nav-link" href="#"><?php echo do_shortcode('[currency_switcher]'); ?></a>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- nav -->
						<?php main_nav(); ?>
					<!-- /nav -->
				</div>
			</div>
			<?php if(function_exists('get_product_search_form')):?>
				<div id="header-search" class="header-search header-search-closed">
					<button id="header-search-close" class="header-search-close">x</button>
					<form action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<span class="header-search-icon"></span>
							<input type="search" id="header-search-input" class="search-field" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
							<select name="post_type" >
								<option value="product"><?php _e('Product','html5blank');?></option>
								<option value="post"><?php _e('Blog','html5blank');?></option>
							</select>
							<button type="submit" class="btn header-search-btn" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'woocommerce' ); ?></button>
					</form>
				</div>			
			<?php endif;?>
		</header>
		<div class="mobile-menu-header" id="mobile-menu-header">
			<div class="col-2">
				<div class="top-left-menu-icons">
					<a class="nav-link mobile-cart" href="<?= wc_get_cart_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/shopping-cart-icon.png"></a>
					<div class="header-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
				</div>
			</div>    
			<div class="col-8">
				<div class="logo">
					<?php get_template_part( 'partials/header-logo' );?>
				</div>
			</div>    
			<div class="col-2">
				<?php get_template_part( 'partials/responsive-menu/button' );?>
			</div>    
		</div>

		<!-- /header -->
		