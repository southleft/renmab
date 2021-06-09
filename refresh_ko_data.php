<?php
set_time_limit(0);
if ( !defined('ABSPATH') ) {
	require_once('./wp-load.php');
}


//upload directory path
$upload_dir   = wp_upload_dir();
$dir = $upload_dir['basedir'];
/*if (!file_exists($$dir.'/ko-json-cache/')) {
	mkdir($dir.'/ko-json-cache/', 0777);
}*/


$jsondata = $pi_id = '';
global $todays_date;
$todays_date = date('m-d-Y');
$post_id = $_GET['post_id'];
$success = '<div class="alert alert-success" role="alert">Knockout updated successfully!</div>';
$error = '<div class="alert alert-danger" role="alert">Knockout update failed!</div>';

//get logged in user data
$current_user = wp_get_current_user();




if(!empty($post_id) && $current_user->roles[0] == 'administrator'){
	$post   = get_post($post_id);
	$pi_id = get_field( "pi_id", $post_id );
    $url = getApiUrl($pi_id);
    $jsondata = getResponse($url);

    if($jsondata != '') {
    	if(!empty($pi_id)){
    		file_put_contents($dir.'/ko-json-cache/'.$post->post_name.'_'.$pi_id.'.json', $jsondata);
    		update_post_meta($post_id, 'knockouts_updated_date', $todays_date );
    		updateKoPost($jsondata, $post_id);
    		purgeKoPageCache($post_id);
    		echo $success;
		}else{
			echo $error;
		}
    }

}else{

		/*
		$args = array(
			    'post_type' => 'pi-knockouts',
			    'posts_per_page' => 1,
			    'post_status' => 'publish',
			
				'meta_query' => array(
									'relation' => 'AND',
					    			array(
					    					'key'     => 'knockouts_updated_date',
									        'value'   => $todays_date,
									        'compare' => '!=',
					    				),
					    			array(
					    					'key'     => 'pi_id',
									        'value'   => 0,
									        'compare' => '>',
					    				)
			    			)
			);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;
		*/


		/*# Total Number KOs with Pharmacodia ID
		$args = array(
			    'post_type' => 'pi-knockouts',
			    'posts_per_page' => -1,
			    'post_status' => 'publish',
			    'meta_query' => array(
			    			array(
			    					'key'     => 'pi_id',
							        'value'   => 0,
							        'compare' => '>',
			    				)
	    			)
			);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;
		echo '<p style="color: #0000FF;">Total Number KOs with Pharmacodia ID : '.count($knockouts).'</p>';

		foreach ($knockouts as $key => $value) {
			$valid_ko[] = $value->ID;
		}
		*/



		# Total Number KOs remaining to be cached today
		$args = array(
	    'post_type' => 'pi-knockouts',
	    'posts_per_page' => 50,
	    'post_status' => 'publish',
	
		'meta_query' => array(
							'relation' => 'AND',
			    			array(
			    					'key'     => 'knockouts_updated_date',
							        'value'   => $todays_date,
							        'compare' => '!=',
			    				),
			    			array(
			    					'key'     => 'pi_id',
							        'value'   => 0,
							        'compare' => '>',
			    				)
	    			)
		);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;

		

/*
	//get all pi-knockouts
	$args = array(
	    'post_type' => 'pi-knockouts',
	    'posts_per_page' => 100,
	   // 'include' => array(3866)
	);
	$knockouts = get_posts($args);
*/


	if(count($knockouts) > 0)
	{
		foreach ($knockouts as $k_knockout => $v_knockout) {
			$pi_id = get_field( "pi_id", $v_knockout->ID );
			$last_updated = get_post_meta($v_knockout->ID, 'knockouts_updated_date', true );
			$url = getApiUrl($pi_id);

		    if($todays_date > $last_updated && $pi_id != '') {
		    	$jsondata = getResponse($url);

		    	if($jsondata)
		    	{
		    		file_put_contents($dir.'/ko-json-cache/'.$v_knockout->post_name.'_'.$pi_id.'.json', $jsondata);
		    		update_post_meta($v_knockout->ID, 'knockouts_updated_date', $todays_date );
		    		updateKoPost($jsondata, $v_knockout->ID);
		    		purgeKoPageCache($v_knockout->ID);
		    		
		    	}
		    	else
		    	{
		    		echo '<p style="color: #f50016;">Error Fetch data from API. Please contact developer to check script :- <a href="'.$post_link.'" >'.$post_link.'</a></p>';
		    	}
	    		
	    		
		    }else if(!file_exists($dir.'/ko-json-cache/empty_data.json') && $pi_id == ''){
		    	$jsondata = '';
		    	file_put_contents($dir.'/ko-json-cache/empty_data.json', $jsondata);
		    }

		    $filepath = $dir.'/ko-json-cache/'.$v_knockout->post_name.'_'.$pi_id.'.json';
		    clearMeta($filepath, $v_knockout->ID);

		    $post_link = get_permalink($v_knockout->ID);


		    if($pi_id == ''){
		    	echo '<p style="color: #FFA500;">Please update Pharmacodia ID for :- <a href="'.$post_link.'" >'.$post_link.'</a></p>';
		    }else if(file_exists($filepath) && $pi_id != '' && $jsondata == ''){
		    	echo '<p style="color: #b39011;">Skipping API for the Knockout which was already updated today :- <a target=_BLANK href="'.$post_link.'" >'.$post_link.'</a></p>';
		    }else if(file_exists($filepath) && $pi_id != '' && $jsondata != ''){
		    	echo '<p style="color: #00ab5b;">Knockout Json cache updated successfully for :- <a target=_BLANK href="'.$post_link.'" >'.$post_link.'</a></p>';
		    }else if(!file_exists($filepath) && $pi_id != ''){
		    	echo '<p style="color: #f50016;">Failed to update Knockout for :- <a href="'.$post_link.'" >'.$post_link.'</a></p>';
		    }
		} 
	}
	else
	{
		echo '<p style="color: #00ab5b;">All Knockout Json cache has been updated today. Killing the script itself.</p>';
	}


	reportKOs();
}



function purgeKoPageCache($post_id)
{
	# https://wpengine.com/support/cache/
	if (class_exists('wpecommon')) {
		wpecommon::purge_varnish_cache($post_id);
	}
}

function getResponse($url){

	$curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL            => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT_MS     => 0,
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
	/*$resArr = json_decode($response);*/

    if($err) {
        echo $err;
    } else {
        $obj = json_decode( $response );
    	$jsondata = json_encode($obj->data[0], JSON_PRETTY_PRINT);
        return $jsondata;
    }
    curl_close($curl);

}

function getApiUrl($pi_id){	
	$time = strval( time() );
    $key  = "0db3b2c8f927fba263f3e63588199ab4";
    $sign = md5($time.$key);
    $url = "http://g.api.pharmacodia.com/bbctg/target?appid=CD-BBAST-2010&id=".$pi_id."&timespan=".$time."&sign=".$sign;

    return $url;
}

function updateKoPost($jsondata, $post_id){
	$converted_knockout = json_decode($jsondata);

	if(get_field("pi_drugs_launched", $post_id) != $converted_knockout->number_launched_druds){
		update_field('pi_drugs_launched', $converted_knockout->number_launched_druds, $post_id );
	}
}

function clearMeta($filepath, $id){
	if (!file_exists($filepath)) {
		update_post_meta($id, 'knockouts_updated_date', '', false );
	}
}


function reportKOs()
{
		$todays_date = date('m-d-Y');

		# Total Number of KOs
		$args = array(
			    'post_type' => 'pi-knockouts',
			    'posts_per_page' => -1,
			    'post_status' => 'publish',
			);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;
		echo '<p style="color: #0000FF;">Total Number Published KOs: '.count($knockouts).'</p>';


		# Total Number KOs with Pharmacodia ID
		$args = array(
			    'post_type' => 'pi-knockouts',
			    'posts_per_page' => -1,
			    'post_status' => 'publish',
			    'meta_query' => array(
			    			array(
			    					'key'     => 'pi_id',
							        'value'   => 0,
							        'compare' => '>',
			    				)
	    			)
			);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;
		echo '<p style="color: #0000FF;">Total Number KOs with Pharmacodia ID : '.count($knockouts).'</p>';


		# Total Number KOs Cached today before running this script
		$args = array(
			    'post_type' => 'pi-knockouts',
			    'posts_per_page' => -1,
			    'post_status' => 'publish',
				'meta_query' => array(
							'relation' => 'AND',
			    			array(
			    					'key'     => 'knockouts_updated_date',
							        'value'   => $todays_date,
							        'compare' => '=',
			    				),
			    			array(
			    					'key'     => 'pi_id',
							        'value'   => 0,
							        'compare' => '>',
			    				)
	    			)
			);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;
		echo '<p style="color: #0000FF;">Total Number KOs Cached today : '.count($knockouts).'</p>';


		# Total Number KOs remaining to be cached today
		$args = array(
			    'post_type' => 'pi-knockouts',
			    'posts_per_page' => -1,
			    'post_status' => 'publish',
				'meta_query' => array(
							'relation' => 'AND',
			    			array(
			    					'key'     => 'knockouts_updated_date',
							        'value'   => $todays_date,
							        'compare' => '!=',
			    				),
			    			array(
			    					'key'     => 'pi_id',
							        'value'   => 0,
							        'compare' => '>',
			    				)
	    			)
			);

		$data = new WP_Query( $args );
		$knockouts = $data->posts;
		if(count($knockouts)>0){ $remaining = count($knockouts); }else{ $remaining = 0; }
		echo '<p style="color: #0000FF;">Total Number KOs remaining to be cached today : '.$remaining.'</p>';
}

