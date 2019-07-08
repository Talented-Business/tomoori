<?php get_header(); ?>


<div class="search-header">
	<div class="container">
		<div class="row py-5">
			<div class="col-lg-12 my-2">
				<?php get_template_part('searchform'); ?>
			</div>
		</div>
	</div>
</div>

<div class="container pb-5">
	<div class="row justify-content-start py-4">
		<div class="col-auto">
			<h4 class="text-right"><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); ?></h4>
			<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			
			<?php get_template_part('loop'); ?>

			<?php get_template_part('pagination'); ?>

		</div>
	</div>
</div>

<?php get_footer(); ?>
