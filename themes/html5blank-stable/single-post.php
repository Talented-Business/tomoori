<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<section id="title" class="title-header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern.png');">
				<div class="container h-100">
					<div class="row h-100 align-items-center">
						<div class="col-12">
							<h1 class="m-0"><?php the_title(); ?></h1>
							<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
						</div>
					</div>
				</div>
			</section>
			<section id="content">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="post-image-header">
								<?php the_post_thumbnail(get_the_ID(), 'large', ['class' => 'img-responsive responsive--full']); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row py-5">
						<div class="col-lg-9 text-right the-content">
							<?php the_content(); ?>
						</div>
						<div class="col-lg-3 text-right">
							<h4 class="meta-title rtl text-muted"><?php _e( 'Author', 'html5blank' ); ?></h4>
							<p class="meta-data rtl"><?php echo get_the_author_meta('display_name'); ?></p>
							<h4 class="rtl text-muted mt-4"><?php _e( 'Published', 'html5blank' ); ?></h4>
							<p class="meta-date"><?php echo get_the_date('j/m/Y'); ?></p>
						</div>
					</div>
				</div>
				<div class="container">
					<div class="next-post">
						<?php
							$choosed_language = null;
							if(function_exists('icl_get_languages')){
								$languages = icl_get_languages('skip_missing=0&orderby=code');
								if(!empty($languages)){
									$choosed_language = null;
									foreach($languages as $lang){
										if( $lang['active'] == 1 ) {
											$choosed_language = $lang['code'];
										}
									}
								}
							}
							if($choosed_language == 'ar'){
								the_post_navigation(
									array(
										'prev_text' => '<span class="btn-previous"><i class="fas fa-angle-right"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nav-title">%title</span>',
										'next_text' => '<span class="nav-title">%title</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn-next"><i class="fas fa-angle-left"></i></span>',
									)
								);
							}else{
								the_post_navigation(
									array(
										'prev_text' => '<span class="btn-previous"><i class="fas fa-angle-left"></i></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nav-title">%title</span>',
										'next_text' => '<span class="nav-title">%title</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="btn-next"><i class="fas fa-angle-right"></i></span>',
									)
								);
							}							
						?>
					</div>
				</div>
			<div class="container">
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			?>
			</div>
			</section>
		</article>
		<!-- /article -->
		<div style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern2.png');height:145px;" class="footer-pattern"></div>
	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_footer(); ?>
