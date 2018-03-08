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