<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( '<h1 class="entry-title screen-reader-text">', '</h1>' ); ?>

	<?php renmab_post_thumbnail(); ?>

	<div class="single-content">
		<?php
		the_content();
		?>
	</div><!-- .single-content -->
</article><!-- #post-<?php the_ID(); ?> -->
