<?php
/**
 * Template Name: Text Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main wrapper">
	<?php
	
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile; // End of the loop.
	?>

	</main><!-- #main -->

<?php
get_footer();
