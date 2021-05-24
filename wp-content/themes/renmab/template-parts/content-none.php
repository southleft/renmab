<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

?>

<section class="no-results not-found wrapper">
	<header class="page-header">
		<h1 class="h2"><?php esc_html_e( 'Oops! Nothing Found', 'renmab' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'renmab' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		else :
			?>

			<p class="lead lead-large">Sorry, that page doesn't exist.</p>
			<a href="/" class="button">Go Home<span class="icon-rarr"></span></a>
			<?php
		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
