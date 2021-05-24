<?php
/*
Plugin Name: Project Integrum
Plugin URI: http://www.icscreative.com/
Description: Creates a custom post type for Project Integrum knockouts.
Version: 1.0.0
Author: Marin Carroll
Author URI: http://www.icscreative.com/
*/

defined( 'ABSPATH' ) or die( 'No, thank you.' );

add_action( 'init', 'renmab_pi_init' );
add_action( 'init', 'add_pi_cats', 0 );

/**
 * Register an event post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function renmab_pi_init() {
	$labels = array(
		'name'               => _x( 'KO Library', 'post type general name', 'renmab-pi-knockouts' ),
		'singular_name'      => _x( 'Knockout', 'post type singular name', 'renmab-pi-knockouts' ),
		'menu_name'          => _x( 'KO Library', 'admin menu', 'renmab-pi-knockouts' ),
		'name_admin_bar'     => _x( 'Knockout', 'add new on admin bar', 'renmab-pi-knockouts' ),
		'add_new'            => _x( 'Add New', 'event', 'renmab-pi-knockouts' ),
		'add_new_item'       => __( 'Add New Knockout', 'renmab-pi-knockouts' ),
		'new_item'           => __( 'New Knockout', 'renmab-pi-knockouts' ),
		'edit_item'          => __( 'Edit Knockout', 'renmab-pi-knockouts' ),
		'view_item'          => __( 'View Knockout', 'renmab-pi-knockouts' ),
		'all_items'          => __( 'All Knockouts', 'renmab-pi-knockouts' ),
		'search_items'       => __( 'Search KO Library', 'renmab-pi-knockouts' ),
		'not_found'          => __( 'No knockouts found.', 'renmab-pi-knockouts' ),
		'not_found_in_trash' => __( 'No knockouts found in Trash.', 'renmab-pi-knockouts' )
	);

	$args = array(
		'labels'             => $labels,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'ko-library' ),
		'capability_type'    => 'page',
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-editor-alignleft',
		'supports'           => array( 'title', 'revisions' ),
	);

	register_post_type( 'pi-knockouts', $args );
} 

function add_pi_cats () {register_taxonomy('pi-cats', 'pi-knockouts', array(
		'hierarchical' => true,
		'labels' => array(
		'name' => _x( 'Therapeutic Areas', 'taxonomy general name' ),
			'singular_name' => _x( 'Therapeutic Area', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Therapeutic Areas' ),
			'all_items' => __( 'All Therapeutic Areas' ),
			'edit_item' => __( 'Edit Therapeutic Area' ),
			'update_item' => __( 'Update Therapeutic Area' ),
			'add_new_item' => __( 'Add New Therapeutic Area' ),
			'new_item_name' => __( 'New Therapeutic Area' ),
			'menu_name' => __( 'Therapeutic Areas' ),
		),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
			'slug' => 'cats',
			'hierarchical' => true 
		),
		'args' => array(
			'public'      => true
		)
 	));
}

if( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'     => 'KO Library Options',
        'menu_title'    => 'KO Library Options',
        'parent_slug'    => 'edit.php?post_type=pi-knockouts',
    ));

}