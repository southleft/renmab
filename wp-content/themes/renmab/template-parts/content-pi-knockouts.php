<?php
/**
 * Template part for displaying PI Knockouts
 *
 *
 * @package RenMab
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
	<?php
	$pi_id   = get_field('pi_id');
    $private = get_field('pi_private');
	$phase_renmab   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renmab');
	$phase_renlite   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renlite');
	$phase_rennano   = $private ? 'Exclusive Partnership' : get_field('pi_phase_rennano');
	$cats    = get_the_terms( get_the_ID(), 'pi-cats');

	if( $pi_id ) {
		$ko_data = renmab_pharmacodia_get_data( get_the_ID() );

		$synonyms        = !empty( $ko_data['en_target_alias'] ) ? implode(', ', $ko_data['en_target_alias']) : '';
		$desc            = $ko_data['target_description'];
		$number_launched = $ko_data['number_launched_druds'];
		$number_trials   = $ko_data['number_drugs_clinical_trials'];
		$highest_phase   = $ko_data['highest_phase'];
		$drugs           = $ko_data['drugs'];
		$refs            = $ko_data['literatures'];
	} else {
		$synonyms        = get_field('pi_synonyms');
		$desc            = get_field('pi_description');
		$number_launched = get_field('pi_drugs_launched');
		$number_trials   = get_field('pi_drugs_trials');
		$highest_phase   = get_field('pi_drugs_phase'); 
		$drugs           = get_field('pi_drugs');
		$refs            = get_field('pi_references');
	}
	?>
	<div class="flex-parent ko-content">
		<div class="single-content">
			<?php 
			the_title( '<h1 class="entry-title h3">', '</h1>' );

			if( $synonyms ) :
				echo '<h3>Synonyms</h3>';
				echo '<p>'.$synonyms.'</p>';
			endif;
			
			if($desc) :
				echo '<h3>Description</h3>';
				echo '<p>'.$desc.'</p>';
			endif; 
			
			// if($phase) : // DO WE WANT TO CONDITIONALLY SHOW THESE FIELDS? OR ALWAYS SHOW
				echo '<h3>KO Status</h3>';
				echo '<p class="hello">'.$phase_renmab.'</p>';
				echo '<p>'.$phase_renlite.'</p>';
				echo '<p>'.$phase_rennano.'</p>';
			// endif; 

			<h3>Drug Information</h3>
			
			<p>
			<?php if ($number_launched > 0) : ?>
				Launched <?= ($number_launched == 1 ? ' drug' : ' drugs').': '.$number_launched ?>
				<br>
			<?php endif; ?>

			<?php if ($number_trials > 0) : ?>
				<?= $number_trials == 1 ? ' Drug' : ' Drugs' ?> in clinical trials: <?= $number_trials ?>
				<br>
			<?php endif; ?>

			<?= $highest_phase ? 'Latest Research Phase: '.$highest_phase : '' ?>
			</p>

		</div>
		<aside class="single-sidebar">
			<h2 class="h5">Interested in a partnership?</h2>
			<a class="button" href="<?= get_site_url() ?>/contact?ref=partnership#wpcf7-f1048-p98-o1">Talk to an Expert</a>
		</aside>
	</div>
	<?php 
	if ( $drugs ) : 
		$sorter = $pi_id ? 'highest_en_name' : 'pi_drug_phase';
		usort($drugs, function ($a, $b) use ($sorter) {              
			$order = [
				'Approved',
				'NDA/BLA',
				'Phase 3 Clinical',
				'Phase 2 Clinical',
				'Phase 1 Clinical',
				'Clinical',
				'IND',
				'Preclinical',
				'Pending',
				'Discontinued',
				'Withdrawn'
			];             

			return ( array_search($a[ $sorter ], $order) <=> array_search($b[ $sorter ], $order) );         
		}); ?>
		<div class="ko-drugs-wrap">
			<div class="mobile-view-toggle-wrap">
				<div id="mobile-view-toggle" onclick="toggleKOView();"></div>
			</div>

			<div class="ko-drugs">
				<div class="ko-table-header flex-parent accent accent-small">
					<p class="col-3">Drug Name</p> 
					<p class="col-2 m-col-3">Code</p>
					<p class="col-1 m-col-3">Phase</p>
					<p class="col-2 m-col-3">Company</p>
					<p class="col-3 m-col-10">Indications</p>
					<p class="col-1 m-col-2">Clinical Trials</p>
				</div>
				<?php 
				$counter = 0;
				foreach( $drugs as $drug) : 
					$counter++; 
					if( $pi_id ) {
						$drug_name     = $drug['en_name'];
						$code_name     = !empty($drug['code_name']) ? implode(', ', $drug['code_name']) : '';
						$highest_phase = $drug['highest_en_name'];
						$indications   = !empty($drug['indications']) ? implode(', ', $drug['indications']) : '';
						$organization  = !empty($drug['organization']) ? implode(', ', $drug['organization']) : '';
						$trials        = $drug['clinical_trials'];
					} else {
						$drug_name     = $drug['pi_drug_name'];
						$code_name     = $drug['pi_drug_code'];
						$highest_phase = $drug['pi_drug_phase'];
						$indications   = $drug['pi_drug_indications'];
						$organization  = $drug['pi_drug_organization'];
						$trials        = $drug['pi_drug_trials'];	
					} ?>

		        	<div id="toggle-drugs-<?= $counter ?>" class="ko-table-content flex-parent">
		        		<h4 class="col-3"><?= str_replace( '/', '/<wbr>', $drug_name) ?></h4>
		        		<p class="col-2 m-col-3"><?= str_replace( '/', '/<wbr>', $code_name) ?></p>
		        		<p class="col-1 m-col-3"><?= $highest_phase ?></p>
		        		<p class="col-2 m-col-3"><?= $organization ?></p>
						<p class="col-3 m-col-10"><?= $indications ?></p>

						<?php 
						if ($trials) : 
							$sorter = $pi_id ? 'study_phase' : 'pi_drug_trial_phase';
							usort($trials, function ($a, $b) use ($sorter) {              
								$order = [
									'Phase 4',
									'Phase 3',
									'Phase 2/Phase 3',
									'Phase 2',
									'Phase 1/Phase 2',
									'Phase 1',
									'Early Phase 1',
									'N/A'
								];             
								
								return (array_search($a[ $sorter ], $order) <=> array_search($b[ $sorter ],$order));
							});

							$nct_number = $intervention = $indications = $study_phase = $recruitment_status = array();
							$trial_count = 0;
							
							foreach ($trials as $trial) :
								$trial_count++;
								
								if ( $pi_id ) {
									$nct_number[ $trial_count ]         = $trial['nct_number'];
									$intervention[ $trial_count ]  = !empty($trial['intervention_type']) ? implode(', ', $trial['intervention_type']) : '';
									$indications[ $trial_count ]        = $trial['indications'];
									$study_phase[ $trial_count ]        = $trial['study_phase'];
									$recruitment_status[ $trial_count ] = $trial['recruitment_status'];
								} else {
									$nct_number[ $trial_count ]         = $trial['pi_drug_trial_nct'];
									$intervention[ $trial_count ]       = $trial['pi_drug_trial_intervention'];
									$indications[ $trial_count ]        = $trial['pi_drug_trial_indications'];
									$study_phase[ $trial_count ]        = $trial['pi_drug_trial_phase'];
									$recruitment_status[ $trial_count ] = $trial['pi_drug_trial_status'];	
								}
				    		endforeach;

							?>
							<button class="toggle-trials col-1 m-col-2" id="toggle-trials-<?= $counter ?>" onclick="toggleSection(this.id);">
		        				<span class="icon icon-plus"></span>
							</button>
							<div style="opacity: 0; display: none" id="content-trials-<?= $counter ?>" class="ko-trials flex-parent">
								<div class="ko-trials-row">
									<p class="ko-trials-header accent">NCT Number</p>
									<?php 
									foreach($nct_number as $i) :
										echo '<p>' . $i . '</p>'; 
									endforeach; ?>
								</div>

								<div class="ko-trials-row">
									<p class="ko-trials-header accent">Intervention Type</p>
									<?php 
									foreach($intervention as $i) :
										echo '<p>'. $i .'</p>'; 
									endforeach; ?>
								</div>

								<div class="ko-trials-row">
									<p class="ko-trials-header accent">Indications</p>
									<?php 
									foreach($indications as $i) :
										echo '<p>' . $i . '</p>'; 
									endforeach; ?>
								</div>

								<div class="ko-trials-row">
									<p class="ko-trials-header accent">Study Phase</p>
									<?php 
									foreach($study_phase as $i) :
										echo '<p>' . $i  .'</p>'; 
									endforeach; ?>
								</div>

								<div class="ko-trials-row">
									<p class="ko-trials-header accent">Recruitment Status</p>
									<?php 
									foreach($recruitment_status as $i) :
										echo '<p>' . $i . '</p>'; 
									endforeach; ?>
								</div>
							</div><!-- .ko-trials -->
						<?php endif; ?>
					</div><!-- .ko-drugs-info  -->
			<?php if($counter % 10 == 0 && $counter != 0): ?>
				<button id="toggle-drugs-<?= $counter ?>"  class="ko-toggler" onclick="toggleSection(this.id); this.remove();">Load More</button>
				</div><!-- .ko-drugs -->
				<div id="content-drugs-<?= $counter ?>" class="ko-drugs" style="opacity: 0; display: none">
			<?php endif;
		endforeach; ?>
		</div><!-- .ko-drugs -->
	</div> <!-- .ko-drugs-wrap -->
	<?php endif; ?>

	<?php if ( $refs ) : 
		$ref_count = 0; ?>
		<div class="ko-refs">
			<h3>References</h3>
			<hr />
			<div class="ko-table-header flex-parent accent accent-small">
				<p class="col-5">Title</p> 
				<p class="col-4">Authors</p>
				<p class="col-3">Source</p>
			</div>
			<?php foreach( $refs as $ref) : 
				$ref_count++;

				if ( $pi_id ) {
					$url     = $ref['pubmed_link'];
					$title   = $ref['title'];
					$authors = $ref['author'];
					$source  = $ref['source'];
				} else {
					$url     = $ref['pi_reference_pubmed'];
					$title   = $ref['pi_reference_title']; 
					$authors = $ref['pi_reference_authors'];
					$source  = $ref['pi_reference_source'];
				} ?>
				
				<?= $url ? '<a target="_blank" href="'.$url.'"" class="ko-table-content">' :'<div class="ko-table-content">'; ?>
					<h4 class="h6 col-5"><?= $title ?></h4>
		        	<p class="col-4"><?= $authors ?></p>
		        	<p class="col-3"><?= $source ?>
		        	<?= $url ? '<span class="icon-out"></span>' : '' ?>
		        	</p>
				<?= $url ? '</a>' : '</div>'; ?>


				<?php if($ref_count % 10 == 0 && $ref_count != 0): ?>
					<button id="toggle-refs-<?= $counter ?>"  class="ko-toggler" onclick="toggleSection(this.id); this.remove();">Load More</button>
					</div><!-- .ko-drugs -->
					<div id="content-refs-<?= $counter ?>" class="ko-refs" style="opacity: 0; display: none">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->