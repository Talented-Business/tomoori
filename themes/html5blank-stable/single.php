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
					<div class="row py-5">
						<div class="col-lg-12 the-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<?php
				$next_post = get_next_post();
				// var_dump($next_post);
				if (!empty($next_post)) {?>
					<div class="next-post">
						<div class="container h-100">
							<div class="row h-100 align-items-center">
								<div class="col-12 text-right">
									<div class="row align-items-center">
										<div class="col-lg-2">
											<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="btn-next">
												<i class="fas fa-angle-left"></i>
											</a>
										</div>
										<div class="col-lg-10">
											<div class="next-article">
												<h1 class="rtl title mb-2"><?php echo esc_attr( $next_post->post_title ); ?></h1>
												<h4 class="rtl excerpt"><?php echo get_the_excerpt($next_post->ID); ?></h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php } ?>
			</section>
		</article>
		<!-- /article -->
		<div style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern2.png');" class="footer-pattern"></div>

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
