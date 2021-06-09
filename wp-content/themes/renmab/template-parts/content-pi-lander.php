<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RenMab
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_title( '<h1 class="entry-title screen-reader-text">', '</h1>' ); ?>

	<?php renmab_post_thumbnail(); ?>

	<div class="single-content">
		<?php the_content(); ?>
		<div class="wrapper">
			<div class="pi-stats has-white-background-color">
				<h2 class="h3">Phase Overview of KO Targets Progress</h2>
				<div class="flex-parent">
					<?php 
					$phases = get_field_object('field_5e71396de503b');
					foreach ($phases['choices'] as $key => $val) : 
						$count = renmab_pi_stats('pi_phase', $key)->found_posts; 
						if ($count != 0) : ?>
							<div class="stat-col">
								<div class="stat"> 
									<h3><?= $count ?></h3>
									<p class="lead lead-small"><?= $val; ?></p>
								</div>
							</div>
						<?php 
						endif;
					endforeach; ?>
					<div class="stat-col">
						<div class="stat private">
							<h3><?= renmab_pi_stats('pi_private', true)->found_posts; ?></h3>
							<p class="lead lead-small">Exclusive Partnership</p>
						</div>
					</div>
				</div>

				<div class="pi-filters lander-filters">
					<form class="flex-parent">
						<div class="form-container flex-parent">
							<div class="input-group">
								<label for="search-kos">Search Targets:</label>
								<div class="search">
									<input id="search-kos" role="search" type="text" placeholder="Search..."></input>
								</div>
							</div>
						</div>
					    <div class="button-group">
					    	<a href="<?= get_post_type_archive_link('pi-knockouts').'?model=all&search=' ?>" class="button apply">Search</a>
						</div>
					</form>
				</div>
			</div>	
		</div>
		<div class="pi-cats-wrap wrapper">
			<div class="pi-cats has-white-background-color">
				<h3>Therapeutic Areas</h3>
				<div class="flex-parent">
					<?php 
					$cats = get_terms( array(
					    'taxonomy'   => 'pi-cats',
					) ); 

					foreach ($cats as $cat) {
						echo '<a href="'.get_post_type_archive_link('pi-knockouts').'?model='.$cat->slug.'"><span>'.$cat->name.'</span></a>';
					} ?>
				</div>
				<a class="button" href="<?= get_post_type_archive_link('pi-knockouts') ?>"><span class="icon icon-search"></span> Search All Therapeutic Areas</a>
			</div>
		</div>
	</div><!-- .single-content -->
</article><!-- #post-<?php the_ID(); ?> -->