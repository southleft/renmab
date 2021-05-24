<?php
/**
 * Template Name: KO Library Lander
 *
 * @package RenMab
 */

get_header();
?>
	<main id="main" class="site-main">
	<?php
	
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content-pi-lander', 'page' );
		?>
	<?php 
	endwhile; // End of the loop.
	?>

	</main><!-- #main -->

<?php
get_footer();
