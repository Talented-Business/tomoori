<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section class="">

		<div class="title-header" style="background:url('<?php echo get_template_directory_uri() . '/img/Pattern.png' ?>') center top no-repeat; background-size:cover;">
			<div class="container h-100">
				<div class="row h-100 justify-content-end align-items-center">
					<div class="col-12">
						<h1><?php the_title(); ?></h1>
					</div>
					<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
				</div>
			</div>
		</div>
			
		<div class="container">
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php the_content(); ?>

					<?php comments_template( '', true ); // Remove if you don't want comments ?>

					<br class="clear">

					<?php edit_post_link(); ?>

				</article>
				<!-- /article -->

			<?php endwhile; ?>

			<?php else: ?>

				<!-- article -->
				<article>

					<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

				</article>
				<!-- /article -->

			<?php endif; ?>
	</div>
		</section>
		<!-- /section -->
	</main>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>
