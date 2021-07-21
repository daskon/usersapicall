<?php

//add_action('wp_print_scripts', 'ajax_call');

//function ajax_call() {
        
    // if( 'index.php' != $hook ) {
    //     return;
    // }

    // wp_register_script('ajax-script', 
    //     plugins_url('/js/user-ajaxcall.js', __FILE__), 
    //     array(), 
    //     false, 
    //     true 
    // );

    // wp_localize_script( 'ajax-script', 'ajax_object',
    //         array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

//}


// add_action('wp_ajax_my_action', 'handle_ajax_request');
// add_action( 'wp_ajax_my_action', 'handle_ajax_request' );
// add_action( 'wp_ajax_nopriv_my_action', 'handle_ajax_request' );
// function handle_ajax_request() {
	
//   	if ( isset( $_POST["id"] ) ) {
		
// 		$response = $_POST["id"];
// 		echo $response;
// 		die();
// 	}
// }