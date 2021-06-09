<?php
/**
 * Block Name: CTA Card
 *
 */
$image = get_field('cta_card_image');
$title = get_field('cta_card_title');
$text = get_field('cta_card_text');
$btn = get_field('cta_card_link'); ?>

<div class="cta-card has-white-background-color wrapper flex-parent">
    <?php renmab_sphere('orange'); ?>
    <?php renmab_sphere('green'); ?>
	
	<?php if ($image) {
		echo '<div class="cta-image"><img src="'.$image.'" /></div>';
	} ?>
	<div class="cta-content flex-parent">
		<?php
		if ($title) {
			echo '<h3>'.$title.'</h3>';
		}	
		if ($text) {
			echo '<p class="lead-small">'.$text.'</p>';
		}	

		if ($btn) {
			echo '<a class="button" href="'.$btn['url'].'">'.$btn['title'].'<span class="icon icon-rarr"></span></a>';
		} ?>
	</div>
</div>