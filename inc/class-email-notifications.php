<?php
namespace gcalc\calculations;

//$production_formats = new \gcalc\db\production\formats();

class email_notifications extends \gcalc\email_notifications {



	public function __construct( array $post_data, \WP_User $user ){
		parent::__construct( $post_data, $user );
	}



	public function send( array $settings = NULL ) {
		//var_dump( $settings);
	}






}