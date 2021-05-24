<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package RenMab
 */


/**
 * Date & Time formatter 
 */
function renmab_date_write($object = false) {
    if ( $object ) :
        $ID = $object->ID;
    else :
        $ID = false;
    endif;
    if ( have_rows('event_date_time', $ID) ) :
        while ( have_rows('event_date_time', $ID) ) : the_row();
            $multiDay = get_sub_field('event_date_multi');
            $startDate = get_sub_field('event_date');
            $startDate = str_replace(',', '', $startDate);
            $endDate = get_sub_field('event_end_date');
            $endDate = str_replace(',', '', $endDate);
            $sA = explode(' ', $startDate);
            if ( ( $multiDay && $endDate ) && ($startDate !== $endDate ) ) {
                $eA = explode(' ', $endDate);
                if ( $sA[2] !== $eA[2] ) {
                    $date = $sA[0].' '.$sA[1].', '.$sA[2].' - '.$eA[0].' '.$eA[1].', '.$eA[2];
                } else if ( $sA[0] !== $eA[0] ) {
                    $date = $sA[0].' '.$sA[1].'-'.$eA[0].' '.$eA[1].', '.$eA[2];
                } else {
                    $date = $sA[0].' '.$sA[1].'-'.$eA[1].', '.$eA[2];
                }
            } else {
                $date = $sA[0].' '.$sA[1].', '.$sA[2];
            }
            return $date;
        endwhile;
    endif;
}

/**
 * Resource Tags
 */
function renmab_resource_tagger($isLink) {
    $terms = get_the_terms($post->ID, 'resource-types');
    $term_name = $terms[0]->name;
    if (!is_wp_error($term_name)) {
        if ($isLink == 'text') {
            echo '<p class="accent accent-large tag tag-'.strtolower( $term_name ).'"><span class="icon-'.strtolower( $term_name ).'"></span>'.$term_name.'</p>';
        } else if ($isLink == 'link'){
            echo '<a class="accent accent-large tag tag-'.strtolower( $term_name ).'"><span class="icon-'.strtolower( $term_name ).'"></span>'.$term_name.'</a>';
        }
    }
}

/**
 * Speaker Tags
 */
function renmab_speaker_tagger($object = false) {
    if ( $object ) :
        $speaker_name = get_field('event_speaker_name', $object->ID);
        $speaker_pic = get_field('event_speaker_pic', $object->ID);
        $speaker_title = get_field('event_speaker_title', $object->ID);
    else :
        $speaker_name = get_field('event_speaker_name');
        $speaker_pic = get_field('event_speaker_pic');
        $speaker_title = get_field('event_speaker_title');
    endif;
    echo "<div class='speaker-tag'>";
        if ($speaker_pic) :
            $pic_src = wp_get_attachment_image_src( $speaker_pic, 'thumbnail' );
            echo '<?xml version="1.0" encoding="UTF-8"?>
            <svg width="119px" height="119px" viewBox="0 0 119 119" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <mask id="speakerMask" fill="white"><path d="M63.1134649,118.880809 C93.7275054,118.880809 118.141827,95.4557707 118.141827,64.8417301 C118.141827,34.2276895 89.684954,0 59.0709135,0 C28.4568729,0 0,31.1982591 0,61.8122997 C0,92.4263402 32.4994243,118.880809 63.1134649,118.880809 Z"></path></mask>
                </defs>

                <image xlink:href="'.$pic_src[0].'" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" mask="url(#speakerMask)" />';
            echo '</svg>';

        endif;
        echo '<div class="speaker-info">';
            if ($speaker_name) :
                echo '<p class="accent speaker-name">'.$speaker_name.'</p>';
            endif;
            if ($speaker_title) :
                echo '<p class="speaker-title">'.$speaker_title.'</p>';
            endif;
        echo '</div>';
    echo '</div>';
}

/**
 * Category Tags
 */
function renmab_cat_tagger() {
    $categories = get_the_category();
    $separator = ', ';
    $output = '';
    if ( ! empty( $categories ) ) {
        foreach( $categories as $category ) {
             $output .= '<p class="accent">' . esc_html( $category->name ) . '</p>' . $separator;
        }
        echo trim( $output, $separator );
    }
}
 
/**
 * Social Share buttons
 */
function social_share() {
    $pt = get_post_type_object( get_post_type() );
    $name = $pt->labels->singular_name;

    echo '<div class="share-buttons">';
    echo '<p class="accent accent-small">Share this '.$name.':</p>';
        echo '<a href="https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink().'" aria-label="Share on Facebook" target="_Blank"><span class="icon-facebook"></span></a>';
        echo '<a href="https://twitter.com/share?url='.get_the_permalink().'&text=RenMab at '.get_the_title().'" aria-label="Share on Twitter" target="_blank"><span class="icon-twitter"></span></a>';
        echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url='.get_the_permalink().'" aria-label="Share on LinkedIn" target="_blank"><span class="icon-linkedin"></span></a>';
   echo '</div>';
}

/**
 * Post thumbnail
 */

add_action( 'after_setup_theme', 'renmab_custom_image_sizing' );
function renmab_custom_image_sizing() {
    add_image_size( 'post-header', 680, 500, true );
    add_image_size( 'post-feat', 580, 290, true );
    add_image_size( 'post-thumb', 480, 400, true );
    add_image_size( 'event-header', 690, 630, true );
    add_image_size( 'event-thumb', 500, 315, true );
    add_image_size( 'resource-header', 300, 400, true ); // .75
    add_image_size( 'resource-thumb', 225, 300, true ); // .75
}

if ( ! function_exists( 'renmab_post_thumbnail' ) ) :
	function renmab_post_thumbnail($size = 'medium_large') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

        $id = get_post_thumbnail_id( get_the_ID() );
        $img = wp_get_attachment_image_src( $id, $size );
        $alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
        $url = $img[0];
        $height = $img[2];
        $width = $img[1];

        if (strpos($size, 'resource-') === 0) {
            $output = '<img src="'.$url.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'"/>';
        } else {
            $output = '<svg width="'.$width.'" height="'.$height.'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>'.$alt.'</title>
                    <image xlink:href="'.$url.'" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" />
                    <rect fill="#878DB5" style="mix-blend-mode: color;" width="100%" height="100%"></rect>
                    <rect fill="#CDD3FF" style="mix-blend-mode: multiply;" width="100%" height="100%"></rect>
                </svg>'; 
        }

		if ( is_singular() ) :
			?>
			<div class="post-thumbnail">
                <?php echo $output; ?>
			</div><!-- .post-thumbnail -->
		<?php else : 
        ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php echo $output; ?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
 * Spheres 
 */

function renmab_sphere($color) {
    $url = get_template_directory_uri()."/img/sphere_".$color.".png";
    echo '<img src="'.$url.'" class="sphere sphere-'.$color.'" alt=""/>';
}

/**
 * Licensing CTA
 */
function renmab_licensing_cta($stick = 'nostick') { 
?>
    <div class="licensing-cta <?php echo $stick ?>">
        <h3>Interested in a partnership?</h3>
        <a class="button button-white" href="/contact?ref=partnership#wpcf7-f1048-p98-o1">Apply Now</a>
            <?php renmab_sphere('orange'); ?>
            <?php renmab_sphere('green'); ?>
            <?php renmab_sphere('blue'); ?>
    </div>
<?php
}