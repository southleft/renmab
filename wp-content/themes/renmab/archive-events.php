<?php
/**
 * The template for displaying the events archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main has-white-background-color">
		<header class="page-header wrapper">
			<h1 class="h2">Upcoming Events</h1>
		</header>
	<?php 
	if ( have_posts() ) : ?>

		<div class="page-content wrapper"> 
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile; 
			?>
		</div> <!-- .page-content -->
	<?php
	renmab_load_more();
	else : ?>
		<div class="page-content wrapper"> 
		</div>
			<?php renmab_load_more(); 
	endif;
	?>

	</main><!-- #main -->

<?php
get_footer('cta');
