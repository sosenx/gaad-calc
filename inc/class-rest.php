<?php 
namespace gcalc;


class rest{

	/**
	* Auth method, blank
	*
	* @return bool 
	*/
	public static function api_client_auth(){
		return true;
	}	


	/**
	* Zwraca gówny model aplikacji.
	*
	* @return string 
	*/
	public static function app_model( ){ return '{}';
		global $post;
		$h = \gcalc\rest::getHeaders( "/^pa_.*/", true );
		$product_id = \is_single('product') ? $post->ID : -1;
		$calc = new calculate( $h['selected'], $product_id );
		$r = array( 
			'plugin_name' => "gcalc",
			'handler' => "app_model",
			'status' => 200,
			'headers' => $h,
			'output' => $calc->calc()
		);
		return json_decode(json_encode( $r ));
	}

	public static function rest_calculate_callback( $data = NULL ){
		$h = \gcalc\rest::getHeaders( "/^pa_.*/", true );
		$product_id = \gcalc\rest::getHeaders( "/product_id/" );	
		$product_id = count( $product_id ) == 0 ? -1 : (int) $product_id[ "product_id" ];
		$calc = new calculate( $h['selected'], $product_id );
		
		$r = array( 
			'plugin_name' => "gcalc",
			'handler' => "app_model",
			'status' => 200,
			'product_id' => $calc->get_PID(),
			'calculation_id' => $calc->get_CID(),

			'headers' => $h,
			'output' => $calc->calc()
		);
		return json_decode(json_encode( $r ));
	}

	public static function rest_test_callback( $data = NULL ){
		$r = array( 'plugin_name' => "gcalc\\rest::rest_test_callback" );
		if(rest::api_client_auth()){
			return json_decode(json_encode( $r ));	
		} else{
			return json_decode(json_encode( array( "error" => "auth" ) ));	
		}
		
	}










	/**
	* Zwraca tablicę z nagówkami. Możliwe podanie jest wyrażenia regularnego jakie mają speniać klucze dodawanych nagówków.
	*
	* @param string regexp wyrażenie regularne jakie mają speniać nagówki. Jego brak spowoduje zwrócenie wszystkich nagówków.
	*
	* @return array 
	*/
	public static function getHeaders( string $regexp = NULL, bool $return_rest = NULL ) : array {
		/*
		* Headers to return array
		*/
		$h = array();
		/*
		* Headers that doesn't match criteria array
		*/
		$rh = array();
		/*
		* All Headers in a request
		*/
		$allh = getallheaders();

		if ( !empty( $allh ) ) {
			foreach ($allh as $key => $value) {				
				if ( preg_match( $regexp, $key) ) {
					$h[$key] = $value;
				} elseif( $return_rest) {
					$rh[$key] = $value;	
				}
			}
		}

		return $return_rest ? array( 'selected' => $h, 'others' => $rh ) : $h;
	}
	
}

?>
