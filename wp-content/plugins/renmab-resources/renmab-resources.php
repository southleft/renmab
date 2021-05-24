<?php
/*
Plugin Name: RenMab Resources
Plugin URI: http://www.icscreative.com/
Description: Creates a custom post type for resources.
Version: 1.0.0
Author: Marin Carroll
Author URI: http://www.icscreative.com/
*/

defined( 'ABSPATH' ) or die( 'No, thank you.' );

add_action( 'init', 'renmab_resources_init' );
add_action( 'init', 'add_resource_types', 0 );

/**
 * Register an event post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function renmab_resources_init() {
	$labels = array(
		'name'               => _x( 'Resources', 'post type general name', 'renmab-resources' ),
		'singular_name'      => _x( 'Resource', 'post type singular name', 'renmab-resources' ),
		'menu_name'          => _x( 'Resource Library', 'admin menu', 'renmab-resources' ),
		'name_admin_bar'     => _x( 'Resource', 'add new on admin bar', 'renmab-resources' ),
		'add_new'            => _x( 'Add New', 'event', 'renmab-resources' ),
		'add_new_item'       => __( 'Add New Resource', 'renmab-resources' ),
		'new_item'           => __( 'New Resource', 'renmab-resources' ),
		'edit_item'          => __( 'Edit Resource', 'renmab-resources' ),
		'view_item'          => __( 'View Resource', 'renmab-resources' ),
		'all_items'          => __( 'All Resources', 'renmab-resources' ),
		'search_items'       => __( 'Search Resource Library', 'renmab-resources' ),
		'not_found'          => __( 'No resources found.', 'renmab-resources' ),
		'not_found_in_trash' => __( 'No resources found in Trash.', 'renmab-resources' )
	);

	$args = array(
		'labels'             => $labels,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'resources' ),
		'capability_type'    => 'page',
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-media-document',
		'supports'           => array( 'title', 'thumbnail', 'editor', 'revisions' ),
	);

	register_post_type( 'resources', $args );
} 

function add_resource_types () {register_taxonomy('resource-types', 'resources', array(
		'hierarchical' => true,
		'labels' => array(
		'name' => _x( 'Resource Types', 'taxonomy general name' ),
			'singular_name' => _x( 'Resource Type', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Resource Types' ),
			'all_items' => __( 'All Resource Types' ),
			'edit_item' => __( 'Edit Type' ),
			'update_item' => __( 'Update Type' ),
			'add_new_item' => __( 'Add New Resource Type' ),
			'new_item_name' => __( 'New Resource Type' ),
			'menu_name' => __( 'Resource Types' ),
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