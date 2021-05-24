<?php
/**
 * The template for displaying Project Integrum Knockouts
 *
 * @package RenMab
 */

get_header();
?>

	<main id="main" class="site-main wrapper">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'pi-knockouts' );

	endwhile; // End of the loop.
	?>

	</main><!-- #main -->

<?php
$title = get_field('pi_footer_title', 'option');
$img = get_field('pi_footer_img', 'option');
$content = get_field('pi_footer_content', 'option'); ?>

<section class="pi-footer bg-beige">
	<h3 class="pi-footer-title wrapper"><?php echo $title ?></h3>
	<div class="wrapper flex-parent">
		<div class="flex-half pi-footer-img">
			<svg width="<?php echo $img['sizes']['medium_large-width'] ?>" height="<?php echo $img['sizes']['medium_large-height'] ?>" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><title><?php echo $img['alt'] ?></title>
	            <image xlink:href="<?php echo $img['url'] ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" />
	            <rect fill="#878DB5" style="mix-blend-mode: color;" width="100%" height="100%"></rect>
	            <rect fill="#CDD3FF" style="mix-blend-mode: multiply;" width="100%" height="100%"></rect>
	        </svg>
		</div>
		<div class="flex-half pi-footer-content">
			<?php echo $content; ?>
		</div> 
	</div>
</section>
<?php
get_footer();
