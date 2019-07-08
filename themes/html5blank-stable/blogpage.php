<?php /* Template Name: Blog Page Template */?>
<?php get_header(); ?>

	<main role="main">
		<section id="title" class="title-header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/Pattern.png');">
			<div class="container h-100">
				<div class="row h-100 align-items-center">
					<div class="col-12">
						<h1 class="rtl m-0"><?php the_title(); ?></h1>
						<div class="breadcrumb"><?php get_breadcrumb(); ?></div>
					</div>
				</div>
			</div>
		</section>
		<!-- section -->
		<section id="blog">
			<div class="container">
				<div class="row">
					<?php get_sidebar(); ?>
					<div class="col-lg-10 col-md-9 col-sm-12">
						<?php
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
							$postsPerPage = 10;
							$postOffset = $paged * $postsPerPage;
							if(isset($btmetanm)==false)$btmetanm=null;	
							$args = array(
								'posts_per_page'  => $postsPerPage,
								'offset'          => $postOffset,
								'post_type'       => 'post',
								'suppress_filters' => false
							);

							$wp_query = new WP_Query($args);
							get_template_part('loop'); 
						?>
						<?php get_template_part('pagination'); ?>
					</div>
				</div>	
			</div>
		</section>
		<!-- /section -->
	</main>

<?php get_footer(); ?>
