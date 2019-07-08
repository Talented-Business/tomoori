			<!-- footer -->
			<div class="container-fluid">
				<div class="bottom-pattern" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern2.png');margin-left: calc(-50vw + 50%);"></div>
			</div>
			<footer class="footer" role="contentinfo">

				<!-- copyright -->
				<!-- <p class="copyright">
					&copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>. <?php _e('Powered by', 'html5blank'); ?>
					<a href="//wordpress.org" title="WordPress">WordPress</a> &amp; <a href="//html5blank.com" title="HTML5 Blank">HTML5 Blank</a>.
				</p> -->
				<!-- /copyright -->

				<div class="container row" style="flex-direction: row-reverse;">
					<div class="col-md-5 row">
						<div class="col-md-12">
							<h3><?php _e('Join Our Newsletter','html5blank'); ?></h3>
							<form id="subscribe-footer" action="https://gmail.us20.list-manage.com/subscribe/post?u=fffb1d8debacd071992ed275c&amp;id=4ced862329" method="post"
								id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<div class="row ">
									<div class="col-lg-9 col-md-9 col-sm-9 col-9">
										<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-3">
										<input type="submit" value="<?php _e("Submit", 'html5blank'); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
									</div>
								</div>
							</form>
						</div>
						<div  class="col-md-12">
							<img src="<?php echo get_template_directory_uri(); ?>/img/mada1.png" class="payments">
							<img src="<?php echo get_template_directory_uri(); ?>/img/visa.png" class="payments">
							<img src="<?php echo get_template_directory_uri(); ?>/img/mastercard.png" class="payments">
						</div>
					</div>
					<div class="col-md-7 row">
						<div class="col-md-6 col-sm-4 col-4 d-none d-sm-block">
							<a href="<?php echo home_url(); ?>">
								<!-- logo -->
								<!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo-footer.png" alt="Logo" class="logo-img">
								<!-- /logo -->
							</a>
						</div>
						<div class="col-md-3 col-sm-4 col-4">
							<h3><?php _e('About Company','html5blank'); ?></h3>
							<ul class="ul-footer">
								<?php
								$menu_items = wp_get_nav_menu_items(37);
								foreach ($menu_items as $item) {
									// echo "<pre>";
									// var_dump($item);
									// echo "</pre>"; ?>
									<li><a href="<?php echo $item->url; ?>" class="<?php if( $item->ID === get_the_ID() ){ echo 'active';} ?>"><?php echo $item->title; ?></a></li>
								<?php } ?>
							</ul>
						</div>
						<div class="col-md-3 col-sm-4 col-4">
							<h3><?php _e('Track Requests','html5blank'); ?></h3>
							<ul class="ul-footer">
								<?php
								$menu_items = wp_get_nav_menu_items(36);
								foreach ($menu_items as $item) {
									// echo "<pre>";
									// var_dump($item);
									// echo "</pre>"; ?>
									<li><a href="<?php echo $item->url; ?>" class="<?php if( $item->ID === get_the_ID() ){ echo 'active';} ?>"><?php echo $item->title; ?></a></li>
								<?php } ?>
							</ul>
						</div>
						<div class="col-md-6 col-sm-4 col-4 d-block d-sm-none">
							<a href="<?php echo home_url(); ?>">
								<!-- logo -->
								<!-- svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script -->
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo-footer.png" alt="Logo" class="logo-img">
								<!-- /logo -->
							</a>
						</div>
					</div>	
				</div>
				<hr>
				<div class="row">
					<div class="col-12">
						<p class="copyright">
							&copy; <?php _e('All Rights Reserved','html5blank'); ?> 2019
						</p>
					</div>
				</div>

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>
		<?php get_template_part( 'partials/responsive-menu' );?>
		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-XXXXXXXX-XX', 'yourdomain.com');
		ga('send', 'pageview');
		</script>
		<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='MMERGE3';ftypes[3]='text';fnames[4]='MMERGE4';ftypes[4]='text';fnames[5]='BIRTHDAY';ftypes[5]='birthday';}(jQuery));var $mcj = jQuery.noConflict(true);</script>

	</body>
</html>
