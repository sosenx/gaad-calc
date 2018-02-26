<?php 
namespace gcalc\db;


class api_user {

	private $access;
	private $apikey;
	private $apisecret;
	private $authorization;
	private $credentials;

	function __construct( string $apikey, string $apisecret, string $authorization ){
		$this->apikey = $apikey;
		$this->apisecret = $apisecret;
		$this->authorization = $authorization;
		$this->aquire();
		return $this;
	}

	public function login(){
		$authorization = explode( " ", $this->authorization );
		$auth = base64_decode( $authorization[1] );
		$user = explode(":", $auth );

		$apikey_  = hash( "sha256", $this->get_apikey() );
		$apisec_  = hash( "sha256", $this->get_apisecret() );

		$access_credentials = $this->get_access_credentials( $apikey_ . $apisec_ );
		if ( !is_null( $access_credentials ) ) {
			$token = $access_credentials['credentials']['token'];
			unset( $access_credentials['credentials']['token'] );
			$u = $this->get_users();
			if ( array_key_exists( $token, $u ) ) {
				if($u[ $token ][ $user[ 0 ] ][ 'pwd' ] == $user[ 1 ]){
					// login succesful				
					$this->credentials = array(
						"login" => $user[ 0 ],
						"access_level" => $access_credentials['credentials']['access_level']
					);
					return true;
				} 
			} else {
				return false;
			}
		} else {
			return false;
		}
		return false;
	}

	private function get_apikey(){
		return $this->apikey;
	}


	public function get_credentials(){
		return $this->credentials;
	}


	private function get_users(){
		return $this->users;
	}

	private function get_apisecret(){
		return $this->apisecret;
	}


	private function get_access_credentials( string $hash ){
		if ( array_key_exists( $hash, $this->access ) ) {
			return $this->access[ $hash ];
		}
	}


	private function aquire(){

		$this->access = array(
			'ce4b3733db41a7b795350b7067a3debcf0e85a0e4f84c83ff0ae2e8808f240da39724ea9b6970b47756bbf54d5f401681d042fb96867905604d790257be4d217' => array(
				"credentials" => array(	
					"type" => "master",
					"access_level" => 10,
					"token" => "b7067a3debcf0e85a0e4f84c83ff0ae2e880"
				)
			),
			'2f183a4e64493af3f377f745eda502363cd3e7ef6e4d266d444758de0a85fcc85d7aa298a260a5f7e79768bde962669d943d4f769cc0579ae816c9c73460cab4' => array(
				"credentials" => array(	
					"type" => "anonymous",
					"access_level" => 0,
					"token" => "ef6e4d266d444758de0a85fcc85d7aa2"
				)
			)
		);


		$this->users = array(
			"b7067a3debcf0e85a0e4f84c83ff0ae2e880" => array(
				"gaad" => array( "pwd" => "koot123" )
			),
			"ef6e4d266d444758de0a85fcc85d7aa2" => array(
				"*" => array( "pwd" => "" )
			)
		);

	}




}


