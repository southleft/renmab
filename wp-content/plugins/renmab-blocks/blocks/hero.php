<?php
/**
 * Block Name: Hero
 */
$art = get_field('hero_image');
$layout = get_field('hero_layout');
$headline = get_field('hero_headline');
$lead = get_field('hero_lead');
$button = get_field('hero_button');

$paragraph = get_field('hero_paragraph');
$hasParagraph = '';

$vid = get_field('hero_vid');
$hasVid = '';

$content = "";

if ($headline) {
	$content .= "<h1";
	if ( strlen($headline) > 60 ) {
		$content .= " class='h2'";
	}
	$content .= ">".$headline."</h1>";
}

if ($lead) {
	$content .= "<p class='lead";
	if ( strlen($lead) > 150 ) {
		$content .= " lead-small";
	}
	$content .= "''>".$lead."</p>";
}

if ($paragraph) {
	$hasParagraph = ' has-paragraph';
	$content .="<p>".$paragraph."</p>";
}

if ($vid) {
	$shortcode = get_field('hero_vid_code');
	$hasVid = ' has-vid';
	$content .= do_shortcode($shortcode);
}

if ($button && !$vid) {
	$arrow = get_field('hero_button_arrow');
	$content .= "<a class='button' href='".$button['url']."'>";
		$content .= $button['title'];
		if($arrow) { $content .= "<span class='icon-rarr'></span>"; }
	$content .= "</a>";
}

echo "<section class='hero layout-".$layout.$hasParagraph.$hasVid."'>";
	echo "<div class='wrapper flex-parent'>";
			echo "<div class='hero-art'><img src='".$art."' />";
			if ( $vid ) {
				echo '<div class="spheres">';
					echo renmab_sphere('green');
					echo renmab_sphere('green');
					echo renmab_sphere('blue');
					echo renmab_sphere('green');
					echo renmab_sphere('blue');
				echo '</div>';
			}
			echo '</div>';
			echo "<div class='hero-content flex-parent'>".$content."</div>";
	echo "</div>";
echo "</section>";