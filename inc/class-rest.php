<?php 
namespace gcalc;


class rest{

	/*
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

	public static function app_model( $data = NULL ){
		$h = \gcalc\rest::getHeaders( "/^pa_.*/", true );		
		$r = array( 
			'plugin_name' => "gcalc",
			'handler' => "app_model",
			'status' => 200,
			'headers' => $h
		);
		return json_encode( $r );
	}

	public static function rest_test_callback( $data = NULL ){
		$r = array( 'plugin_name' => "gcalc\\rest::rest_test_callback" );
		return json_encode( $r );
	}
	
}

?>
