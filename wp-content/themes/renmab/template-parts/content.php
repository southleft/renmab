<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( is_singular() ) : ?>
		<header class="single-header flex-parent">
			<div class="header-img">
				<?php renmab_post_thumbnail('post-header'); ?>
			</div>
			<div class="header-content">
				<?php 
				renmab_cat_tagger();
				the_title('<h1 class="h2 entry-title">', '</h1>' );
				?>
			</div><!-- .header-content -->
		</header><!-- .single-header -->

		<div class="single-content">
			<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'renmab' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );
			
			social_share();
			?>
			
		</div><!-- .single-content -->
		<aside class="single-sidebar">
			<?php renmab_licensing_cta('stick'); ?>
		</aside>
	<?php 
	else: ?>
		<div class="archive-img">
			<?php renmab_post_thumbnail('post-thumb'); ?>
		</div>
		<div class="archive-content">
			<?php 
			renmab_cat_tagger();
			the_title( '<h2 class="h3 entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
			the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="tag-bubble accent-large">Keep Reading<span class="bubble icon-rarr"></span></a>
		</div>
	<?php
	endif ?>
</article><!-- #post-<?php the_ID(); ?> -->