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


		private function parse_( array $data, string $mode = NULL ){
			$mode = is_null( $mode ) ? 'total' : $mode; 
			$credetials = $this->get_credetials();
			$access_level = $credetials['access_level'];
			$fn_name = 'parse_'. $mode .'__access_level__'.$access_level;
			if ( method_exists( $this, $fn_name )) {
				return $this->$fn_name( $data );	
			}

			return new \gcalc\error( 400 );			
		}

		public function set_allowed_data(){
			$this->ALLOWED_DATA = 
				array(					
					't' => $this->parse_( $this->total_ ),
					'd' => $this->parse_( $this->done_, 'done' ),
					'e' => $this->parse_( $this->calc->get_errors()->get_data(), 'errors'),
					'a' => $this->calc->get_bvars(),

					'c' => $this->credentials,
					'u' => $this->apikey,
				);

		}

		public function get(){			
			return $this->ALLOWED_DATA;
		}

		public function get_authorization(){
			$authorization = array_key_exists( 'Authorization' , $this->calc->get_bvars() ) ? $this->calc->get_bvars()[ 'Authorization' ] : false;
			if ( !$authorization ) {
				$this->calc->get_errors()->add( new \gcalc\error( 10102 ) );
				return "*:";
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
			return false;
		}



}