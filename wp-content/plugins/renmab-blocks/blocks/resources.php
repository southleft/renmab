<?php
/**
 * Block Name: Featured Resources
 *
 */

echo '<section class="feat-items feat-resources resources bg-blue">';
	echo '<div class="wrapper flex-parent">';
	echo '<div class="section-header">';
		echo '<h2>RenMab Resources</h2>';
		echo '<a class="tag-bubble accent-large" href="/resources/">Resource Library<span class="icon-rarr bubble"></span></a>';
	echo '</div>';
		$primary = get_field('feat_primary');
		$secondary = get_field('feat_secondary');
		global $post;

		if( $primary ) {
			echo '<div class="flex-half feat-primary">';
				$post = $primary;
				setup_postdata($post);
	        	$terms = get_the_terms($post->ID, 'resource-types');
				$term_name = strtolower( $terms[0]->name );
				echo '<div class="feat-img">';
    				renmab_post_thumbnail('resource-thumb');
    			echo '</div>';
            	echo '<div class="feat-content">';
			    	renmab_resource_tagger('text');
			    	echo '<h3 class="h4">'.get_the_title().'</h3>';
			    	if ($term_name == 'webinar') :
						echo '<a href="'.get_the_permalink().'" class="button button-'.$term_name.'">Watch Now<span class="icon-play"></span></a>';
					else:
						echo '<a href="'.get_the_permalink().'" class="button button-'.$term_name.'">Download<span class="icon-download"></span></a>';
					endif;
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
	            		renmab_resource_tagger('text');
				    	echo '<h4 class="h6">'.get_the_title().'</h4>';	        		
	        		echo '</div>';
	        	echo '</a>';
	        	wp_reset_postdata();
    		endforeach;
    		echo '</div>';
		}
	echo '</div>';
echo '</section>';