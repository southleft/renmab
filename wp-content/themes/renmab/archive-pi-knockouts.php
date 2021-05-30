<?php /** * The template for displaying the Project Integrum library * * @link https://developer.wordpress.org/themes/basics/template-hierarchy/ * * @package RenMab */ get_header(); ?>

<main id="main" class="site-main">
    <?php $cats=get_terms(array( 'taxonomy'=> 'pi-cats', )); ?>
    <div class="wrapper">
        <h3>Search Knockouts</h3>
        <div class="pi-filters">
            <form class="ko-form">
                <div class="ko-form--body">
                    <div class="ko-form--target-row">
                        <div class="ko-form--target-field">
                            <label for="search-kos">Target Name</label>
                            <div>
                                <input id="search-kos" role="search" type="text">
                            </div>
                        </div>
                        <div class="ko-form--target-field">
                            <label for="select-kos">Therapeutic Area</label>
                            <select id="select-kos">
                                <option value="all"></option>
                                <option value="cardiovascular">Cardiovascular</option>
                                <option value="gastrointestinal">Gastrointestinal</option>
                                <option value="infectious-diseases">Infectious Diseases</option>
                                <option value="inflammation-and-autoimmunity">Inflammation and Autoimmunity</option>
                                <option value="metabolism">Metabolism</option>
                                <option value="neuroscience">Neuroscience</option>
                                <option value="oncology">Oncology</option>
                                <option value="ophthalmology">Ophthalmology</option>
                                <option value="orthopaedic-disorders">Orthopaedic Disorders</option>
                                <option value="others">Others</option>
                                <option value="reproductive-system-diseases">Reproductive System Diseases</option>
                                <option value="urological-diseases">Urological Diseases</option>
                            </select>
                        </div>
                    </div>
                    <div class="ko-form--mouse-row">
                        <div class="ko-form--mouse-labels">
                            <label>Mouse Models</label>
                        </div>
                        <div class="ko-form--mouse-checkboxes">
                            <div class="ko-form--input-container">
                                <input type="checkbox" id="renmab" name="renmab">
                                <label for="renmab">RenMab</label>
                            </div>
                            <div class="ko-form--input-container">
                                <input type="checkbox" id="renlite" name="renlite">
                                <label for="renlite">RenLite</label>
                            </div>
                            <div class="ko-form--input-container">
                                <input type="checkbox" id="rennano" name="rennano">
                                <label for="rennano">RenNano</label>
                            </div>
                        </div>
                    </div>
                    <div class="ko-form--phase-section">
                        <div class="ko-form--phase-label">
                            <label>KO Phase / Status</label>
                        </div>
                        <div class="ko-form--phase-row">
                            <div class="ko-form--phase-subrow">
								<div>
									<input type="checkbox" id="f0" name="f0">
									<label for="f0">F0</label>
								</div>
								<div>
									<input type="checkbox" id="f1" name="f1">
									<label for="f1">F1</label>
								</div>
								<div>
									<input type="checkbox" id="f2" name="f2">
									<label for="f2">F2</label>
								</div>
							</div>
							<div class="ko-form--phase-subrow">
								<div>
									<input type="checkbox" id="immunization" name="immnunization">
									<label for="immunization">Immunization</label>
								</div>
								<div>
									<input type="checkbox" id="anti-discovery" name="anti-discovery">
									<label for="anti-discovery">Antibody Discovery</label>
								</div>
							</div>	
                        </div>
                        <div class="ko-form--phase-row">
                            <div>
                                <input type="checkbox" id="invitro" name="invitro">
                                <label for="invitro">In Vitro</label>
                            </div>
                            <div>
                                <input type="checkbox" id="invivo" name="invivo">
                                <label for="invivo">In Vivo</label>
                            </div>
                            <div>
                                <input type="checkbox" id="complete" name="complete">
                                <label for="complete">Complete</label>
                            </div>
                        </div>
                        <div class="ko-form--exclude-row">
                            <input type="checkbox" id="exclude" name="exclude" checked="">
                            <label class="ko-form--exclude-label" for="exclude">Exclude Exclusive Partnerships</label>
                        </div>

                    </div>
                </div>
                <div class="ko-form--button-section">
                    <div class="ko-form--button-container">
                        <button type="button" class="apply ko-form--search-button">Search Targets</button>
                    </div>
                    <div class="ko-form--button-container">
                        <button type="button" class="clear ko-form--clear-button">Clear Search</button>
                    </div>
                </div>
            </form>

            
        </div>
        <div class="pi-loading">
            <div class="pi-loading-wrap">
                <p>Loading</p>
            </div>
        </div>
        <div class="ko-form--sort-container accent accent-small">
            <form name="ko-sort-form">
                <label for="ko-sort">Sort by</label>
                <select class="ko-form--sort-select" name="ko-sort" id="ko-sort">
                    <option class="ko-form--sort-option" selected value="ASC">A-Z</option>
                    <option class="ko-form--sort-option"  value="DESC">Z-A</option>
                    <option class="ko-form--sort-option"  value="LAUNCHED-ASC">Launched Drugs (Ascending)</option>
                    <option class="ko-form--sort-option"  value="LAUNCHED-DESC">Launched Drugs (Descending)</option>
                </select>
            </form>
        </div>
        <ul class="pi-models">
            <?php renmab_ajax_pi_filter_args(); ?> 
        </ul>
    </div>
</main>
<!-- #main -->

<?php $title=get_field( 'pi_footer_title', 'option'); $img=get_field( 'pi_footer_img', 'option'); $content=get_field( 'pi_footer_content', 'option'); ?>



<section class="pi-footer bg-beige">
    <h3 class="pi-footer-title wrapper">
                <?php echo $title ?>
            </h3>
    <div class="wrapper flex-parent">
        <div class="flex-half pi-footer-img">
            <svg width="<?php echo $img['sizes']['medium_large-width'] ?>" height="<?php echo $img['sizes']['medium_large-height'] ?>" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>
                    <?php echo $img[ 'alt'] ?>
                </title>
                <image xlink:href="<?php echo $img['url'] ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" />
                <rect fill="#878DB5" style="mix-blend-mode: color;" width="100%" height="100%"></rect>
                <rect fill="#CDD3FF" style="mix-blend-mode: multiply;" width="100%" height="100%"></rect>
            </svg>
        </div>
        <div class="flex-half pi-footer-content">
            <?php echo $content; ?>
        </div>
    </div>
</section>
<?php get_footer( 'cta');