<?php 
namespace gcalc;


/**
*
*
*
*/
class data_permissions_filter{
		/*
		* calculator
		*/
		private $calc;

		/*
		* logged user
		*/
		private $apikey;

		/*
		* apisecret
		*/
		private $apisecret;

		/*
		* Authorization header
		*/
		private $authorization;

		/*
		* access credentials
		*/
		private $credentials;

		/*
		* Original set of data
		*/
		private $total_;
		
		/*
		* Original set of done processes
		*/
		private $done_;

		/*
		* Filtered set of data
		*/
		private $ALLOWED_DATA;


		public function __construct( \gcalc\calc_product $calc ){
			$this->calc = $calc;
			$this->calc->calc();
			$this->authorization = $this->get_authorization();
			
			
			if ( $this->get_request_credentials() ) {
				$this->total_ = $this->calc->get_total();
				$this->done_ = $this->calc->get_done();			
				$this->set_allowed_data();
				return $this;				
			}			
			
			return false;
		}


		private function parse_total__access_level__10( array $data ){
			return $data;
		}

		private function parse_total__access_level__9( array $data ){
			return $data;
		}

		private function parse_total__access_level__1( array $data ){
			return $data;
		}

		private function parse_total__access_level__0( array $data ){
			return $data['total_cost_'];
		}





		private function parse_done__access_level__10( array $data ){
			return $data;
		}

		private function parse_done__access_level__9( array $data ){
			return $data;
		}

		private function parse_done__access_level__1( array $data ){
			return $data;
		}

		private function parse_done__access_level__0( array $data ){
			return array();
		}





		private function parse_errors__access_level__10( array $data ){
			return $data;
		}

		private function parse_errors__access_level__9( array $data ){
			return $data;
		}

		private function parse_errors__access_level__1( array $data ){
			return $data;
		}

		private function parse_errors__access_level__0( array $data ){
			return $data;
		}




		//www
		private function parse_total__access_level__2( array $data ){
			return $data['total_cost_'];
		}

		private function parse_done__access_level__2( array $data ){
			return array();
		}

		private function parse_errors__access_level__2( array $data ){
			return $data;
		}


		//inner
		private function parse_total__access_level__5( array $data ){
			return $data['total_cost_'];
		}

		private function parse_done__access_level__5( array $data ){
			return array();
		}

		private function parse_errors__access_level__5( array $data ){
			return array();
		}


		private function parse_bvars__access_level__0( array $data ){
			return $data;
		}
		private function parse_bvars__access_level__1( array $data ){
			return $data;
		}
		private function parse_bvars__access_level__2( array $data ){
			return $data;
		}
		private function parse_bvars__access_level__5( array $data ){
			return array();
		}
		private function parse_bvars__access_level__9( array $data ){
			return $data;
		}
		private function parse_bvars__access_level__10( array $data ){
			return $data;
		}

/*
		private function parse_credentials__access_level__0( array $data ){
			return $data;
		}
		private function parse_credentials__access_level__1( array $data ){
			return $data;
		}
		private function parse_credentials__access_level__5( array $data ){
			return array();
		}
		private function parse_credentials__access_level__9( array $data ){
			return $data;
		}
		private function parse_credentials__access_level__10( array $data ){
			return $data;
		}



*/



		private function parse_( array $data, string $mode = NULL ){
			$mode = is_null( $mode ) ? 'total' : $mode; 
			$credetials = $this->get_credetials();

			//no credentials, no fun, escaping
			if ( is_null( $credetials ) ) {				
				return new \gcalc\error( 500 );
			}

			$access_level = $credetials['access_level'];
			$fn_name = 'parse_'. $mode .'__access_level__'.$access_level;
			if ( method_exists( $this, $fn_name )) {
				return $this->$fn_name( $data );	
			}

			return new \gcalc\error( 535, '('.$fn_name.')' );						
		}

		/*
		* Last touch before data is sent
		*
		*/
		private function sort_allowed_data( array $d ){
			$d = $this->sort_multi_quantity_data( $d );
			return $d;
		}

		/*
		* Last touch before data is sent
		*
		*/
		private function sort_multi_quantity_data( $d ){
			$bvars = $this->calc->get_bvars();
			if ( array_key_exists( 'pa_multi_quantity', $bvars ) ) {
				//$pa_multi_quantity = $bvars['pa_multi_quantity'];
				$access_level = $this->credentials['access_level'];	
				
				if ( $access_level > 0 ) {
					foreach ( $d['d'] as $key => $value ) {
						if ( $value->total['name'] == 'pa_multi_quantity' || $value->total['name'] == 'pa_master_multi_quantity' ) {							
							$d['tmq'] = $value;
							unset( $d['d'][ $key ] );
							break;
						}
					}	
				}
				
			}
			
			return $d;
		}

		public function save_calculation(){
			$credetials = $this->get_credetials();
			$autosave = \gcalc\GAAD_PLUGIN_TEMPLATE_AUTOSAVE_CALCULATIONS_TYPES;
			$save_type = strlen($autosave) >= 1 ? array_filter( explode( ',', $autosave ) ) : 2;

			if ( in_array( (int)$credetials['access_level'], $save_type) ) {
				$user = $this->get_credetials();
				\gcalc\sql::calculations_insert( $this->calc->get_CID(), $this->calc->get_bvars(), $user, $this->total_ );
			} else {
				$this->calc->get_errors()->add( new error( 10103 ) );
				$this->set_allowed_data();
			}	

			return $this->get();		
		}

		public function set_allowed_data(){
			$this->ALLOWED_DATA = 
			$this->sort_allowed_data(
				array(					
					't' => $this->parse_( $this->total_ ),
					'q' => $this->calc->get_bvar( 'pa_master_quantity' ),

					'd' => $this->parse_( $this->done_, 'done' ),
					'e' => $this->parse_( $this->calc->get_errors()->get_data(), 'errors'),
					'a' => $this->parse_( $this->calc->get_bvars( true ), 'bvars'),

				//	'c' => $this->parse_( $this->credentials, 'credentials'),
					//'u' => $this->apikey,
				)
			);	

		}

		public function get(){		
			if ( is_null( $this->ALLOWED_DATA ) ) {
				$this->ALLOWED_DATA = array(
					'e' => $this->parse_( $this->calc->get_errors()->get_data(), 'errors')
				);
			} 
			return $this->ALLOWED_DATA;
		}

		public function get_authorization(){
			$authorization = array_key_exists( 'Authorization' , $this->calc->get_bvars() ) ? $this->calc->get_bvars()[ 'Authorization' ] : false;
			if ( !$authorization ) {
				$this->calc->get_errors()->add( new \gcalc\error( 10102 ) );
				return "Basic Kjo=";
			}
			return $authorization;
		}

		public function set_credetials( array $credentials ){
			$this->credentials = $credentials;
		}

		public function get_credetials(){
			return $this->credentials;
		}

		private function get_request_credentials(){
			$this->apikey = $this->calc->get_api_key();
			$this->apisecret = $this->calc->get_api_secret();
			$this->user = new \gcalc\db\api_user( $this->apikey, $this->apisecret, $this->authorization );
			if ( $this->user->login() ) {
				$this->set_credetials( $this->user->get_credentials() );
				return true;
			}
			$this->calc->get_errors()->add( new \gcalc\error( 500 ) );
			return false;
		}



}