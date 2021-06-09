<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main has-white-background-color">
	<?php
	if ( have_posts() ) :

		if ( is_home() && ! is_front_page() ) :
			?>
			<header class="page-header wrapper">
				<h1 class="h2"><?php single_post_title(); ?></h1>
			</header>
			<?php print renmab_filters_controls();
		endif; ?>

		<div class="page-content wrapper"> 
			<?php 
			while ( have_posts() ) :

				the_post();
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile; 

			?>
		</div><!-- .page-content -->

		<?php
		renmab_load_more();
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</main><!-- #main -->

<?php
get_footer('cta');
