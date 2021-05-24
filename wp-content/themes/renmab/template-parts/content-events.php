<?php
/**
 * Template part for displaying events
 *
 *
 * @package RenMab
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	$speaker_name = get_field('event_speaker_name');
	$speech_title = get_field('event_speech_title');			
	if ( is_singular() ) : ?>
		<header class="single-header flex-parent">
			<div class="header-img">
				<?php renmab_post_thumbnail('event-header'); ?>
			</div>
			<div class="header-content">
				<p class="accent"><?php echo renmab_date_write(); ?></p>

				<?php 
				the_title('<h1 class="h2 entry-title">', '</h1>' );

				if ( have_rows('event_location') ) :
					while ( have_rows('event_location') ) : the_row();
						$location = get_sub_field('event_location_name');
						$sublocation = get_sub_field('event_sublocation');
						$link = get_sub_field('event_link');

						if ($location) { echo '<p class="lead">'.$location.'<br/>'.$sublocation.'</p>'; }
						if ($link) { echo '<a class="button" href="'.$link['url'].'">'.$link['title'].'<span class="icon-out"></span></a>'; }
					endwhile;
				endif;
				?>
			</div><!-- .header-content -->
		</header><!-- .single-header -->

		<div class="single-content">
			<?php
			$speech_date = get_field('event_speech_date');
			$speech_track = get_field('event_speech_track');
			$speech_abstract = get_field('event_speech_abstract');

			echo '<dl class="speech-info flex-parent">';

			if ($speaker_name) :
				echo '<dt class="dt-speaker">Speaker</dt>';
				echo '<dd>';
					renmab_speaker_tagger();
				echo '</dd>';
			endif;

			if ($speech_title) :
				echo '<dt>Title</dt>';
				echo '<dd><h2 class="h3">'.$speech_title.'</h2></dd>';
			endif;

			if ($speech_date) :
				echo '<dt>Time</dt>';
				echo '<dd class="speech-date accent">'.$speech_date.'</dd>';
			endif;

			if ($speech_track) :
				echo '<dt>Track</dt>';
				echo '<dd><h3 class="lead lead-small">'.$speech_track.'</h3></dd>';
			endif;

			if ($speech_abstract) :
				echo '<dt>Abstract</dt>';
				echo '<dd>'.$speech_abstract.'</dd>';
			endif;

			echo '</dl>';

			the_content( sprintf(
				wp_kses(
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'renmab' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'renmab' ),
				'after'  => '</div>',
			) );

			social_share();
			?>
		</div><!-- .single-content -->
		<?php 
		$sidebar = get_field('sidebar'); ?>
		<aside class="single-sidebar <?php echo $sidebar ?>">
			<?php 
			if ($sidebar == 'intake')  : 
				echo '<h3 class="h4">Meet us at '.get_the_title().'</h3>';
				echo do_shortcode('[contact-form-7 id="1058" title="Event Meeting Form"]'); ?>
				<script>
					document.addEventListener( 'wpcf7mailsent', function( event ) {
					  location = '/event-thank-you/?event=<?php echo get_queried_object()->post_name ?>';
					}, false );
				</script>
			<?php
			else: 
				renmab_licensing_cta();
			endif ?>
		</aside>
	<?php 
	else: ?>
		<div class="archive-img">
			<?php 
				renmab_post_thumbnail('event-thumb');
				renmab_speaker_tagger(); ?>
		</div>
		<div class="archive-content">
			<p class="accent"><?php echo renmab_date_write(); ?></p>
			<?php
			the_title( '<h2 class="h3 entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			echo '<h3 class="lead">'.$speech_title.'</h3>';
			echo '<div class="location">';
				if ( have_rows('event_location') ) :
					while ( have_rows('event_location') ) : the_row();
						$location = get_sub_field('event_location_name');
						$link = get_sub_field('event_link');

						echo '<p>'.$location.'</p>';
					endwhile;
				endif;
				echo '<a href="'.get_the_permalink().'" class="tag-bubble">Learn More<span class="bubble bubble-small icon-rarr"></span></a>';
			echo '</div>';
			?>
		</div>	
	<?php
	endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
