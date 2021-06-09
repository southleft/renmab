<?php
/**
 * Block Name: Hero
 */
$title = get_field('home_heading'); 
$dna = get_field('dna_tooltip');
$light = get_field('light_chain_tooltip');
$heavy = get_field('heavy_chain_tooltip');
?>

<section class="home-hero">
	<div class="home-hero__inner">
		<h1><?= $title ?></h1>
		<?= $dna ? '<span id="dna-tooltip" class="tooltip">'.$dna.'</span>' : '' ?>
		<?= $light ? '<span id="light-tooltip" class="tooltip">'.$light.'</span>' : '' ?>
		<?= $heavy ? '<span id="heavy-tooltip" class="tooltip">'.$heavy.'</span>' : '' ?>
		<span class="cell"></span>
		<span class="antibody antibody-1">
			<img src="/wp-content/themes/renmab/img/Antibody-1.png">
		</span>
		<span class="antibody antibody-2">
			<img src="/wp-content/themes/renmab/img/Antibody-2.png">
		</span>
		<span class="antibody antibody-3">
			<img src="/wp-content/themes/renmab/img/Antibody-3.png">		
		</span>
		<span class="antibody antibody-4">
			<img src="/wp-content/themes/renmab/img/Antibody-4.png">		
		</span>
		<span class="antibody antibody-5">		
			<img src="/wp-content/themes/renmab/img/Antibody-5.png">
		</span>
		<span class="antibody antibody-6">
			<img src="/wp-content/themes/renmab/img/Antibody-6.png">
		</span>
		<span class="antibody antibody-7">
			<img src="/wp-content/themes/renmab/img/Antibody-7.png">
		</span>
		<span class="antibody antibody-8">
			<img src="/wp-content/themes/renmab/img/Antibody-8.png">	
		</span>
	<div>
</section>