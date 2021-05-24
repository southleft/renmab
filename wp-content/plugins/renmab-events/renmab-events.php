<?php
/*
Plugin Name: RenMab Events
Plugin URI: http://www.icscreative.com/
Description: Creates a custom post type for events.
Version: 1.0.0
Author: Marin Carroll
Author URI: http://www.icscreative.com/
*/

defined( 'ABSPATH' ) or die( 'No, thank you.' );

add_action( 'init', 'renmab_events_init' );

/**
 * Register an event post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function renmab_events_init() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'renmab-events' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'renmab-events' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'renmab-events' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'renmab-events' ),
		'add_new'            => _x( 'Add New', 'event', 'renmab-events' ),
		'add_new_item'       => __( 'Add New Event', 'renmab-events' ),
		'new_item'           => __( 'New Event', 'renmab-events' ),
		'edit_item'          => __( 'Edit Event', 'renmab-events' ),
		'view_item'          => __( 'View Event', 'renmab-events' ),
		'all_items'          => __( 'All Events', 'renmab-events' ),
		'search_items'       => __( 'Search Events', 'renmab-events' ),
		'not_found'          => __( 'No events found.', 'renmab-events' ),
		'not_found_in_trash' => __( 'No events found in Trash.', 'renmab-events' )
	);

	$args = array(
		'labels'             => $labels,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'public'             => true,
		'publicly_queryable' => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'events' ),
		'capability_type'    => 'page',
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title', 'thumbnail', 'revisions' ),
	);

	register_post_type( 'events', $args );
} 