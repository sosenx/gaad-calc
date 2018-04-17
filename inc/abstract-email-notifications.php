<?php
namespace gcalc;

//$production_formats = new \gcalc\db\production\formats();

abstract class email_notifications{

	private $calculation;
	private $h;
	private $post_data;
	private $pdf_data;
	private $owner_user;


	public function __construct( array $data, \WP_User $user){
		$this->set_post_data( $data[ 'post_data' ] );
		$this->set_pdf_data( $data[ 'pdf_data' ] );
		$this->set_owner_user( $user );
		$this->set_calculation( $data[ 'calculation' ] );
		$this->set_h( $data[ 'h' ] );
	}



	public function get_owner_footer(){
 		$user = $this->get_owner_user( );
		$avatar_filename = GAAD_PLUGIN_TEMPLATE_DIR . '/gravatars/avatar-'.$user->ID.'.jpg';
 		
 		//getting and storing gravatar image
 		if ( !is_file( $avatar_filename ) ) {
 			$avatar = \get_avatar( $user->ID ); 		
 			$matches = array();
			preg_match_all( '/src=\'(.*)\'/U', $avatar, $matches, \PREG_SET_ORDER, 0);
			$avatar_contents = file_get_contents( $matches[0][1] );		
			file_put_contents( $avatar_filename, $avatar_contents );
 		}
 		$owner_footer_content = \gcalc\actions::calculation_footer_content( $user );

		return $owner_footer_content['post_content'];
	}



	/**/
	function set_h( array $h ){
		$this->h = $h;
	}

	/**/
	function set_calculation(  $calculation ){
		$this->calculation = $calculation;
	}


	/**/
	function set_pdf_data( array $pdf_data ){
		$this->pdf_data = $pdf_data;
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

	/**/
	function get_pdf_data( ){
		return $this->pdf_data;
	}


	/**/
	function get_calculation( ){
		return $this->calculation;
	}

	/**/
	function get_h( ){
		return $this->h;
	}
}