<?php
/**
 * Template part for displaying resources
 *
 *
 * @package RenMab
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	$terms = get_the_terms($post->ID, 'resource-types');
	$term_name = strtolower( $terms[0]->name );
	$term_link = get_term_link($terms[0], 'resource-types');
	if ( is_singular() ) : ?>
		<div class="resource-header-wrap">
			<header class="single-header">
				<div class="wrapper flex-parent">
					<div class="header-img">
						<?php renmab_post_thumbnail('resource-header'); ?>
					</div>
					<div class="header-content">
						<?php 
					    renmab_resource_tagger('text');

						the_title('<h1 class="h3 entry-title">', '</h1>' );

						$authors = get_field('resource_authors');
						if ($authors) {
							echo '<p class="resource-authors accent">Authors: '.$authors.'</p>';
						}
					?>
					</div>
				</div>
			</div>
		</header><!-- .single-header -->
		<div class="resource-content-wrap has-white-background-color">
			<div class="wrapper flex-parent">
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
				<?php 
				$file = get_field('resource_download');

				if($file) : ?>
					<aside class="single-sidebar intake">
						<h3>Download this <?php echo $term_name ?></h3>
						<?php echo do_shortcode('[contact-form-7 id="1059" title="Resource Download Form" download="'.$file.'"]'); ?>
						<script>
							document.addEventListener( 'wpcf7mailsent', function( event ) {
							  location = '/thank-you/?download=<?php echo get_queried_object()->post_name ?>';
							}, false );
						</script>
					</aside>
				<?php endif; ?>
			</div>
		</div>
	<?php 
	else : ?>
		<div class="archive-img">
			<?php renmab_post_thumbnail('resource-thumb'); ?>
		</div>
		<div class="archive-content has-white-background-color">
			<?php
			renmab_resource_tagger('link');
			the_title( '<h2 class="h4 entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			if ($term_name == 'webinar') :
				echo '<a href="'.get_the_permalink().'" class="button button-'.$term_name.'">Watch '.$term_name.'<span class="icon-play"></span></a>';
			else:
				echo '<a href="'.get_the_permalink().'" class="button button-'.$term_name.'">Download '.$term_name.'<span class="icon-download"></span></a>';
			endif;
			?>
		</div>
	<?php 
	endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->