<?php
namespace gcalc;



class email_notifications{

	private $post_data;

	public function __construct( array $post_data ){
		$this->set_post_data( $post_data );
		
	}


	/**/
	function set_post_data( array $post_data ){
		$this->post_data = $post_data;
	}
	
	/**/
	function get_post_data( ){
		return $this->post_data;
	}
}