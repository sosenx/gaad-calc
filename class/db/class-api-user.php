<?php 
namespace gcalc\db;


class api_user {

	private $access;
	private $apikey;
	private $apisecret;
	private $authorization;
	private $credentials;

	function __construct( $apikey, $apisecret, $authorization ){
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
				//var_dump($u[ $token ][ $user[ 0 ] ][ 'pwd' ] == $user[ 1 ]);
				if($u[ $token ][ $user[ 0 ] ][ 'pwd' ] == $user[ 1 ]){
					// login succesful				
					$this->credentials = array(

						"login" => $user[ 0 ],
						"access_level" => $access_credentials['credentials']['access_level']
					);

					return true;
				} else {

					return false;
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


	private function get_access_credentials( $hash ){
		if ( array_key_exists( $hash, $this->access ) ) {
			return $this->access[ $hash ];
		}

		return NULL;
	}


	private function aquire(){

		$this->access = array(
			/*
				Master
			*/
			'ce4b3733db41a7b795350b7067a3debcf0e85a0e4f84c83ff0ae2e8808f240da39724ea9b6970b47756bbf54d5f401681d042fb96867905604d790257be4d217' => array(
				"credentials" => array(	
					"type" => "master",
					"access_level" => 10,
					"token" => "b7067a3debcf0e85a0e4f84c83ff0ae2e880"
				)
			),

			'abcba81447bd6f196b362cdb722417d2109828256bc0446a416702dc536fd774ab592cced016023ce50b2cbf10adaa15cfebe7cd490aef16edbf4dfd6e3c6d71' => array(
				"credentials" => array(	
					"type" => "inner",
					"access_level" => 5,
					"token" => "ea97586b4aa0c141e4456912f3325f7f"
				)
			),

			'15d0a08f5c3dc14213e26f61136c33a0e0d29c61e8e6e3c281b09a92837f30268c86b48c428eeab4d0ea100f6da0c447eca5ca08793986392fdb7e6c83957a50' => array(
				"credentials" => array(	
					"type" => "www",
					"access_level" => 2,
					"token" => "b09a92837f30268c86b48c428eeab4d"
				)
			),



			'2f183a4e64493af3f377f745eda502363cd3e7ef6e4d266d444758de0a85fcc85d7aa298a260a5f7e79768bde962669d943d4f769cc0579ae816c9c73460cab4' => array(
				"credentials" => array(	
					"type" => "anonymous",
					"access_level" => 0,
					"token" => "ef6e4d266d444758de0a85fcc85d7aa2"
				)
			),

			'6e1b25b9b1af3119e67af7f37e8a3eb3a795de90228c302d86d57caa2a0e6e3dc372c995fe6f5daa244ab12f74e249660cd2d2e7adb168dd21ec1d0a6800957c' => array(
				"credentials" => array(	
					"type" => "account",
					"access_level" => 1,
					"token" => "9b945efebb006547a94415eadaa12921"
				)
			),

			'4aa8d6ce8e63f23b34e315bb90858185defa5438401bddc979bf399b802faaf29f9a2c89a3387c60d0a7ea9aca8ccb41d0353c5f1e8b5b3e20ffbf2dd6a2cc78' => array(
				"credentials" => array(	
					"type" => "admin",
					"access_level" => 9,
					"token" => "c788b7c03f6fa02031a8085a4c841670"
				)
			),



		);


		$this->users = array(
			//master
			"b7067a3debcf0e85a0e4f84c83ff0ae2e880" => array(
				"gaad" => array( "pwd" => "koot123" ),
				"admin" => array( "pwd" => "fthemes" )
			),
			//inner
			"ea97586b4aa0c141e4456912f3325f7f" => array(
				"*" => array( "pwd" => "" )
			),
			"ef6e4d266d444758de0a85fcc85d7aa2" => array(
				"*" => array( "pwd" => "" )
			),
			"9b945efebb006547a94415eadaa12921" => array(
				"wojtek" => array( "pwd" => "wojtek123" ),
				"gaad" => array( "pwd" => "koot123" ),
			),
			"c788b7c03f6fa02031a8085a4c841670" => array(
				"gaad" => array( "pwd" => "koot123" )				
			),
			"b09a92837f30268c86b48c428eeab4d" => array(
				"www" => array( "pwd" => "www" ),
				"gaad" => array( "pwd" => "koot123" )
			)

		);

	}

}