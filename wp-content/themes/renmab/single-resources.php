<?php
/**
 * The template for displaying single resources
 *
 * @package RenMab
 */

get_header();
?>
	<main id="main" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'resources' );

	endwhile; // End of the loop.
	?>

	</main><!-- #main -->

<?php get_footer('cta');
