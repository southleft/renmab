<?php
/**
 * Block Name: Upcoming Events
 *
 */

echo '<section class="feat-events">';
	echo '<div class="wrapper">';
	echo '<div class="section-header">';
		echo '<h2 class="">Upcoming Events</h2>';
		echo '<a class="tag-bubble accent-large" href="/events/">All Events<span class="bubble icon-rarr"></span></a>';
	echo '</div>';
		global $post;
		$primary = get_field('feat_primary');
		$secondary = get_field('feat_secondary');

		if( $primary ) { 
			$post = $primary;
			setup_postdata($post);

			$speech_title = get_field('event_speech_title', $post->ID);

			echo '<div class="feat-event events type-events flex-parent">';
				renmab_sphere('blue');
				renmab_sphere('green');
				echo '<div class="archive-img">';
					renmab_post_thumbnail('event-thumb');
					renmab_speaker_tagger($post);
				echo '</div>';

				echo '<div class="archive-content">';
					echo '<p class="accent">';
						echo renmab_date_write($post);
					echo '</p>';
					the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
					echo '<h3 class="lead">'.$speech_title.'</h3>';
					echo '<div class="location">';
						if ( have_rows('event_location', $post->ID) ) :
							while ( have_rows('event_location', $post->ID) ) : the_row();
								$location = get_sub_field('event_location_name', $post->ID);
								$link = get_sub_field('event_link', $post->ID);

								echo '<p>'.$location.'</p>';
							endwhile;
						endif;
					echo '<a href="'.get_the_permalink().'" class="tag-bubble">Learn More<span class="bubble icon-rarr"></span></a>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}


		if( $secondary ) {
			$sArgs = array(
				'post_type' => array( 'events' ),
				'post__in' => $secondary,
				'orderby'  => 'meta_value',
			 	'meta_key' => 'event_date_time_event_date',
			 	'order'    =>'ASC',
			);
			
			$sObjects = new WP_Query( $sArgs );
			
  			echo '<dl class="timeline flex-parent">';
	  			while ( $sObjects->have_posts() ) {
					$sObjects->the_post();
					$date = renmab_date_write($post);

					$speech_title = get_field('event_speech_title', $post->ID);

					if ( have_rows('event_location', $post->ID) ) :
						while ( have_rows('event_location', $post->ID) ) : the_row();
							$location = get_sub_field('event_location_name', $post->ID);
						endwhile;
					endif;

	        		echo '<dt>'.$date.'<br/>'.$location.'</dt>';
	        		echo '<dd>';
	        		    echo '<a href="'.get_the_permalink().'">';			    	
					    	echo '<h4>'.get_the_title().'</h4><span class="bubble icon-rarr"></span>';
	            		echo '</a>';
	            		echo '<p class="lead lead-small">'.$speech_title.'</p>';
	        			renmab_speaker_tagger($post);
	        		echo '</dd>';
	        		wp_reset_query();
				}

    		echo '</dl>';
		}
	echo '</div>';
echo '</section>';