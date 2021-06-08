<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package RenMab
 */


/** 
 * WP Cron - Refresh KO Library daily.
 */

function ko_cron_interval( $schedules ) {
 
    $schedules['every_five_minutes'] = array(
        'interval'  => 300,
        'display'   => __( 'Every 5 Minutes', 'textdomain' )
    );
     
    return $schedules;
}
add_filter( 'cron_schedules', 'ko_cron_interval' );

function ko_cron_deactivate() {
    wp_clear_scheduled_hook( 'ko_cron' );
}
 
add_action('init', function() {
    add_action( 'ko_cron', 'ko_cron_run' );
    register_deactivation_hook( __FILE__, 'ko_cron_deactivate' );
 
    if (! wp_next_scheduled ( 'ko_cron' )) {
        wp_schedule_event( time(), 'every_five_minutes', 'ko_cron' );
    }
});
 
function ko_cron_run() {
    $refresh_url = ABSPATH . 'refresh_ko_data.php';
    if( file_exists($refresh_url) ) {
        include( $refresh_url );
    }
}

/**
 * Change post language
 */
function renmab_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News & Blog';
    $submenu['edit.php'][5][0] = 'News & Blog';
    $submenu['edit.php'][10][0] = 'Add Article';
}
function renmab_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News & Blog';
    $labels->singular_name = 'Article';
    $labels->add_new = 'Add Article';
    $labels->add_new_item = 'Add Article';
    $labels->edit_item = 'Edit Article';
    $labels->new_item = 'Article';
    $labels->view_item = 'View Articles';
    $labels->search_items = 'Search Articles';
    $labels->not_found = 'No Articles found';
    $labels->not_found_in_trash = 'No Articles found in Trash';
    $labels->all_items = 'All Articles';
    $labels->menu_name = 'News & Blog';
    $labels->name_admin_bar = 'News & Blog';
}
add_action( 'admin_menu', 'renmab_change_post_label' );
add_action( 'init', 'renmab_change_post_object' );

/**
 * WYSIWYG for knockout basic info -- allows superscript and italic text
 */
add_filter( 'acf/fields/wysiwyg/toolbars' , 'renmab_pi_info_toolbars'  );
add_action('acf/input/admin_head', 'renmab_pi_info_height');

function renmab_pi_info_toolbars( $toolbars )
{
    $toolbars['Superscript & Italic Only' ] = array();
    $toolbars['Superscript & Italic Only' ][1] = array('superscript' , 'italic');

    $toolbars['Data Card' ] = array();
    $toolbars['Data Card' ][1] = array('superscript' , 'italic', 'underline', 'bold', 'underline', 'bullist', 'numlist');

    return $toolbars;
}

function renmab_pi_info_height() { ?>
    <style type="text/css">
        .acf-field-5e7117d9e2f44,
        .acf-field-5e71182fe2f4a {
            height: 170px !important;
            min-height: 170px !important;
        }

        .acf-field-5e71182fe2f4a iframe {
            height: 70px !important;
            min-height: 70px !important;
        }

        .acf-field-5e7117d9e2f44 iframe {
            height: 70px !important;
            min-height: 70px !important;
        }

        .acf-field-5e7117d9e2f44 .mce-statusbar,
        .acf-field-5e71182fe2f4a .mce-statusbar {
            display: none;
        }

    </style>
<?php       
}

/**
 * Order Events Archive by date 
 */

function renmab_events_pre_get_posts( $query ) {
    if( is_admin() ) {
        return $query;
    }
    if( $query->query['post_type'] == 'events' && is_post_type_archive('events') ) {
        $query->set('meta_key', 'event_date_time_event_date');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
        $query->set('meta_query', array( 
            array (
                    'key' => 'event_date_time_event_date',
                    'value' => date('Ymd'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            )
        );
    }
    return $query;
}
add_action('pre_get_posts', 'renmab_events_pre_get_posts');

/**
 * Excerpts
 */
function renmab_excerpt_length( $length ) { return 40; }
add_filter( 'excerpt_length', 'renmab_excerpt_length', 999 );
function renmab_excerpt_more( $more ) { return '...'; }
add_filter('excerpt_more', 'renmab_excerpt_more');


/**
 * Post Filtering Ajax functions
**/
function renmab_filters_controls() {
    if(is_post_type_archive('resources')) {
        $cats = get_terms('resource-types');
        $ph = "Search Resource Library";
    } else {
        $cats = get_categories();
        $ph = "Search Articles";
    }
    $output = '<div id="filter"><div class="wrapper">';
        $output .= '<button type="button" id="filter-toggle" onclick="toggleSection(this.id);" class="tag-bubble tag-reverse"><span class="bubble bubble-small icon-plus"></span>Filter</button>';
        $output .= '<div id="filter-content"><form class="flex-parent"><div class="checkboxes">';
            for ($x = 0; $x < sizeof($cats); $x++) {
                $cat_name = $cats[$x]->name;
                $cat_id = $cats[$x]->term_id;
                $output .= '<div class="checkbox">';
                    $output .= '<input type="checkbox" id="' . $cat_id . '"/>';
                    $output .= '<label for="' . $cat_id . '">' . $cat_name . '</label>';
                $output .= '</div>';
            }
            $output .= '</div><div class="search"><input role="search" type="text" placeholder="'.$ph.'"><button type="button" class="searchsubmit" title="Submit Search"><span class="screen-reader-text">Submit Search</span><span class="icon-search"></span></button></div>';
        $output .= '</form></div>';
    $output .= '</div></div>';
    return $output;
}

function renmab_load_more() {
    $type = get_queried_object()->name;
    if( empty($type) ) {
        $type = "post";
    }
    $posts = wp_count_posts($type);
    $total = $posts->publish;

    global $wp_query;
    $count = $wp_query->found_posts;

    $excl = $total - $count;

    echo '<div class="wrapper load-buttons">';
        echo '<button id="load" data-total="'.$count.'" data-type="'.$type.'" type="button">Load More '.$type.'</button>';
            if ($type == 'events') {
                echo '<button id="past" class="button-secondary" data-total="'.$excl.'" type="button">Past '.$type.'<span class="icon-rarr"></span>'.$not.'</button>';
            }
    echo '</div>';
}

add_action('wp_ajax_renmab_ajax_get_filter_posts', 'renmab_ajax_get_filter_posts');
add_action('wp_ajax_nopriv_renmab_ajax_get_filter_posts', 'renmab_ajax_get_filter_posts');
function renmab_ajax_get_filter_posts(){
    header("Content-Type: text/html");
    $type = $_POST['type'];
    $tax = $type == 'resources' ? 'resource-types' : 'category';
    $ppp = $_POST['posts'];
    $mod = $_POST['mod'];
    $args = array(
        'post_type'      => $type,
        'posts_per_page' => $ppp,
    );
    if( $type == 'events') {
        $args['meta_key'] ='event_date_time_event_date';
        $args['orderby'] ='meta_value';
        $args['order'] ='ASC';
        
        if ( $mod == 'past') {
            $args['meta_query'] = array( 
                array (
                    'key' => 'event_date_time_event_date',
                    'value' => date('Ymd'),
                    'compare' => '<',
                    'type' => 'DATE'
                )
            );
        } else {
            $args['meta_query'] = array( 
                array (
                    'key' => 'event_date_time_event_date',
                    'value' => date('Ymd'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            ); 
        }
    } else {
        $cats = $_POST['categories'];
        $catsArr = explode( ',', $cats );
        if( $cats ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax,
                    'field'    => 'id',
                    'terms'    => $catsArr
                )
            );
        } 
        
        $search = urldecode($_POST['search']);

        if (isset($search) && strlen($search) > 0) {
            $args['s'] = $search;
        }
    }
    global $wp_query;
    $query = new WP_Query( $args );
    $count = $query->found_posts;

    if( $query->have_posts() ) :
        echo "<div class='filtered-posts' data-filtered='".$count."'>";
            if (isset($search) && strlen($search) > 0) {
                echo '<pre class="lead searchresults">Search results for <span class="searchquery">"'.$search.'"</span><button id="searchclear" aria-label="Clear Search" title="Clear Search"><span class="bubble icon-close"></span></button></pre>';
            }
            while( $query->have_posts() ): $query->the_post();
                get_template_part( 'template-parts/content', $type );
            endwhile;
        echo "</div>";
    elseif (isset($search) && strlen($search) > 0) :
        echo '<pre class="lead searchresults">Nothing found for <span class="searchquery"> "'.$search.'"</span><button id="searchclear" aria-label="Clear Search" title="Clear Search"><span class="bubble icon-close"></span></button></p>';
    endif;
    die();
}

add_action('wp_ajax_renmab_ajax_pi_filter_args', 'renmab_ajax_pi_filter_args');
add_action('wp_ajax_nopriv_renmab_ajax_pi_filter_args', 'renmab_ajax_pi_filter_args');
function renmab_ajax_pi_filter_args() {
    $args = array(
        'post_type'      => 'pi-knockouts',
        'meta_key'       => $_POST['order-by'],
        'orderby'        => 'meta_value_num',
        'order'          => $_POST['order'],
        'tax_query'      => array(
            array(
                'taxonomy' => 'pi-cats',
                'field'    => 'slug',
            )
        )
    );
    
    $search = urldecode($_POST['search']);
    if (isset($search) && strlen($search) > 0) {
        $args['s'] = $search;
    }
    
    $model = $_POST['model'] != '' ? $_POST['model'] : 'all';

    
    if ((isset($search) && strlen($search) > 0) || $model !== 'all') {
        $args['posts_per_page'] = -1; 
    } else {
        $args['posts_per_page'] = 10;
    }

    if( $model !== 'all') {
        $args['tax_query'][0]['terms'] = $model;
        renmab_pi_load_kos($args);
    } else {
        $catsArr = get_terms( array(
            'taxonomy'   => 'pi-cats',
        ) );

        foreach ($catsArr as $cat) : 
            $args['tax_query'][0]['terms'] = $cat->slug;
            renmab_pi_load_kos($args);
        endforeach;
    } 
}

function renmab_pi_load_kos($args) {
    $items = new WP_Query($args);
    $cat = $items->get_queried_object();
    $total = $items->found_posts;
    $shown = $items->post_count;

    if ($items->have_posts()) : ?>

        <li class="pi-model">
            <h2 class="h3"><?= $cat->name ?></h2>

            <ul class="table-header accent accent-small table-row">
                <li>Target Name</li>
                <li class="pi-model-mouse pi-model-mouse--header">
                    <div>
                        <div class="pi-model-mouse--label table-row">
                            mouse models
                        </div>
                        <ul class="pi-model-mouse table-row">
                            <li>RenMab&trade;</li>
                            <li>RenLite&trade;</li>
                            <li>RenNano&trade;</li>
                        </ul>
                    </div>
                </li>
                <li>Launched Drugs</li>
            </ul>

            <?php while ( $items->have_posts() ) :
                $items->the_post();
                $private = get_field('pi_private');
                $phase_renmab   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renmab');
                $phase_renlite   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renlite');
                $phase_rennano   = $private ? 'Exclusive Partnership' : get_field('pi_phase_rennano');
                $drugs   = get_field('pi_drugs_launched'); ?>
                <a href="<?= get_the_permalink() ?>" class="pi-title">
                    <div href="<?= get_the_permalink() ?>" class="table-row">
                        <h3 class="h6"><?= get_the_title() ?></h3>
                        <div class="pi-model-mouse table-row">
                            <div class="renmab <?= sanitize_title_for_query($phase_renmab) ?>"></div>
                            <div class="renlite <?= sanitize_title_for_query($phase_renlite) ?>"></div>
                            <div class="rennano <?= sanitize_title_for_query($phase_rennano) ?>"></div>
                        </div>
                        <p><?= $drugs ?></p>
                     </div>
                 </a>
               
            <?php endwhile;
            
            wp_reset_postdata(); 
            if( $total > $shown ) :
                echo '<button class="loader" data-model="'.$cat->slug.'">All '.$cat->name.'</button>';
            endif;
            ?>
        </li>

    <?php endif; 
}

/**
 * Connect to Pharmacodia API 
 */
function renmab_pharmacodia_get_data($id) {
    $post = get_post($id);
    $title = $post->post_name;
    $pi_id = get_field("pi_id", $post->ID);
    
    $upload_dir = wp_upload_dir();
    $path = $upload_dir['basedir'].'/ko-json-cache/'.$title.'_'.$pi_id.'.json';
    $knockouts_data = '';

    if( file_exists( $path ) ) {
        $knockouts_data = file_get_contents( $path );
    } else {
        $knockouts_data = file_get_contents( $upload_dir['basedir'].'/ko-json-cache/empty_data.json' );
    }

    return json_decode($knockouts_data, true);
}

function renmab_pi_stats($key, $value) {
    $args = array(
        'post_type'   => 'pi-knockouts',
        'meta_query' => array(
            array(
                'key'   => $key,
                'value' => $value,
            )
        )
    );
    return new WP_Query($args);
} 

/**
 * Modifications to WP Admin
 */
add_action( 'admin_menu', 'remove_admin_menus' );
add_action('init', 'remove_comment_support', 100);
add_action( 'wp_before_admin_bar_render', 'renmab_admin_bar_render' );

function remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}

function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}

function renmab_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}

add_theme_support( 'editor-color-palette', array(
    array(
        'name'  => __( 'Orange', 'renmab' ),
        'slug'  => 'orange',
        'color' => '#F9865D',
    ),
    array(
        'name'  => __( 'Lime', 'renmab' ),
        'slug'  => 'lime',
        'color' => '#A1C439',
    ),
) );

add_theme_support( 'disable-custom-colors' );
add_theme_support( 'editor-gradient-presets', array() );
add_theme_support( 'disable-custom-gradients' );
add_theme_support( 'disable-custom-font-sizes' );

/**
 * Footer
**/
if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'name' => 'Footer Column 1',
    'id' => 'footer_1',
    'before_widget' => '<div class = "widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="accent">',
    'after_title' => '</h4>',
  ) );

  register_sidebar(array(
    'name' => 'Footer Column 2',
    'id' => 'footer_2',
    'before_widget' => '<div class = "widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="accent">',
    'after_title' => '</h4>',
  ) );
    register_sidebar(array(
        'name' => 'Footer Column 3',
        'id' => 'footer_3',
        'before_widget' => '<div class = "widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="screen-reader-text">',
        'after_title' => '</h3>',
      ) );
}

/**
 * SVG Upload support
 **/
function renmab_svgs_disable_real_mime_check( $data, $file, $filename, $mimes ) {
   $wp_filetype = wp_check_filetype( $filename, $mimes );
   $ext = $wp_filetype['ext'];
   $type = $wp_filetype['type'];
   $proper_filename = $data['proper_filename'];
   return compact( 'ext', 'type', 'proper_filename' );
}
add_filter( 'wp_check_filetype_and_ext', 'renmab_svgs_disable_real_mime_check', 10, 4 );
function cc_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function renmab_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    return $classes;
}
add_filter( 'body_class', 'renmab_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function renmab_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'renmab_pingback_header' );


function renmab_ajax_pi_query() {
    $args = array (
        'post-type' => 'pi-knockouts',
        'meta_key' => 'pi_drugs_launched',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_query' => array(

        )
    );
        $items = new WP_Query($args);

}



/**
 * Search & Filter phase work-around
 */


function phase_redirect() {

	if(isset($_GET['_sfm_token_mouse_model']) && isset($_GET['_sfm_token_pi_phase'])){
    		$mouse_param = $_GET['_sfm_token_mouse_model'];
				$phase_param = $_GET['_sfm_token_pi_phase'];
		}
	elseif (isset($_GET['_sfm_token_mouse_model']) && !isset($_GET['_sfm_token_pi_phase'])) {
				$mouse_param = $_GET['_sfm_token_mouse_model'];
				$phase_param = 'all';
	}
	elseif (!isset($_GET['_sfm_token_mouse_model']) && isset($_GET['_sfm_token_pi_phase'])) {
				$mouse_param = 'all';
				$phase_param = $_GET['_sfm_token_pi_phase'];
	}
	else{ 
				$mouse_param = 'all';
				$phase_param = 'all';
		}
	
	if (strpos($mouse_param, 'renmab') !== false && $phase_param == 'all') {
		?>
			<script type="text/javascript">
				const url1 = new URL(window.location.href);
					url1.searchParams.set('_sfm_pi_phase_renmab', '1a-,-1b-,-1c-,-2a-,-2b-,-3a-,-3b-,-4');
					window.history.replaceState(null, null, url1); // or pushState
				
			</script>
		<?php
	}
	elseif (strpos($mouse_param, 'renmab') !== true && $phase_param == 'all') {
		?>
			<script type="text/javascript">
				const url1 = new URL(window.location.href);
					url1.searchParams.delete('_sfm_pi_phase_renmab', '1a-,-1b-,-1c-,-2a-,-2b-,-3a-,-3b-,-4');
					window.history.replaceState(null, null, url1); // or pushState
			</script>
		<?php
	}
	
	if (strpos($mouse_param, 'rennano') !== false && $phase_param == 'all') {
		?>
			<script type="text/javascript">
				const url2 = new URL(window.location.href);
					url2.searchParams.set('_sfm_pi_phase_rennano', '1a-,-1b-,-1c-,-2a-,-2b-,-3a-,-3b-,-4');
					window.history.replaceState(null, null, url2); // or pushState
			</script>
		<?php
	}
	elseif (strpos($mouse_param, 'rennano') !== true && $phase_param == 'all') {
		?>
			<script type="text/javascript">
				const url2 = new URL(window.location.href);
					url2.searchParams.delete('_sfm_pi_phase_rennano', '1a-,-1b-,-1c-,-2a-,-2b-,-3a-,-3b-,-4');
					window.history.replaceState(null, null, url2); // or pushState
			</script>
		<?php
	}
	
	if (strpos($mouse_param, 'renlite') !== false && $phase_param == 'all') {
		?>
			<script type="text/javascript">
				const url3 = new URL(window.location.href);
					url3.searchParams.set('_sfm_pi_phase_renlite', '1a-,-1b-,-1c-,-2a-,-2b-,-3a-,-3b-,-4');
					window.history.replaceState(null, null, url3); // or pushState
			</script>
		<?php
	}
	elseif (strpos($mouse_param, 'renlite') !== true && $phase_param == 'all') {
		?>
			<script type="text/javascript">
				const url3 = new URL(window.location.href);
					url3.searchParams.delete('_sfm_pi_phase_renlite', '1a-,-1b-,-1c-,-2a-,-2b-,-3a-,-3b-,-4');
					window.history.replaceState(null, null, url3); // or pushState
			</script>
		<?php
	}
	
	
	if (strpos($mouse_param, 'rennano') !== false && $phase_param !== 'all') {
		
		?>
			<script type="text/javascript">
				const url4 = new URL(window.location.href);
					url4.searchParams.set('_sfm_pi_phase_rennano', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url4); // or pushState
			</script>
		<?php
	}
	elseif (strpos($mouse_param, 'rennano') !== true && $phase_param !== 'all') {
		?>
			<script type="text/javascript">
				const url4 = new URL(window.location.href);
					url4.searchParams.delete('_sfm_pi_phase_rennano', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url4); // or pushState
			</script>
		<?php
	}
	
	if (strpos($mouse_param, 'renlite') !== false && $phase_param !== 'all') {
		?>
			<script type="text/javascript">
				const url5 = new URL(window.location.href);
					url5.searchParams.set('_sfm_pi_phase_renlite', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url5); // or pushState
			</script>
		<?php
	}
	elseif (strpos($mouse_param, 'renlite') !== true && $phase_param !== 'all') {
		?>
			<script type="text/javascript">
				const url5 = new URL(window.location.href);
					url5.searchParams.delete('_sfm_pi_phase_renlite', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url5); // or pushState
			</script>
		<?php
	}
	
	if (strpos($mouse_param, 'renmab') !== false && $phase_param !== 'all') {

		?>
			<script type="text/javascript">
				const url6 = new URL(window.location.href);
					url6.searchParams.set('_sfm_pi_phase_renmab', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url6); // or pushState
			</script>
		<?php
	}
	elseif (strpos($mouse_param, 'renmab') !== true && $phase_param !== 'all') {
		?>
			<script type="text/javascript">
				const url6 = new URL(window.location.href);
					url6.searchParams.delete('_sfm_pi_phase_renmab', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url6); // or pushState
			</script>
		<?php
	}
	
	
	if ($mouse_param == 'all' && $phase_param !== 'all') {

		?>
			<script type="text/javascript">
				const url = new URL(window.location.href);
					url.searchParams.set('_sfm_pi_phase_renmab', '<?php echo $phase_param ?>');
					url.searchParams.set('_sfm_pi_phase_renlite', '<?php echo $phase_param ?>');
					url.searchParams.set('_sfm_pi_phase_rennano', '<?php echo $phase_param ?>');
					window.history.replaceState(null, null, url); // or pushState
				
				
			</script>
		<?php
	}
	
	$ko_base_url = get_site_url().'/ko-library/';
	$ko_base_url2 = get_site_url().'/ko-library/?search=';
	$ko_base_url3 = get_site_url().'/ko-library/?search';
	
	?>

<script type="text/javascript">
	var str = '<?php echo $ko_base_url ?>';
	var str2 = '<?php echo $ko_base_url2 ?>';
	var str3 = '<?php echo $ko_base_url2 ?>';
	var urlp = window.location.href;
	
	if (window.location.href.indexOf("&search") > -1 || str === urlp || str2 === urlp || str3 === urlp) {
   
	}	
	else {window.location.href += "&search";}
	
	if (str === urlp) {
		window.location.href += "?search";
	}
	</script>

<?php
		
}