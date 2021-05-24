<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package RenMab
 */

get_header();
?>

<main id="main" class="site-main">
	<section class="error-404 not-found wrapper">
		<header class="page-header">
			<h1 class="h2"><?php esc_html_e( 'Oops! Nothing Found', 'renmab' ); ?></h1>
		</header>
		<p class="lead lead-large">Sorry, that page doesn't exist.</p>
		<a href="/" class="button">Go Home<span class="icon-rarr"></span></a>
	</section>


</main><!-- #main -->

<?php
get_footer();
