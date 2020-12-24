<?php
/*
  Developed by: Primer Co
  URL: http://byprimer.co
*/


// we're firing all out initial functions at the start
add_action('after_setup_theme','primer_ahoy', 15);

function primer_ahoy() {

    // launching operation cleanup
    add_action('init', 'primer_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'primer_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'primer_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'primer_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'primer_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'primer_scripts_and_styles', 999);
    // ie conditional wrapper
    add_filter( 'style_loader_tag', 'primer_ie_conditional', 10, 2 );

    // launching this stuff after theme setup
    add_action('after_setup_theme','primer_theme_support', 20);
    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'primer_register_sidebars' );
    // adding the primer search form (created in functions.php)
    add_filter( 'get_search_form', 'primer_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'primer_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'primer_excerpt_more');

}


/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function primer_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'primer_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'primer_remove_wp_ver_css_js', 9999 );

} /* end primer head cleanup */


// remove WP version from RSS
function primer_rss_version() { return ''; }

// remove WP version from scripts
function primer_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function primer_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function primer_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function primer_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function primer_scripts_and_styles() {
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'primer-modernizr', get_stylesheet_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );
    
    // aos js
    wp_register_script( 'aos-js', get_stylesheet_directory_uri() . '/library/js/libs/aos.js', array(), '', false );

    // aos stylesheet
    wp_register_style( 'aos-stylesheet', get_stylesheet_directory_uri() . '/library/css/aos.css', array(), '', 'all' );
    
    // register main stylesheet
    wp_register_style( 'primer-stylesheet', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );
    
    // responsive stylesheet
    wp_register_style( 'responsive-stylesheet', get_stylesheet_directory_uri() . '/library/css/responsive.css', array(), '', 'all' );

    // ie-only style sheet
    wp_register_style( 'primer-ie-only', get_stylesheet_directory_uri() . '/library/css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'primer-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

    // enqueue styles and scripts
    wp_enqueue_style( 'aos-stylesheet' );
    wp_enqueue_style( 'primer-stylesheet' );
    wp_enqueue_style( 'responsive-stylesheet' );
    wp_enqueue_style( 'primer-ie-only');

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'primer-modernizr' );
    wp_enqueue_script( 'primer-js' );

  }
}

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
function primer_ie_conditional( $tag, $handle ) {
	if ( 'primer-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function primer_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');
	
	// woocommerce theme support
	add_theme_support( 'woocommerce' );

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',  // background image default
	    'default-color' => '', // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'primertheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'primertheme' ) // secondary nav in footer
		)
	);
} /* end primer theme support */


/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function primer_main_nav() {
	
    wp_nav_menu(array(
    	'container_id' => 'primary-menu',
    	'menu' => __( 'The Main Menu', 'primertheme' ),
    	'theme_location' => 'main-nav',
    	'container'      => false,
    	'depth'          => 2,
    	'menu_class'     => 'navbar-nav ml-auto mt-0 align-items-lg-center',
    	'walker' => new Bootstrap_NavWalker(),
    	'fallback_cb'    => 'Bootstrap_NavWalker::fallback',
	));
	
} /* end primer main nav */

// the footer menu (should you choose to use one)
function primer_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => '',                              // remove nav container
    	'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    	'menu' => __( 'Footer Links', 'primertheme' ),   // nav name
    	'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
	));
} /* end primer footer link */

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using primer_related_posts(); )
function primer_related_posts() {
	echo '<ul id="primer-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; }
	    else { ?>
            <?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'primertheme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end primer related posts function */

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function primer_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="primer_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'primertheme' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'primertheme' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function primer_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function primer_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function primer_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

?>
