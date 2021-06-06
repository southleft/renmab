<?php
/**
 * Search & Filter Pro 
 *
 * Sample Results Template
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 * 
 * Note: these templates are not full page templates, rather 
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think 
 * of it as a template part
 * 
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs 
 * and using template tags - 
 * 
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $query->have_posts() )
{	

    $total = $query->found_posts;
    $shown = $query->post_count;

foreach ($query->posts as $post) {

	$terms = get_the_terms( $post->ID, 'pi-cats' );

	
	foreach ($terms as $term) {
		$term_names[] = $term->name;
		
	}
	
}
	$terms_unique = array_unique($term_names);
	
	?>
<li class="pi-model">
	
	<?php 
		

		foreach($terms_unique as $term){ 
			if(isset($_GET['_sft_pi-cats'])){
    		$cat_param = $_GET['_sft_pi-cats'];
				}
			else{ 
				$cat_param = 'all';
			}
			$term_lower = strtolower($term);
			$term_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $term_lower);
			
				if (isset($cat_param) && $cat_param == $term_slug){
	?>
	
	<div class="ko-block">
            <h2 class="h3"><?php echo $term ?></h2>

            <ul class="table-header accent accent-small table-row">
                <li>Target Name</li>
                <li class="pi-model-mouse pi-model-mouse--header">
                    <div>
                        <div class="pi-model-mouse--label table-row">
                            mouse models
                        </div>
                        <ul class="pi-model-mouse table-row">
                            <li>RenMab&trade;</li>
                            <li>RenLite&trade;</li>
                            <li>RenNano&trade;</li>
                        </ul>
                    </div>
                </li>
                <li>Launched Drugs</li>
            </ul>

            <?php 
		
					
					while ($query->have_posts()): $query->the_post(); 		
		
                $private = get_field('pi_private');
                $phase_renmab   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renmab');
                $phase_renlite   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renlite');
                $phase_rennano   = $private ? 'Exclusive Partnership' : get_field('pi_phase_rennano');
                $drugs   = get_field('pi_drugs_launched'); ?>
                <a href="<?= get_the_permalink() ?>" class="pi-title">
                    <div href="<?= get_the_permalink() ?>" class="table-row">
                        <h3 class="h6"><?= get_the_title() ?></h3>
                        <div class="pi-model-mouse table-row">
                            <div class="renmab <?= sanitize_title_for_query($phase_renmab) ?>"></div>
                            <div class="renlite <?= sanitize_title_for_query($phase_renlite) ?>"></div>
                            <div class="rennano <?= sanitize_title_for_query($phase_rennano) ?>"></div>
                        </div>
                        <p><?= $drugs ?></p>
                     </div>
                 </a>
	
						
               
<?php 
					endwhile;
			?></div><?php
		} elseif ($cat_param == 'all') {

					?>
	
	<div class="ko-block">
            <h2 class="h3"><?php echo $term ?></h2>

            <ul class="table-header accent accent-small table-row">
                <li>Target Name</li>
                <li class="pi-model-mouse pi-model-mouse--header">
                    <div>
                        <div class="pi-model-mouse--label table-row">
                            mouse models
                        </div>
                        <ul class="pi-model-mouse table-row">
                            <li>RenMab&trade;</li>
                            <li>RenLite&trade;</li>
                            <li>RenNano&trade;</li>
                        </ul>
                    </div>
                </li>
                <li>Launched Drugs</li>
            </ul>

            <?php 
		
					$i = 1; 
					while ($query->have_posts() && $i < 11): $query->the_post(); $post_id = get_the_ID();
					
						$p_terms = get_the_terms($post_id, 'pi-cats');
						foreach ($p_terms as $p_term){
						
						if ($term == $p_term->name){
		
		
                $private = get_field('pi_private');
                $phase_renmab   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renmab');
                $phase_renlite   = $private ? 'Exclusive Partnership' : get_field('pi_phase_renlite');
                $phase_rennano   = $private ? 'Exclusive Partnership' : get_field('pi_phase_rennano');
                $drugs   = get_field('pi_drugs_launched'); ?>
                <a href="<?= get_the_permalink() ?>" class="pi-title">
                    <div href="<?= get_the_permalink() ?>" class="table-row">
                        <h3 class="h6"><?= get_the_title() ?></h3>
                        <div class="pi-model-mouse table-row">
                            <div class="renmab <?= sanitize_title_for_query($phase_renmab) ?>"></div>
                            <div class="renlite <?= sanitize_title_for_query($phase_renlite) ?>"></div>
                            <div class="rennano <?= sanitize_title_for_query($phase_rennano) ?>"></div>
                        </div>
                        <p><?= $drugs ?></p>
                     </div>
                 </a>
	
						
               
<?php $i++; }
				} 
					
					endwhile;
			?>
	
<button class="loader" onclick="window.location.href='<?php get_site_url(); ?>/ko-library/?_sft_pi-cats=<?php echo $term_slug ?>&_sfm_pi_private=0-%2C-1';">All <?php echo $term ?></button>
	</div><?php
				}
			}
	
	
}
else
{
	?>
	<div class='search-filter-results-list' data-search-filter-action='infinite-scroll-end'>
		<span>End of Results</span>
	</div>
	<?php
}
?>