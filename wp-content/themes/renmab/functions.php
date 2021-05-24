<?php
/**
 * RenMab functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RenMab
 */

if ( ! function_exists( 'renmab_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function renmab_setup() {

		load_theme_textdomain( 'renmab', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary Nav', 'renmab' ),
			'menu-2' => esc_html__( 'Secondary Nav', 'renmab' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'renmab_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function renmab_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'renmab_content_width', 640 );
}
add_action( 'after_setup_theme', 'renmab_content_width', 0 );

/**
 * Shortcode for resources download
 */
add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );
 
function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
  $my_attr = 'download';
 
  if ( isset( $atts[$my_attr] ) ) {
    $out[$my_attr] = $atts[$my_attr];
  }
 
  return $out;
}

/**
 * Enqueue scripts and styles.
 */

add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_deregister_style( 'contact-form-7' );
}

function renmab_scripts() {
	wp_enqueue_style( 'renmab-style', get_stylesheet_uri(), array(), '1-15-20' );
	wp_enqueue_script( 'renmab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'renmab-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'renmab-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1-8-20', true );
	if (is_post_type_archive('pi-knockouts')) {
		wp_enqueue_script( 'renmab-pi-archive', get_template_directory_uri() . '/js/pi-archive.js', array('jquery'), '1-15-20', true );
		wp_localize_script( 'renmab-pi-archive', 'renmab_pi_filter', array( 
			'ajax_url' => admin_url( 'admin-ajax.php' ) 
		) );
	}

	if (is_page_template('page-pi-lander.php')) {
		wp_enqueue_script( 'renmab-pi-lander', get_template_directory_uri() . '/js/pi-lander.js', array('jquery'), '20151215', true );
	}

 	if (is_archive() || is_category() || is_home() ) {
		wp_enqueue_script( 'renmab-archive', get_template_directory_uri() . '/js/archive.js', array('jquery'), '20151215', true );
		wp_localize_script( 'renmab-archive', 'renmab_posts_filter', array( 
			'ajax_url' => admin_url( 'admin-ajax.php' ) 
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'renmab_scripts' );

function renmab_gutenberg_scripts() {
	wp_enqueue_script(
		'be-editor', 
		get_stylesheet_directory_uri() . '/js/gutenberg.js', 
		array( 'wp-blocks', 'wp-dom' ), 
		filemtime( get_stylesheet_directory() . '/js/gutenberg.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'renmab_gutenberg_scripts' );

function renmab_admin_scripts(){
    wp_register_style( 'custom_wp_admin_css', get_bloginfo('stylesheet_directory') . '/admin-style.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );

}
add_action('admin_enqueue_scripts', 'renmab_admin_scripts');

function renmab_admin_fonts() { ?>
	<link rel="stylesheet" href="https://use.typekit.net/ywz3mje.css">
<?php 
} 

add_action( 'admin_head' , 'renmab_admin_fonts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Sanitize file names on upload
 */
function sanitize_filename_on_upload($filename) {
  $ext = end(explode('.',$filename));
  $sanitized = preg_replace('/[^a-zA-Z0-9-_.]/','', substr($filename, 0, -(strlen($ext)+1)));
  $sanitized = str_replace('.','-', $sanitized);
  return strtolower($sanitized.'.'.$ext);
}
add_filter('sanitize_file_name', 'sanitize_filename_on_upload', 10);

/*Add descriptions to menu items */
class Menu_With_Description extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = NULL, $id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
         
        $class_names = $value = '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
 
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
 
        $item_output = $args->before;
        $has_children = $args->walker->has_children;
        
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        if($item->description) {
        	$item_output .= '<span class="sub">' . $item->description . '</span>';
    	}
        $item_output .= '</a>';
        $item_output .= $has_children == 1 ? '<button aria-label="Open Submenu" class="icon-plus bubble sub-menu-bttn"></button>' : '';
        $item_output .= $args->after;
 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}



/****************************************/

/* Create custom meta data box to the post edit screen */
function resources_custom_post_sort( $post ){
  add_meta_box(
    'custom_post_sort_box',
    'Update Knockout',
    'add_knockout_button',
    'pi-knockouts' ,
    'side'
  );
}
add_action( 'add_meta_boxes', 'resources_custom_post_sort' );

function add_knockout_button( $post ) { 
	$time = microtime(true);
	$pi_id = get_field( "pi_id", $post->ID );

	if($pi_id != ''){
	?>
		<p><a href="/refresh_ko_data.php?post_id=<?php echo $post->ID ?>&random=<?php echo $time ?>" target="_blank">Update Knockout Data</a></p>
	<?php }else{ ?>
		<p>Please add Pharmacodia ID and update to view the Update Knockout Link</p>
	<?php 
	}
} 