<?php
$labels = array(
    'name'                       => _x( 'Date Classes', 'taxonomy general name', 'html5blank' ),
    'singular_name'              => _x( 'Date Class', 'taxonomy singular name', 'html5blank' ),
    'search_items'               => __( 'Search Date Classes', 'html5blank' ),
    'popular_items'              => __( 'Popular Date Classes', 'html5blank' ),
    'all_items'                  => __( 'All Date Classes', 'html5blank' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Date Class', 'html5blank' ),
    'update_item'                => __( 'Update Date Class', 'html5blank' ),
    'add_new_item'               => __( 'Add New Date Class', 'html5blank' ),
    'new_item_name'              => __( 'New Date Class Name', 'html5blank' ),
    'separate_items_with_commas' => __( 'Separate Date Classes with commas', 'html5blank' ),
    'add_or_remove_items'        => __( 'Add or remove Date Classes', 'html5blank' ),
    'choose_from_most_used'      => __( 'Choose from the most used Date Classes', 'html5blank' ),
    'not_found'                  => __( 'No Date Classes found.', 'html5blank' ),
    'menu_name'                  => __( 'Date Classes', 'html5blank' ),
);

$args = array(
    'hierarchical'          => false,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'date_class' ),
);

register_taxonomy( 'date_class', 'product', $args );
add_action( 'woocommerce_product_meta_end', 'action_product_meta_end_date_class');
add_action( 'widgets_init','wc_register_widgets_date_class' );
function action_product_meta_end_date_class(){
    global $product;
    $term_ids = wp_get_post_terms( $product->get_id(), 'date_class', array('fields' => 'ids') );
    echo get_the_term_list( $product->get_id(), 'date_class', '<span class="posted_in">' . _n( 'Date Class:', 'Date Classes:', count( $term_ids ), 'html5blank' ) . ' ', ', ', '</span>' );	
}
function wc_register_widgets_date_class(){
    register_widget( 'Widget_Product_Date_Class_Cloud' );
}
