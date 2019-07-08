<?php
$labels = array(
    'name'                       => _x( 'Date Types', 'taxonomy general name', 'html5blank' ),
    'singular_name'              => _x( 'Date Type', 'taxonomy singular name', 'html5blank' ),
    'search_items'               => __( 'Search Date Types', 'html5blank' ),
    'popular_items'              => __( 'Popular Date Types', 'html5blank' ),
    'all_items'                  => __( 'All Date Types', 'html5blank' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit Date Type', 'html5blank' ),
    'update_item'                => __( 'Update Date Type', 'html5blank' ),
    'add_new_item'               => __( 'Add New Date Type', 'html5blank' ),
    'new_item_name'              => __( 'New Date Type Name', 'html5blank' ),
    'separate_items_with_commas' => __( 'Separate Date Types with commas', 'html5blank' ),
    'add_or_remove_items'        => __( 'Add or remove Date Types', 'html5blank' ),
    'choose_from_most_used'      => __( 'Choose from the most used Date Types', 'html5blank' ),
    'not_found'                  => __( 'No Date Types found.', 'html5blank' ),
    'menu_name'                  => __( 'Date Types', 'html5blank' ),
);

$args = array(
    'hierarchical'          => false,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'date_type' ),
);

register_taxonomy( 'date_type', 'product', $args );
//add_action('init', 'custom_taxonomy_flush_rewrite');
function custom_taxonomy_flush_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}
if( ! class_exists( 'Showcase_Taxonomy_Images' ) ) {
    class Showcase_Taxonomy_Images {
      
      public function __construct() {
       //
      }
  
      /**
       * Initialize the class and start calling our hooks and filters
       */
       public function init() {
       // Image actions
       add_action( 'date_type_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
       add_action( 'created_date_type', array( $this, 'save_category_image' ), 10, 2 );
       add_action( 'date_type_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
       add_filter("manage_edit-date_type_columns", array( $this, 'manage_columns' ));
       add_filter("manage_date_type_custom_column", array( $this, 'manage_theme_columns'), 10, 3);
       add_action( 'edited_date_type', array( $this, 'updated_category_image' ), 10, 2 );
       add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
       add_action( 'admin_footer', array( $this, 'add_script' ) );
       add_action( 'woocommerce_product_meta_end', array( $this, 'action_product_meta_end') );
       add_action( 'widgets_init', array( $this, 'wc_register_widgets') );
     }
     public function wc_register_widgets(){
        register_widget( 'Widget_Product_Date_Type_Cloud' );
        register_widget( 'WC_Widget_Product_Categories_Show_More' );
     }
     public function action_product_meta_end(){
        global $product;
		$term_ids = wp_get_post_terms( $product->get_id(), 'date_type', array('fields' => 'ids') );
		echo get_the_term_list( $product->get_id(), 'date_type', '<span class="posted_in">' . _n( 'Date Type:', 'Date Types:', count( $term_ids ), 'html5blank' ) . ' ', ', ', '</span>' );	
     }
     public function manage_theme_columns($out, $column_name, $term_id) {
        switch ($column_name) {
            case 'image': 
                // get header image url
                $image_id = get_term_meta ( $term_id, 'showcase-taxonomy-image-id', true );
                // Echo the image
                $out = wp_get_attachment_image ( $image_id, array(48,48) );
                break;
     
            default:
                break;
        }
        return $out;    
        }
     public function manage_columns($old_columns) {
        $new_columns = array();
        foreach($old_columns as $key=>$name){
            if($key=='name'){
                $new_columns['image'] = __('Image', 'html5blank');
            }
            $new_columns[$key] = $old_columns[$key];
        } 
        return $new_columns;
    }
     public function load_media() {
       if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'date_type' ) {
         return;
       }
       wp_enqueue_media();
     }
    
     /**
      * Add a form field in the new category page
      * @since 1.0.0
      */
    
     public function add_category_image( $taxonomy ) { ?>
       <div class="form-field term-group">
         <label for="showcase-taxonomy-image-id"><?php _e( 'Image', 'showcase' ); ?></label>
         <input type="hidden" id="showcase-taxonomy-image-id" name="showcase-taxonomy-image-id" class="custom_media_url" value="">
         <div id="category-image-wrapper"></div>
         <p>
           <input type="button" class="button button-secondary showcase_tax_media_button" id="showcase_tax_media_button" name="showcase_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
           <input type="button" class="button button-secondary showcase_tax_media_remove" id="showcase_tax_media_remove" name="showcase_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
         </p>
       </div>
     <?php }
  
     /**
      * Save the form field
      * @since 1.0.0
      */
     public function save_category_image( $term_id, $tt_id ) {
       if( isset( $_POST['showcase-taxonomy-image-id'] ) && '' !== $_POST['showcase-taxonomy-image-id'] ){
         add_term_meta( $term_id, 'showcase-taxonomy-image-id', absint( $_POST['showcase-taxonomy-image-id'] ), true );
       }
      }
  
      /**
       * Edit the form field
       * @since 1.0.0
       */
      public function update_category_image( $term, $taxonomy ) { ?>
        <tr class="form-field term-group-wrap">
          <th scope="row">
            <label for="showcase-taxonomy-image-id"><?php _e( 'Image', 'showcase' ); ?></label>
          </th>
          <td>
            <?php $image_id = get_term_meta( $term->term_id, 'showcase-taxonomy-image-id', true ); ?>
            <input type="hidden" id="showcase-taxonomy-image-id" name="showcase-taxonomy-image-id" value="<?php echo esc_attr( $image_id ); ?>">
            <div id="category-image-wrapper">
              <?php if( $image_id ) { ?>
                <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
              <?php } ?>
            </div>
            <p>
              <input type="button" class="button button-secondary showcase_tax_media_button" id="showcase_tax_media_button" name="showcase_tax_media_button" value="<?php _e( 'Add Image', 'showcase' ); ?>" />
              <input type="button" class="button button-secondary showcase_tax_media_remove" id="showcase_tax_media_remove" name="showcase_tax_media_remove" value="<?php _e( 'Remove Image', 'showcase' ); ?>" />
            </p>
          </td>
        </tr>
     <?php }
  
     /**
      * Update the form field value
      * @since 1.0.0
      */
     public function updated_category_image( $term_id, $tt_id ) {
       if( isset( $_POST['showcase-taxonomy-image-id'] ) && '' !== $_POST['showcase-taxonomy-image-id'] ){
         update_term_meta( $term_id, 'showcase-taxonomy-image-id', absint( $_POST['showcase-taxonomy-image-id'] ) );
       } else {
         update_term_meta( $term_id, 'showcase-taxonomy-image-id', '' );
       }
     }
   
     /**
      * Enqueue styles and scripts
      * @since 1.0.0
      */
     public function add_script() {
       if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'date_type' ) {
         return;
       } ?>
       <script> jQuery(document).ready( function($) {
         _wpMediaViewsL10n.insertIntoPost = '<?php _e( "Insert", "showcase" ); ?>';
         function ct_media_upload(button_class) {
           var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
           $('body').on('click', button_class, function(e) {
             var button_id = '#'+$(this).attr('id');
             var send_attachment_bkp = wp.media.editor.send.attachment;
             var button = $(button_id);
             _custom_media = true;
             wp.media.editor.send.attachment = function(props, attachment){
               if( _custom_media ) {
                 $('#showcase-taxonomy-image-id').val(attachment.id);
                 $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                 $( '#category-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
               } else {
                 return _orig_send_attachment.apply( button_id, [props, attachment] );
               }
             }
             wp.media.editor.open(button); return false;
           });
         }
         ct_media_upload('.showcase_tax_media_button.button');
         $('body').on('click','.showcase_tax_media_remove',function(){
           $('#showcase-taxonomy-image-id').val('');
           $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
         });
         // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
         $(document).ajaxComplete(function(event, xhr, settings) {
           var queryStringArr = settings.data.split('&');
           if( $.inArray('action=add-date-type', queryStringArr) !== -1 ){
             var xml = xhr.responseXML;
             $response = $(xml).find('term_id').text();
             if($response!=""){
               // Clear the thumb image
               $('#category-image-wrapper').html('');
             }
            }
          });
        });
      </script>
     <?php }
    }
  $Showcase_Taxonomy_Images = new Showcase_Taxonomy_Images();
  $Showcase_Taxonomy_Images->init(); 
}

