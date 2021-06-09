<?php
/**
 * RenMab Theme Customizer
 *
 * @package RenMab
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function renmab_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'renmab_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'renmab_customize_partial_blogdescription',
		) );
	}
	
    $wp_customize->add_setting('renmab_light_logo', array(
        'transport' => 'refresh',
        'height'    => 79,
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'renmab_light_logo', array(
        'label'       => 'Upload Light Logo',
        'description' => 'Visible on the dark mode page template',
        'section'     => 'title_tagline',
        'settings'    => 'renmab_light_logo',
        'priority'    => 8
    )));
}
add_action( 'customize_register', 'renmab_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function renmab_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function renmab_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function renmab_customize_preview_js() {
	wp_enqueue_script( 'renmab-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'renmab_customize_preview_js' );
