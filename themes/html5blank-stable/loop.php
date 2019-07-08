<div class="row">
<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<div class="col-lg-3 col-md-4 col-sm-6 col-12">
			<!-- post -->
			<article class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<!-- post thumbnail -->
				<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
					<a class="image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background-image: url('<?php echo $image[0]; ?>')"></a>
				<?php endif; ?>
				<!-- /post thumbnail -->
				<div class="inner">	
					<!-- post title -->
					<h4><a class="title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
					<!-- /post title -->
					<!-- post details -->
					<h5 class="date my-4"><?php the_time('F j, Y'); ?> </h5>
					<!-- /post details -->
				</div>	
			</article>
			<!-- /post -->
		</div>

<?php endwhile; ?>

<?php else: ?>

<div class="col-lg-12">
	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
	</article>
	<!-- /article -->
</div>

<?php endif; ?>
</div>
