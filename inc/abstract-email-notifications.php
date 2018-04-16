<?php
namespace gcalc;

//$production_formats = new \gcalc\db\production\formats();

abstract class email_notifications{

	private $post_data;
	private $owner_user;


	public function __construct( array $post_data, \WP_User $user ){
		$this->set_post_data( $post_data );
		$this->set_owner_user( $user );
	}











	/**/
	function set_owner_user( \WP_User $owner_user ){
		$this->owner_user = $owner_user;
	}

	/**/
	function set_post_data( array $post_data ){
		$this->post_data = $post_data;
	}
	
	/**/
	function get_post_data( ){
		return $this->post_data;
	}

	/**/
	function get_owner_user( ){
		return $this->owner_user;
	}
}