<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RenMab
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://use.typekit.net/ywz3mje.css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'renmab' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="wrapper flex-parent">
			<div class="site-branding">
				<a href="/">
					<img class="logo light-logo" src="<?php echo esc_url( get_theme_mod( 'renmab_light_logo' ) ); ?>" alt="<?php bloginfo( 'name', 'display' ); ?>">
					<img class="logo dark-logo" src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'custom_logo' ) )); ?>" alt="<?php bloginfo( 'name', 'display' ); ?>">
				</a>
			<?php 
			$renmab_description = get_bloginfo( 'description', 'display' );
			if ( $renmab_description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $renmab_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation flex-parent">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="bubble icon-hamburger"></span>
				</button>
				<?php
				$walker = new Menu_With_Description;
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-nav',
					'walker' => $walker,
				) );

				wp_nav_menu( array(
					'theme_location' => 'menu-2',
					'menu_id'        => 'secondary-nav',
				) );
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .wrapper -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
