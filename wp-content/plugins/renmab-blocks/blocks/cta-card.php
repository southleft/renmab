<?php
/**
 * Block Name: CTA Card
 *
 */
$image = get_field('cta_card_image');
$title = get_field('cta_card_title');
$text = get_field('cta_card_text');
$btn = get_field('cta_card_link');

echo '<div class="cta-card wrapper flex-parent">';
	echo '<div class="spheres-1">';
		renmab_sphere('orange'); 
		renmab_sphere('green'); 
	echo '</div>';

	if ($image) {
		echo '<div class="cta-image"><img src="'.$image.'" /></div>';
	}
	echo '<div class="cta-content flex-parent">';
		if ($title) {
			echo '<h3>'.$title.'</h3>';
		}	
		if ($text) {
			echo '<p class="lead lead-small">'.$text.'</p>';
		}	

		if ($btn) {
			echo '<a class="button button-white" href="'.$btn['url'].'">'.$btn['title'].'<span class="icon icon-rarr"></span></a>';
		}
	echo '</div>';
	echo '<div class="spheres-2">';
		renmab_sphere('orange'); 
		renmab_sphere('green'); 
	echo '</div>';
echo '</div>';