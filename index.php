<?php
/*
Plugin Name: Custom Search Plugin
Description: This plugin searches for something from the website.
*/


add_shortcode('Plugin_Shortcode', '_plugin_function_');
function _plugin_function_() {
	$content = "
		<div id='main' style='margin-bottom: 10px'>
			<input type='text' placeholder='Search' id='plugin-search-input' />
			<button id='plugin-search-btn'>Search</button>
		</div>
		<div id='results'>
		</div>
	";
	
	return $content;
}



add_action( 'wp_ajax_search_posts_function', 'search_posts_function');
function search_posts_function(){
	$content = "";
	global $wpdb;
	$table = $wpdb->prefix . "posts";
	
	$input = $_POST['input'];
	$input = strtolower($input);
// 	$input = '%' . $input . '%';
	
	
	
	$sql = $wpdb->prepare(
    "SELECT * FROM ".$table." WHERE LOWER(post_title) LIKE %s OR LOWER(post_content) LIKE %s",
    '%' . $wpdb->esc_like( $input ) . '%',
	'%' . $wpdb->esc_like( $input ) . '%'
	);
	$rows = $wpdb->get_results($sql);
	
	
// 	$query = "SELECT * FROM ".$table." WHERE LOWER(post_title) LIKE '".$input."' OR LOWER(post_content) LIKE '".$input."'";
	
// 	$rows = $wpdb->get_results($query);
	if($rows) {
		echo json_encode($rows);
		foreach($rows as $row) {
			$key1 = 'guid';
			$key2 = 'post_title';
			$link = $row->$key;
			$title = $row->$key2;
		}
	}
	die();
}










function plugin__scripts() {
    wp_enqueue_script( 'frontend-ajax', plugins_url( 'js/demo.js?x=' . rand(), __FILE__ ), array('jquery'), null, true );
    wp_localize_script( 'frontend-ajax', 'frontend_ajax_object',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ))
    	);
	wp_enqueue_script('bootstrap-js', 'https://code.jquery.com/jquery-3.2.1.slim.min.js');
	wp_enqueue_script('bootstrap-js2', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
	wp_enqueue_script('bootstrap-js3', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js');
	wp_enqueue_script('jquery1', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
	wp_enqueue_style('main-styles', plugins_url( 'css/style.css' , __FILE__ ), array(), rand(), false);
}
add_action( 'wp_enqueue_scripts', 'plugin__scripts' );




?>