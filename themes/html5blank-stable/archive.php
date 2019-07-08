<?php get_header(); ?>

	<main role="main">
		<section id="title" class="title-header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern.png');">
			<div class="container ">
				<div class="row align-items-center">
					<div class="col-12">
						<h1><?php _e( 'Archives', 'html5blank' ); ?></h1>
						<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
					</div>
				</div>
			</div>
		</section>

		<!-- section -->
		<section>

			<div class="container">
				<div class="row">
					<div class="col-lg-10 col-md-9 col-sm-12">

						<?php get_template_part('loop'); ?>

						<?php get_template_part('pagination'); ?>

					</div>
					<?php get_sidebar(); ?>
				</div>	
			</div>
		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
