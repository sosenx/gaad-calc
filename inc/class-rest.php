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
	*  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
	*  origin.
	*
	*  In a production environment, you probably want to be more restrictive, but this gives you
	*  the general idea of what is involved.  For the nitty-gritty low-down, read:
	*
	*  - https://developer.mozilla.org/en/HTTP_access_control
	*  - http://www.w3.org/TR/cors/
	*
	*/
	static public function cors() {

	    // Allow from any origin
	    if (isset($_SERVER['HTTP_ORIGIN'])) {
	        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	        // you want to allow, and if so:
	        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	        header('Access-Control-Allow-Credentials: true');
	        header('Access-Control-Max-Age: 86400');    // cache for 1 day
	    }

	    // Access-Control headers are received during OPTIONS requests
	    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	            // may also be using PUT, PATCH, HEAD etc
	            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");	        
	    }	    
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
		$data_permissions_f = new data_permissions_filter( $calc );
			
		$r = array( 
			'plugin_name' => "gcalc",
			'handler' => "app_model",
			'status' => 200,
			'headers' => $h,
			'output' => array( "Dupa" )
			//$data_permissions_f->get()
		);
		return json_decode(json_encode( $r ));
	}

	public static function rest_calculate_callback( $data = NULL ){
<<<<<<< HEAD
		\gcalc\rest::cors();
=======
		gcalc\rest::cors();
>>>>>>> e13d0875147b9f30ee45bb9ed3ecc1feac044ac8
		$h = \gcalc\rest::getHeaders( "/^pa_.*|^product_.*|^group_.*|apikey|apisecret|Authorization/", true ); 
		$product_id = \gcalc\rest::getHeaders( "/product_id/" );	
		$product_id = count( $product_id ) == 0 ? NULL : (int) $product_id[ "product_id" ];
		$calc = new calculate( $h['selected'], $product_id );
		$data_permissions_f = new data_permissions_filter( $calc );
		$r = array( 
			'plugin_name' => "gcalc",
			'handler' => "app_model",
			'status' => 200,
			'product_id' => $calc->get_PID(),
			'calculation_id' => $calc->get_CID(),
			'headers' => $h,
			'output' => $data_permissions_f->get()
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
	 *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
	 *  origin.
	 *
	 *  In a production environment, you probably want to be more restrictive, but this gives you
	 *  the general idea of what is involved.  For the nitty-gritty low-down, read:
	 *
	 *  - https://developer.mozilla.org/en/HTTP_access_control
	 *  - http://www.w3.org/TR/cors/
	 *
	 */
	public static function cors() {

	    // Allow from any origin
	    if (isset($_SERVER['HTTP_ORIGIN'])) {
	        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	        // you want to allow, and if so:
	        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	        header('Access-Control-Allow-Credentials: true');
	        header('Access-Control-Max-Age: 86400');    // cache for 1 day
	    }

	    // Access-Control headers are received during OPTIONS requests
	    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	            // may also be using PUT, PATCH, HEAD etc
	            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	        
	    }

	    
	}


	/**
	* Zwraca tablicę z nagówkami. Możliwe podanie jest wyrażenia regularnego jakie mają speniać klucze dodawanych nagówków.
	*
	* @param string regexp wyrażenie regularne jakie mają speniać nagówki. Jego brak spowoduje zwrócenie wszystkich nagówków.
	*
	* @return array 
	*/
	public static function getHeaders( $regexp = NULL, bool $return_rest = NULL ) {
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
