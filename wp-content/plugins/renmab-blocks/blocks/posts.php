<?php
/**
 * Block Name: Featured News & Blog
 *
 */

echo '<section class="feat-items feat-news bg-beige">';
	renmab_sphere('green');
	renmab_sphere('blue');
	echo '<div class="wrapper flex-parent">';
	echo '<div class="section-header">';
		echo '<h2>News & Blog</h2>';
		echo '<a class="tag-bubble accent-large" href="/resources/">All Articles<span class="bubble icon-rarr"></span></a>';
	echo '</div>';
		global $post;
		$primary = get_field('feat_primary');
		$secondary = get_field('feat_secondary');

		if( $primary ) {
			echo '<div class="flex-half feat-primary type-post">';
				$post = $primary;
				setup_postdata($post);

        	
    			echo '<div class="feat-img">';
    				renmab_post_thumbnail('post-feat');
    			echo '</div>';
    			echo '<div class="feat-content">';
    				renmab_cat_tagger();
			    	echo '<h3>'.get_the_title().'</h3>';
			    	the_excerpt();
			    	echo '<a href="'.get_the_permalink().'" class="button">Keep Reading<span class="icon-rarr"></span></a>';
				echo '</div>';
			echo '</div>';
		    wp_reset_postdata();
		}

		if( $secondary ) {
  			echo '<div class="flex-half feat-secondary">';
    		foreach( $secondary as $post ):
        		setup_postdata($post);
        		echo '<a href="'.get_the_permalink().'">';
	        		echo '<div class="feat-content">';
						renmab_cat_tagger();				    	
					   	echo '<h4>'.get_the_title().'</h4>';
	        		echo '</div>';
	        	echo '</a>';
	        	wp_reset_postdata();
    		endforeach;
    		echo '</div>';
		}
	echo '</div>';
echo '</section>';