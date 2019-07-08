<!-- sidebar -->
<div class="sidebar <?php if(wp_is_mobile()==false)echo "col-lg-2 col-md-3"?> col-sm-12 accordion-wrap" role="complementary">

	<div class="sidebar-widget">
		<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('shop-widget-area')) ?>
	</div>

</div>
<!-- /sidebar -->
