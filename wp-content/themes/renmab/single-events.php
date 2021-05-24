<?php
/**
 * The template for displaying single events
 *
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main">
		<div class="page-content wrapper"> 

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'events');

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- .page-content -->

<?php 
$sidebar = get_field('sidebar'); 
if($sidebar == 'intake') {
	get_footer('cta'); 
} else {
	get_footer(); 
}