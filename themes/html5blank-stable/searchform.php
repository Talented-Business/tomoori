<!-- search -->

<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">

	<div class="form-group">
		<input class="search-input form-control" type="search" name="s" placeholder="<?php _e( 'To search, type and hit enter.', 'html5blank' ); ?>" value="<?php if(isset($_GET['s'])) echo $_GET['s']?>">
		<?php if(isset($_GET['post_type'])&&$_GET['post_type']=="post")$post_type='post';
			  else $post_type='product';?>
		<input type="hidden" name="post_type" value="<?=$post_type?>">
		<!-- تعور المدينة-->
	</div>

	<!-- <button class="search-submit" type="submit" role="button"><?php _e( 'Search', 'html5blank' ); ?></button> -->

</form>

<!-- /search -->

