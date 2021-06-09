<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RenMab
 */

?>

	</div><!-- #content -->
	<svg class="footer-clip">
	  <clipPath id="wave" clipPathUnits="objectBoundingBox"><path d="M0,0.045 C0.143,-0.015,0.305,-0.015,0.485,0.045 C0.666,0.106,0.837,0.094,1,0.008 L1,1 L0,1 L0,0.045"></path></clipPath>
	</svg>
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
