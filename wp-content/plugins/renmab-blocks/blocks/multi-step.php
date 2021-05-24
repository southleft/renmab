<?php
/**
 * Block Name: Multi-Step Panels
 *
 */
$type = get_field('step_type');
$counter = 0;
$nav_list = '';
$content_list = '';
$select = '';
$nav_header = get_field('step_nav_header');
$resource = get_field('step_resource');

if( have_rows('step_panels') ):
    while ( have_rows('step_panels') ) : the_row();
    	$counter ++;
    	$title = get_sub_field('step_panel_title');
        $use_title = get_sub_field('step_panel_use_title');

        if ( $counter == 1 ) {
            $active = ' class="active"';
        } else {
            $active = '';
        }
        $select_label = '<option value="'.$counter.'">'.$title.'</option>';
    	$nav_label = '<li'.$active.'><button aria-label="'.$title.'" type="button" class="multi-nav-'.$counter.'">';
            $nav_label .= '<span class="accent accent-small">'.$title.'</span>';
            if ($type == 'icons') { 
                $nav_label .= '<div class="step-icon">';
                    $nav_label .= '<?xml version="1.0" encoding="UTF-8"?>
                        <svg viewBox="0 0 1321 1299" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <defs>
                            <filter id="blue">
                              <feFlood flood-color="#848CC6" result="colour"/>
                              <feComposite operator="in" in="colour" in2="SourceGraphic"/>
                              <feBlend mode="multiply" in2="SourceGraphic"/>
                            </filter>
                            <filter id="brown">
                              <feFlood flood-color="#8E7A71" result="colour"/>
                              <feComposite operator="in" in="colour" in2="SourceGraphic"/>
                              <feBlend mode="multiply" in2="SourceGraphic"/>
                            </filter>
                          </defs>
                            <path d="M8.09875339,596.816372 C-44.8828381,931.328975 168.790895,1238.63335 503.258901,1291.60788 C837.726906,1344.58241 1260.92349,1092.86826 1313.90508,758.355661 C1366.88668,423.843057 1075.28423,58.9158707 740.816225,5.94134287 C406.34822,-47.0331849 61.0803449,262.303768 8.09875339,596.816372 Z"></path>
                             <image xlink:href="'.get_sub_field('step_panel_icon').'" x="23%" y="23%" width="50%" height="50%" filter="url(#brown)"/>
                            <image id="filter-blue" xlink:href="'.get_sub_field('step_panel_icon').'" x="23%" y="23%" width="50%" height="50%" filter="url(#blue)"/>
                        </svg>';
                $nav_label .= '<div>';

            }
        $nav_label .= '</button></li>';
    	$nav_list .= $nav_label;
        $select .= $select_label;
    	$content = '<div class="multi-step multi-step-'.$counter.'">';
        if ($use_title) {
            $content .= '<h3 class="h2">'.$title.'</h3>';
        }
        if ($content) {
            $content .= get_sub_field('step_panel_content');
        }

        $inherit = get_sub_field('data_tabs_inherit');

        if ($inherit == true) {
            $tab_content = get_sub_field('tabs_text');
            $tab_result = get_sub_field('tabs_result');
        }

        if ( have_rows('data_tabs') ) :
            $tabCount = 0;
            $tabLabels = '';
            $tabCards = '';

            while ( have_rows('data_tabs') ) : the_row();
                $tab_title = get_sub_field('tab_title');
                $tabCount ++;
                if ( $tabCount == 1 ) {
                    $tabActive = ' active';
                } else {
                    $tabActive = '';
                }
                $tab_img = get_sub_field('tab_img');

                if($inherit == false) {
                    $tab_content = get_sub_field('tab_text');
                    $tab_result = get_sub_field('tab_result');
                }

                $tabLabels .= '<button type="button" class="accent data-label-'.$tabCount.$tabActive.'">'.$tab_title.'</button>';

                $tabCards .= '<div class="data-tab data-tab-'.$tabCount.$tabActive.'">';
                    $tabCards .= '<div class="data-content">';
                        if(strlen($tab_content) > 0) {
                            $tabCards .= '<div class="data-text bg-blue">'.$tab_content.'</div>';
                        }
                        if(strlen($tab_result) > 0) { 
                            $tabCards .= '<div class="result"><span class="accent accent-small">Result</span><h4 class="h6">'.$tab_result.'</h4></div>';
                        }
                    $tabCards .= '</div>';
                    if ($tab_img) { 
                        $tabCards .= '<div class="data-img"><img src="'.$tab_img.'" /></div>'; 
                    }
                $tabCards .= '</div>';
            
            endwhile;
            if ($tabCount > 1) {
                $content .= '<div class="data-labels">'.$tabLabels.'</div>';
            }
            $content .= '<div class="data-tabs">'.$tabCards.'</div>'; 
            
        endif;
    	$content .= '</div>';
	    $content_list .= $content;
    endwhile;
endif; 
?>

<section class="multi-steps <?php echo $type ?>">
    <div class="multi-steps-wrap flex-parent">
    	<div class="multi-nav-wrap">
            <?php if ($nav_header) {
                echo '<h4>'.$nav_header.'</h4>';
            } ?>
            <select><?php echo $select ?></select>
           <?php 
           echo '<ul class="multi-nav">'.$nav_list.'</ul>'; ?>
    	</div>
        <div class="perspective-wrap">
	       <?php echo $content_list; ?>
        </div>
    </div>
    <?php 
    if ( $resource ) :
        global $post;
        $post = $resource;
        $terms = get_the_terms($post->ID, 'resource-types');
        $term_name = strtolower( $terms[0]->name );
        setup_postdata($post); 
        $text = get_field('step_resource_title');
        ?>
            <div class="multi-resource wrapper flex-parent bg-blue"> 
                <div class="multi-resource-img">
                    <?php renmab_post_thumbnail('resource-thumb'); ?>
                </div>
                <div class="multi-resource-content">
                    <?php 
                    if($text) :
                        echo '<h4>'.$text.'</h4>';
                    endif; 
                    ?>
                    <a href="<?php echo get_the_permalink() ?>" class="button button-<?php echo $term_name ?>">Download <?php echo $term_name ?><span class="icon-download"></span></a>
                </div>
            </div>
        <?php
        wp_reset_postdata();
    endif;
    ?>
</section>