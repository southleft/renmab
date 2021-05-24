<?php
/**
 * The template for displaying the Project Integrum library
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */
get_header();
?>

<main id="main" class="site-main">
	 <?php
	 $cats = get_terms( array(
	    'taxonomy'   => 'pi-cats',
	) ); ?>
	<div class="wrapper">
		<div class="pi-filters">
			<form class="flex-parent">
				<div class="form-container flex-parent">
					<div class="input-group">
						<label for="search-kos">Target Name</label>
						<div class="search">
							<input id="search-kos" role="search" type="text"></input>
						</div>
					</div>
					<div class="input-group">
						<label for="select-kos">Therapeutic Area</label>
						<select id="select-kos">
							<option value="all"></option>
							<?php
							foreach ($cats as $cat) : 
								echo '<option value="'.$cat->slug.'">'.$cat->name.'</option>';
					    	endforeach; ?>
				    	</select>
					</div>
				</div>
			    <div class="button-group">
					<button type="button" class="apply">Search</button>
					<button type="button" class="clear">Clear All</button>
				</div>
			</form>
			<div class="searchresults-wrap"></div>
		</div>
		<div class="pi-loading">
			<div class="pi-loading-wrap">
				<p>Loading</p>
			</div>
		</div>
		<ul class="pi-models">
			<?php renmab_ajax_pi_filter_args(); ?>
		</ul>
	</div>
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

get_footer('cta');