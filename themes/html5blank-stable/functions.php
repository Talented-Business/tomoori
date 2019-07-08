<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

//require_once( trailingslashit( get_template_directory() ). '/tomapi/login.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/whoami.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/logout.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/registeruser.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/resetpassword.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/listproducts.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/listorders.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/getorder.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/createorder.php' );
//require_once( trailingslashit( get_template_directory() ). '/tomapi/wc.php' );
require_once( trailingslashit( get_template_directory() ). '/inc/inc.php' );
require_once( trailingslashit( get_template_directory() ). '/inc/inc-woocommerce.php' );
require_once( trailingslashit( get_template_directory() ). '/inc/wp-bootstrap-navwalker.php');
require_once( trailingslashit( get_template_directory() ). '/inc/widget-date-type.php');
require_once( trailingslashit( get_template_directory() ). '/inc/widget-date-class.php');
require_once( trailingslashit( get_template_directory() ). '/inc/widget-categories.php');
require_once( trailingslashit( get_template_directory() ). '/inc/taxonomy-date-types.php');
require_once( trailingslashit( get_template_directory() ). '/inc/taxonomy-date-classes.php');
if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    // add_theme_support('featured-single');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('featured-single', 1300, 600, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

function main_nav(){ ?>
    <div class="container">
        <nav class="navbar navbar-main navbar-expand-lg navbar-light navbar navbar-toggleable-xl">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent1">
            <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'header-menu',
                        'menu_class'     => 'nav-item',
                        'depth'	          => 2,
                        'items_wrap'     => '<ul id="%1$s" class="navbar-nav mr-auto">%3$s</ul>',
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
	                    'walker'          => new WP_Bootstrap_Navwalker(),
                    )
                );
			?>                
            </div>
        </nav>
    </div>
<?php }

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0');
        wp_enqueue_script('conditionizr'); 

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1');
        wp_enqueue_script('modernizr'); 

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0');
        wp_enqueue_script('html5blankscripts'); 

        wp_register_script('popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), '1.0.0');
        wp_enqueue_script('popper'); 

        
        wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '1.0.0');
        wp_enqueue_script('bootstrap'); 

        // wp_register_script('bootstrap-bundle', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '1.0.0');
        // wp_enqueue_script('bootstrap-bundle');


    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if(WP_DEBUG){
        html5blank_styles();
        if ( is_front_page() ) {
            wp_register_style('slick', get_template_directory_uri() . '/css/slick.css');
            wp_enqueue_style('slick');
            wp_register_style('slick-theme', get_template_directory_uri() . '/css/slick-theme.css');
            wp_enqueue_style('slick-theme');
            wp_register_style('home', get_template_directory_uri() . '/css/home.css');
            wp_enqueue_style('home'); 
            
            wp_register_script('slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0');
            wp_enqueue_script('slick');
            wp_register_script('home', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0.0');
            wp_enqueue_script('home');
            //wp_style_add_data( 'home', 'rtl', 'replace' );
        }

        //if (is_page(19)) {
            wp_register_style('page-14', get_template_directory_uri() . '/css/page-14.css');
            wp_enqueue_style('page-14'); 
        //}

        if (function_exists('is_product')&&is_product()) {
            wp_register_style('page-33', get_template_directory_uri() . '/css/page-33.css');
            wp_enqueue_style('page-33');
            wp_register_style('slick', get_template_directory_uri() . '/css/slick.css');
            wp_enqueue_style('slick');
            wp_register_style('slick-theme', get_template_directory_uri() . '/css/slick-theme.css');
            wp_enqueue_style('slick-theme');
            wp_register_script('slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0');
            wp_enqueue_script('slick');
            wp_register_script('single-product', get_template_directory_uri() . '/js/single-product.js', array('jquery'), '1.0.0');
            wp_enqueue_script('single-product');
        }

        if ( is_single() ) {
            wp_register_style('single', get_template_directory_uri() . '/css/single.css');
            wp_enqueue_style('single'); 
        }

        if ( function_exists('is_shop')&&(is_shop() || is_product_category() || is_tax('date_type') || is_tax('date_class')) ) {
            wp_register_style('shop', get_template_directory_uri() . '/css/shop.css');
            wp_enqueue_style('shop'); 
        }
        if (function_exists('is_shop')&& is_cart() ) {
            wp_register_style('cart', get_template_directory_uri() . '/css/cart.css');
            wp_enqueue_style('cart'); 
            wp_register_script('cart', get_template_directory_uri() . '/js/cart.js', array('jquery'), '1.0.0');
            wp_enqueue_script('cart');
        }

        if ( function_exists('is_shop')&&is_checkout() ) {
            wp_register_style('checkout', get_template_directory_uri() . '/css/checkout.css');
            wp_enqueue_style('checkout'); 
            wp_register_script('checkout', get_template_directory_uri() . '/js/checkout.js', array('jquery'), '1.0.0');
            wp_enqueue_script('checkout');
            // wp_register_script('calling-codes', get_template_directory_uri() . '/js/calling-codes.js', array('jquery'), '1.0.0');
            // wp_enqueue_script('calling-codes');
        }

        if ( is_page(112) ) {
            wp_register_style('wishlist', get_template_directory_uri() . '/css/wishlist.css');
            wp_enqueue_style('wishlist');
        }
        if(is_page()){
            wp_register_style('page-branches', get_template_directory_uri() . '/css/page-branches.css');
            wp_enqueue_style('page-branches');
        }
        //if ( is_search() ) {
            wp_register_style('search', get_template_directory_uri() . '/css/search.css');
            wp_enqueue_style('search');
        //}
        wp_register_style('mobile-header', get_template_directory_uri() . '/css/mobile-header.css');
        wp_enqueue_style('mobile-header');
        wp_enqueue_style( 'html5blank', get_stylesheet_uri() , array(), '1.0', 'all'); 
    }else{
        if(is_front_page()){
            wp_register_style('front', get_template_directory_uri() . '/css/min/front.css');
            wp_enqueue_style('front'); 
            wp_register_script('slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0');
            wp_enqueue_script('slick');
            wp_register_script('home', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0.0');
            wp_enqueue_script('home');
        }elseif(function_exists('is_product')&&is_product()){
            wp_register_style('product', get_template_directory_uri() . '/css/min/product.css');
            wp_enqueue_style('product'); 
            wp_register_script('slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0.0');
            wp_enqueue_script('slick');
            wp_register_script('single-product', get_template_directory_uri() . '/js/single-product.js', array('jquery'), '1.0.0');
            wp_enqueue_script('single-product');
        }elseif(is_single()){
            wp_register_style('single', get_template_directory_uri() . '/css/min/single.css');
            wp_enqueue_style('single'); 
        }elseif(function_exists('is_shop')&&(is_shop() || is_product_category() || is_tax('date_type') || is_tax('date_class'))){
            wp_register_style('shop', get_template_directory_uri() . '/css/min/shop.css');
            wp_enqueue_style('shop'); 
        }elseif(function_exists('is_shop')&& is_cart()){
            wp_register_style('cart', get_template_directory_uri() . '/css/min/cart.css');
            wp_enqueue_style('cart'); 
            wp_register_script('cart', get_template_directory_uri() . '/js/cart.js', array('jquery'), '1.0.0');
            wp_enqueue_script('cart');
        }elseif(function_exists('is_shop')&&is_checkout()){
            wp_register_style('checkout', get_template_directory_uri() . '/css/min/checkout.css');
            wp_enqueue_style('checkout'); 
            wp_register_script('checkout', get_template_directory_uri() . '/js/checkout.js', array('jquery'), '1.0.0');
            wp_enqueue_script('checkout');
        }elseif(is_page()){
            wp_register_style('page', get_template_directory_uri() . '/css/min/page.css');
            wp_enqueue_style('page'); 
        }else{
            wp_register_style('general', get_template_directory_uri() . '/css/min/common.css');
            wp_enqueue_style('general'); 
        }
        //wp_enqueue_style( 'html5blank', get_stylesheet_uri() , array(), '1.0', 'all'); 
    }
    //wp_style_add_data( 'html5blank', 'rtl', 'replace' ); 

}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap'); 

    wp_register_style('bootstrap-reboot', get_template_directory_uri() . '/css/bootstrap-reboot.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap-reboot'); 
    
    wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); 

    //wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    //wp_enqueue_style('html5blank'); 

    wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), '1.0', 'all');
    wp_enqueue_style('main'); 
    //wp_style_add_data( 'main', 'rtl', 'replace' );

    wp_register_style('bootstrap-grid', get_template_directory_uri() . '/css/bootstrap-grid.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap-grid'); 

//    wp_register_style('dashicons', get_template_directory_uri() . '/css/dashicons.css', array(), '1.0', 'all');
//wp_enqueue_style('dashicons'); 


}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank'), // Extra Navigation if needed (duplicate as many as you need!)
        'mobile-mega-menu' => __('Mobile Mega Menu', 'html5blank'), 
        'mobile-mega-menu-secondary' => __('Mobile Mega Menu Secondary', 'html5blank') 
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    // Define Sidebar Shop Widget Area
    register_sidebar(array(
        'name' => __('Shop Widget Area ', 'html5blank'),
        'description' => __('Description for this shop widget-area...', 'html5blank'),
        'id' => 'shop-widget-area',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
    
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_enqueue_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
//add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

add_filter( 'woocommerce_currencies', 'add_cw_currency' );
function add_cw_currency( $cw_currency ) {
     $cw_currency['Riyal'] = __( 'Saudi Riyal Custom', 'woocommerce' );
     return $cw_currency;
}
add_filter('woocommerce_currency_symbol', 'add_cw_currency_symbol', 10, 2);
function add_cw_currency_symbol( $custom_currency_symbol, $custom_currency ) {
     switch( $custom_currency ) {
         case 'Riyal': $custom_currency_symbol = ' AR'; break;
     }
     return $custom_currency_symbol;
}

add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
function custom_woocommerce_product_add_to_cart_text() {
    global $product;
    
    $product_type = $product->get_type();
    
    switch ( $product_type ) {
        // case 'external':
        //     return __( 'External text', 'woocommerce' );
        // break;
        // case 'grouped':
        //     return __( 'Grouped text', 'woocommerce' );
        // break;
        case 'simple':
            // return __( 'اقرأ', 'woocommerce' );
            return __( '', 'woocommerce' );
        break;
        // case 'variable':
        //     return __( 'Variable text', 'woocommerce' );
        // break;
        // default:
        //     return __( 'Read more', 'woocommerce' );
    }
    
}

add_filter( 'woocommerce_product_add_to_cart_text', 'bbloomer_add_symbol_add_cart_button_single' );
 
function bbloomer_add_symbol_add_cart_button_single( $button ) {
    $button_new = $button;
    return $button_new;
}


    
add_filter( 'woocommerce_add_to_cart_fragments', 'iconic_cart_count_fragments', 10, 1 );
 function iconic_cart_count_fragments( $fragments ) {
    
    $fragments['div.header-cart-count'] = '<div class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</div>';
    
    return $fragments;
}

/* Checkout Fields */

add_filter( 'woocommerce_checkout_fields' , 'paytabs_checkout_fields' );
function paytabs_checkout_fields( $fields ) {
    
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {
            // add form-control to the actual input
            $field['class'][] = 'form-group';
            $field['input_class'][] = 'form-control';
            $field['label_class'][] = 'control-label';
        }
    }

    return $fields;
}

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

// REORDERING CHECKOUT BILLING FIELDS (WOOCOMMERCE 3+)
add_filter( "woocommerce_checkout_fields", "reordering_checkout_billing_fields", 15, 1 );
function reordering_checkout_billing_fields( $fields ) {

    ## ---- 1. REORDERING BILLING FIELDS ---- ##

    // Set the order of the fields
    $billing_order = array(
        'billing_last_name',
        'billing_first_name',
        'billing_email',
        'billing_city',
        'billing_address_1',
        'billing_postcode',
        'billing_state',
        'billing_phone',
        'cc_phone_number',
        'billing_country'
    );

    $count = 0;
    $priority = 10;

    // Updating the 'priority' argument
    foreach($billing_order as $field_name){
        $count++;
        $fields['billing'][$field_name]['priority'] = $count * $priority;
    }

    ## ---- 2. CHANGING SOME CLASSES FOR BILLING FIELDS ---- ##

    $fields['billing']['billing_first_name']['class'] = array('form-row-first');
    $fields['billing']['billing_last_name']['class'] = array('form-row-last');
    $fields['billing']['billing_country']['class'] = array('form-row-first');
    $fields['billing']['billing_phone']['class'] = array('form-row-last');
    $fields['billing']['billing_address_1']['class'] = array('form-row-first');
    $fields['billing']['billing_city']['class'] = array('form-row-last');
    $fields['billing']['billing_state']['class'] = array('form-row-first');
    $fields['billing']['billing_postcode']['class'] = array('form-row-last');

    ## ---- RETURN THE BILLING FIELDS CUSTOMIZED ---- ##

    return $fields;
}

// REORDERING CHECKOUT BILLING FIELDS (WOOCOMMERCE 3+)
add_filter( "woocommerce_checkout_fields", "reordering_shipping_billing_fields", 15, 1 );
function reordering_shipping_billing_fields( $fields ) {

    ## ---- 1. REORDERING BILLING FIELDS ---- ##

    // Set the order of the fields
    $shipping_order = array(
        // 'shipping_last_name',
        // 'shipping_first_name',
        // 'shipping_email',
        'shipping_city',
        'shipping_address_1',
        'shipping_postcode',
        'shipping_state',
        'shipping_country',
        // 'shipping_phone'
    );

    $count = 0;
    $priority = 10;

    // Updating the 'priority' argument
    foreach($shipping_order as $field_name){
        $count++;
        // $fields['shipping'][$field_name]['priority'] = $count * $priority;
    }

    ## ---- 2. CHANGING SOME CLASSES FOR shipping FIELDS ---- ##

    $fields['shipping']['shipping_country']['class'] = array('form-row-wide');
    $fields['shipping']['shipping_address_1']['class'] = array('form-row-first');
    $fields['shipping']['shipping_city']['class'] = array('form-row-last');
    $fields['shipping']['shipping_state']['class'] = array('form-row-first');
    $fields['shipping']['shipping_postcode']['class'] = array('form-row-last');

    ## ---- RETURN THE shipping FIELDS CUSTOMIZED ---- ##

    return $fields;
}


/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;

    ob_start();

    ?>
    <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    $fragments['a.cart-customlocation'] = ob_get_clean();
    return $fragments;
}

// add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
//  function custom_remove_woo_checkout_fields( $fields ) {

//     // remove shipping fields 
//     unset($fields['shipping']['state_shipping']);
    
//     return $fields;
// }
/**
 * Generate breadcrumbs
 */
function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">'.__('Home','html5blank').'</a>';
    if (is_category() || is_single()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp; ".__('Search Results for...','html5blank');
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}
function wpml_comp_2347( $data ){
	if ( did_action( 'wpml_loaded' ) ) {
		$home_url = $data['home_url'];
		if ( substr( $data['url'], 0, strlen( $home_url ) ) != $home_url ) {
			$data['home_url'] = get_option( 'home' );
		}
	}

	return $data;
}
add_filter( 'w3tc_url_to_docroot_filename', 'wpml_comp_2347', 20 );
add_filter('woocommerce_currency_symbols','tomoori_change_symbols',10,2);
function tomoori_change_symbols($symbols){
    if(function_exists('icl_get_languages')){
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            $choosed_language = null;
            foreach($languages as $lang){
                if( $lang['active'] == 1 ) {
                    $choosed_language = $lang;
                }
            }
        }
        if(isset($symbols['SAR'])&&isset($choosed_language['code'])&&$choosed_language['code']=="en")$symbols['SAR']="SAR";
    }
    return $symbols;
}
add_action( 'woocommerce_product_query', 'react2wp_hide_products_higher_than_zero' );
function react2wp_hide_products_higher_than_zero( $q ){
   $meta_query = $q->get( 'meta_query' );
   $meta_query[] = array(
      'key'       => '_price',
      'value'     => 0,
      'compare'   => '!='
   );
   $q->set( 'meta_query', $meta_query );
}