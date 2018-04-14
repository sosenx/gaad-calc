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

	public static function get_acalculations(){
		$h = \gcalc\rest::getHeaders( "//", true )[ 'selected' ];	
		$calculations =  \gcalc\sql::calculations_get( );

		$r = array( 
			'plugin_name' 	=> "gcalc",
			'handler'     	=> "gut_acalculation",
			'status'      	=> $calculations ? 200 : 500,
			'headers'     	=> $h,
			'output' 		=> $calculations
		);

		return json_decode( json_encode( $r ) );
	}
/**
 * Write calculation in archives
 * @return [type] [description]
 */
	public static function put_acalculation(){
		global $post;
		$h = \gcalc\rest::getHeaders( "/c-slug|cid|contractor-email|contractor-nip|shipment-country|shipment-date|token|archive-notes/", true )[ 'selected' ];	
		
		$calculation =  \gcalc\sql::calculation_get( $h[ 'cid' ], $h[ 'token' ] );	

		if ( is_array( $calculation ) && !empty( $calculation ) ) {
			$put_data = \gcalc\sql::acalculations_insert( $h[ 'cid' ], $calculation, $h );					
			$token = $put_data[ 'token' ];
			$wp_post_data = \gcalc\actions::acalculations_insert_wp_post( $h[ 'cid' ], $calculation, $h );
		}

		$pdf = new \gcalc\pdf( $h[ 'cid' ], 'archives', array( $wp_post_data['post_content'] ) );
		$calculation_pdf = array(
			'contractor' => $pdf->calculation()
		);
		
		$r = array( 
			'plugin_name' 	=> "gcalc",
			'handler'     	=> "put_acalculation",
			'status'      	=> $calculation ? 200 : 500,
			'headers'     	=> $h,
			'output' 		=> $put_data,
			'token'      	=> $token,
			'pdf' 			=> $calculation_pdf
		);

		return json_decode( json_encode( $r ) );
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
		
/**
	 * Use * for origin
	 */
	\add_action( 'rest_api_init', function() {
	    
	  \remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	  \add_filter( 'rest_pre_serve_request', function( $value ) {
	    \header( 'Access-Control-Allow-Origin: *' );
	    \header('Access-Control-Allow-Credentials: true');
	    \header( 'Access-Control-Allow-Methods: GET' );
	    \header( 'Access-Control-Allow-Headers: apikey,apisecret,authorization,group_bw,group_color,group_cover,pa_bw_format,pa_bw_pages,pa_bw_paper,pa_bw_print,pa_color_format,pa_color_pages,pa_color_paper,pa_color_print,pa_color_stack,pa_cover_cloth_covering_paper,pa_cover_cloth_covering_print,pa_cover_cloth_covering_spot_uv,pa_cover_cloth_covering_finish,pa_cover_dust_jacket_paper,pa_cover_dust_jacket_print,pa_cover_dust_jacket_spot_uv,pa_cover_dust_jacket_finish,pa_cover_flaps,pa_cover_format,pa_cover_left_flap_width,pa_cover_paper,pa_cover_print,pa_cover_ribbon,pa_cover_right_flap_width,pa_cover_spot_uv,pa_cover_type,pa_cover_finish,pa_format,pa_multi_quantity,multi_quantity,pa_paper,pa_print,pa_quantity,pa_spot_uv,pa_finish,product_slug, pa_cover_board_thickness, pa_folding, markup_bw_print, markup_color_print, markup_cover_cloth_covering_print, markup_cover_dust_jacket_print, markup_cover_endpaper_print, markup_cover_paper, markup_cover_print, markup_cover_type, spine_shape ' );

	   // \gcalc\rest::cors();
	    return $value;
	    
	  });
	}, 15 );


		$h = \gcalc\rest::getHeaders( "/^pa_.*|^markup_.*|^product_.*|^group_.*|apikey|apisecret|Authorization/", true ); 
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

		$r[ 'output' ][ 'token' ] = $data_permissions_f->save_calculation()[ 'token' ];
		
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
	*
	*
	*/
	public static function rest_auth_callback( $data = NULL ){
		$h = \gcalc\rest::getHeaders( "/Authorization/", true ); 
		$r = array( 'plugin_name' => "gcalc\\rest::rest_test_callback" );
		
		$auth = $h['selected']['Authorization'];
		
		if ( isset( $auth ) ) {
			$decoded_auth = base64_decode( $auth );
			$splitted_auth = explode( ':', $decoded_auth );

			//var_dump( $splitted_auth );
			$login = $splitted_auth[0];
			$password = $splitted_auth[1];
			$apikey = base64_decode( $h['others']['Apikey'] );
			$apisecret = base64_decode( $h['others']['Apisecret'] );

			$user = new \gcalc\db\api_user( $apikey, $apisecret, $auth );
			
			$r['login'] = $user->login();
			$r['credentials'] = $user->get_credentials();

		}



		/*
		//
		$allh = getallheaders();
		$data = array( 'cokolwiek'=> $allh );
		
		//echo json_decode(json_encode( $data ));
		//echo json_encode( $data );
		die();
		*/

		return json_decode( json_encode( $r ) );
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
