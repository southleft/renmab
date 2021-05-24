<?php
/**
 * Block Name: SVG Diagram
 *
 */

$desktop = get_field('svg_desktop');
$med = get_field('svg_med');
$mobile = get_field('svg_mobile');

echo '<section class="svg-diagram">';
		echo '<div class="svg-desktop">';
		echo file_get_contents( $desktop );
	echo '</div>';
	echo '<div class="svg-medium">';
		echo file_get_contents( $med );
	echo '</div>';
	echo '<div class="svg-mobile">';
		echo file_get_contents( $mobile );
	echo '</div>';
echo '</section>';

