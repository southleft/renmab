<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RenMab
 */
if(get_field('subfooter_cta')) {
	$type = get_field('subfooter_cta');
} else {
	$type = 'partnership';
}

if ($type == 'partnership') {
	$href = "/contact?ref=partnership#wpcf7-f1048-p98-o1";
	$label = "Apply Now";
	$heading = "Interested in a partnership?";
} else if($type == 'page') {
	$heading = get_field('subfooter_heading');
	$href = get_field('subfooter_btn')['url'];
	$label = get_field('subfooter_btn')['title'];
}
?>

	</div><!-- #content -->
	<svg class="footer-clip">
	  <clipPath id="wave" clipPathUnits="objectBoundingBox"><path d="M0,0.045 C0.143,-0.015,0.305,-0.015,0.485,0.045 C0.666,0.106,0.837,0.094,1,0.008 L1,1 L0,1 L0,0.045"></path></clipPath>
	</svg>
	<footer class="site-footer">

		<div class="wrapper flex-parent">
			<div class="licensing-footer">
				<h2><?= $heading ?></h2>
				<a class="button button-white" href=<?= $href ?> ><?= $label ?></a>
			</div>
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
