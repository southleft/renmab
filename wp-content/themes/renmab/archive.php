<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header wrapper">
				<?php
				the_archive_title( '<h1 class="h2">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			get_sidebar(); ?>
		
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
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
	</main><!-- #main -->

<?php
get_footer('cta');
