<?php
/**
 * Block Name: Icon Bullet Points
 */
echo '<section class="bullet-icons"><div class="wrapper">';
	$text = get_field('bullet_points_title');
	if($text) { echo '<h3 class="h4">'.$text.'</h3>'; };

	if( have_rows('bullet_points') ):
		echo '<ul class="flex-parent">';
	    while ( have_rows('bullet_points') ) : the_row();
	        $icon = get_sub_field('bullet_icon');
	       	$title = get_sub_field('bullet_title');
	        $text = get_sub_field('bullet_text');
	    	echo '<li class="flex-parent">';
	    		echo '<img class="bullet-icon" src="'.$icon['url'].'"/>';
	    		echo '<div class="bullet-text">';
	    			echo '<h4 class="accent">'.$title.'</h4>';
	    			echo '<p class="lead-small">'.$text.'</p>';
	    		echo '</div>';
	    	echo '</li>';
	    endwhile;
	    echo '</ul>';
	endif;
echo '</div></section>';
?>