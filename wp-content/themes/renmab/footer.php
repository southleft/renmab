<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RenMab
 */

?>

	</div><!-- #content -->
	<footer class="site-footer">
		<div class="wrapper flex-parent">
			<div class="footer-col">
				<?php dynamic_sidebar( 'footer_1' ); ?>
			</div>
			<div class="footer-col">
				<?php dynamic_sidebar( 'footer_2' ); ?>
			</div>
			<div class="footer-col">
				<?php dynamic_sidebar( 'footer_3' ); ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
