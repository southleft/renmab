<?php
/*
Plugin Name: RenMab Blocks
Plugin URI: https://www.icscreative.com/
Description: Defines custom ACF block types and settings for RenMab.
Version: 1.0.0
Author: Marin Carroll
Author URI: https://www.icscreative.com/
*/
defined( 'ABSPATH' ) or die( 'No, thank you.' );

add_action('acf/init', 'renmab_register_blocks');

function renmab_register_blocks() {
     if( function_exists('acf_register_block_type') ) {
          acf_register_block_type(array(
            'name'              => 'home-hero',
            'title'             => __('Homepage Hero'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/home-hero.php',
            'icon'              => 'align-left',
            'keywords'          => array('hero','header','image', 'home', 'animation'),
            'enqueue_script'    => get_template_directory_uri() . '/js/hero.js',
        ));
        acf_register_block_type(array(
            'name'              => 'hero',
            'title'             => __('Hero Block'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/hero.php',
            'icon'              => 'align-left',
            'keywords'          => array('hero','header','image'),
        ));
        acf_register_block_type(array(
            'name'              => 'svg',
            'title'             => __('SVG Diagram'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/svg.php',
            'icon'              => 'format-image',
        ));
        acf_register_block_type(array(
            'name'              => 'cta_card',
            'title'             => __('Navy CTA Card'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/cta-card.php',
            'icon'              => 'star-empty',
            'keywords'          => array('cta','navy','card', 'integrum', 'teaser', 'project'),
        ));
        acf_register_block_type(array(
            'name'              => 'multi_step',
            'title'             => __('Multi-Step Panels'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/multi-step.php',
            'icon'              => 'editor-ol',
            'keywords'          => array('steps','panels'),
            'enqueue_script'    => get_template_directory_uri() . '/js/multi-step.js',
        ));
        acf_register_block_type(array(
            'name'              => 'posts',
            'title'             => __('Featured News & Blog'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/posts.php',
            'icon'              => 'admin-page',
            'keywords'          => array('posts','news','blog','articles','press'),
        ));
        acf_register_block_type(array(
            'name'              => 'resources',
            'title'             => __('Featured Resources'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/resources.php',
            'icon'              => 'media-document',
            'keywords'          => array('resources','posts'),
        ));
        acf_register_block_type(array(
            'name'              => 'events',
            'title'             => __('Upcoming Events'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/events.php',
            'icon'              => 'calendar-alt',
            'keywords'          => array('events','posts','calendar'),
        ));

        acf_register_block_type(array(
            'name'              => 'licensing',
            'title'             => __('Licensing CTA'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/licensing.php',
            'icon'              => 'star-filled',
            'keywords'          => array('button', 'contact', 'licensing', 'partner'),
        ));

        acf_register_block_type(array(
            'name'              => 'icon-bullets',
            'title'             => __('Icon Bullet Points'),
            'category'          => 'widgets',
            'render_template'   => plugin_dir_path( __FILE__ ) . 'blocks/icon-bullets.php',
            'icon'              => 'editor-ol',
            'keywords'          => array('icon', 'benefits', 'bullets'),
        ));
    }
}