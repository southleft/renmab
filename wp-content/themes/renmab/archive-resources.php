<?php
/**
 * The template for displaying the resource archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main has-white-background-color">

	<?php if ( have_posts() ) : ?>

		<header class="page-header wrapper">
			<h1 class="h2">Resource Library</h1>
		</header><!-- .page-header -->

		<?php 
		$args = array(
		  'posts_per_page'  => 1,
		  'post_type'       => 'resources',
		  'meta_key'        => 'resource_feature',
		  'meta_value'      => true
		);

		$feat_query = new WP_Query( $args );

		if ($feat_query->have_posts() ) : 
		 	while ( $feat_query->have_posts() ) : $feat_query->the_post();
	 			$feat_post = get_the_ID(); 
	 			$terms = get_the_terms($feat_post, 'resource-types');
	 			$term_name = strtolower( $terms[0]->name );
				?>
	 			<div class="sticky-resource">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="wrapper flex-parent">
							<div class="header-img">
								<?php renmab_post_thumbnail('resource-header'); ?>
							</div>
							<div class="header-content has-white-background-color">
								<?php 
							    renmab_resource_tagger('text');

								the_title('<h1 class="h3 entry-title">', '</h1>' );

								echo '<a href="'.get_the_permalink().'" class="button button-'.$term_name.'">Download '.$term_name.'<span class="icon-download"></span></a>';
							?>
							</div>
						</div>
					</article>
				</div>
		    <?php
			endwhile;
		endif;
		wp_reset_query();

		print renmab_filters_controls('resource-types'); ?>

		<div class="page-content wrapper"> 
			<?php
			while ( have_posts() ) : the_post();
				//if ( get_the_ID() != $feat_post ) {
					get_template_part( 'template-parts/content', get_post_type() );
				//}
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
