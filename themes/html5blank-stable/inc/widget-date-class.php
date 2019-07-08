<?php
/**
 * Date Class Cloud Widget.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget product date class cloud
 */
class Widget_Product_Date_Class_Cloud extends WC_Widget {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'widget_product_date_class_cloud';
		$this->widget_description = __( 'A cloud of your most used product date classes.', 'html5blank' );
		$this->widget_id          = 'product_date_class_cloud';
		$this->widget_name        = __( 'Product Date Class Cloud', 'html5blank' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Product Date Classes', 'html5blank' ),
				'label' => __( 'Title', 'html5blank' ),
			),
		);
        $widget_ops = array(
			'classname'                   => $this->widget_cssclass,
			'description'                 => $this->widget_description,
			'customize_selective_refresh' => true,
		);
        parent::__construct();

	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		$current_taxonomy = $this->get_current_taxonomy( $instance );

		if ( empty( $instance['title'] ) ) {
			$taxonomy          = get_taxonomy( $current_taxonomy );
			$instance['title'] = $taxonomy->labels->name;
		}

		$this->widget_start( $args, $instance );

		echo "<input type='checkbox' id='show-all-classes'>";
		echo '<ul class="product-date-classes">';
		
		$tags = wp_tag_cloud(
			array(
					'taxonomy'                  => $current_taxonomy,
					'smallest'=>'12',
					'largest'=>'12',
					'unit'=>'px',
					'format'=>'list',
					'topic_count_text_callback' => array( $this, 'topic_count_text' ),
            )
		);
		echo '</ul>';
		echo "<label for='show-all-classes' class='text-more'>".__('More','html5blank')."</label>";
		echo "<label for='show-all-classes' class='text-less'>".__('Less','html5blank')."</label>";
		wc_enqueue_js(
			"
			if(jQuery('.widget_product_date_class_cloud .product-date-classes li').length<7)jQuery('label[for=show-all-classes]').hide();
			jQuery( '.widget_product_date_class_cloud label.text-more' ).click( function() {
				jQuery('.widget_product_date_class_cloud .product-date-classes').css('height','300px');
				setTimeout(function(){
					jQuery('.widget_product_date_class_cloud .product-date-classes').css('height','auto');
					jQuery('.widget_product_date_class_cloud .product-date-classes').css('height',jQuery('.widget_product_date_class_cloud .product-date-classes').height()+'px');
				},400)
			});
			jQuery( '.widget_product_date_class_cloud label.text-less' ).click( function() {
				jQuery('.widget_product_date_class_cloud .product-date-classes').css('height','169px');
			});
		"
		);

		$this->widget_end( $args );
	}

	/**
	 * Return the taxonomy being displayed.
	 *
	 * @param  object $instance Widget instance.
	 * @return string
	 */
	public function get_current_taxonomy( $instance ) {
		return 'date_class';
	}

	/**
	 * Returns topic count text.
	 *
	 * @since 3.4.0
	 * @param int $count Count text.
	 * @return string
	 */
	public function topic_count_text( $count ) {
		/* translators: %s: product count */
		return sprintf( _n( '%s product', '%s products', $count, 'html5blank' ), number_format_i18n( $count ) );
	}
}
