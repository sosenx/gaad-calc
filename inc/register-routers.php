<?php 
namespace gcalc;




	add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/model', array(
	    'methods' => 'GET',
	    'callback' => 'gcalc\rest::app_model',
	  ) );
	} );




	add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/c', array(
	    'methods' => 'GET',
	    'callback' => 'gcalc\rest::rest_calculate_callback',
	  ) );
	} );





//archives calc
add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/ac', array(
	    'methods' => 'PUT',
	    'callback' => 'gcalc\rest::put_acalculation',
	  ) );
	} );


//Contractor notification email send
add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/scnot', array(
	    'methods' => 'POST',
	    'callback' => 'gcalc\rest::send_contractor_notification_email',
	  ) );
	} );




//archives calc
add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/ac', array(
	    'methods' => 'GET',
	    'callback' => 'gcalc\rest::get_acalculations',
	  ) );
	} );


//archives calc raports
add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/acr', array(
	    'methods' => 'GET',
	    'callback' => 'gcalc\rest::get_acalculations_raports',
	  ) );
	} );





	add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/test', array(
	    'methods' => 'GET',
	    'callback' => 'gcalc\rest::rest_test_callback',
	  ) );
	} );



	add_action( 'rest_api_init', function () {
	  register_rest_route( 'gcalc/v1', '/auth', array(
	    'methods' => 'GET',
	    'callback' => 'gcalc\rest::rest_auth_callback',
	  ) );
	} );



 ?>