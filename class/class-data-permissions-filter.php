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
			$this->authorization = $calc->get_bvars()[ 'Authorization' ];
			
			
			if ( $this->get_request_credentials() ) {
				$this->total_ = $this->calc->get_total();
				$this->done_ = $this->calc->get_done();			
				$this->set_allowed_data();
				return $this;				
			}			
			
			return false;
		}


		public function set_allowed_data(){

		 

			$this->ALLOWED_DATA = 
				array(
					'c' => $this->credentials,
					'u' => $this->apikey,
					't' => $this->total_,
					'd' => $this->done_,
					'e' => $this->calc->get_errors()->get_data(),
					'a' => $this->calc->get_bvars()
				);

		}

		public function get(){
			//var_dump( 'GAAAAD', $this->ALLOWED_DATA );
			return $this->ALLOWED_DATA;
		}

		public function set_credetials( array $credentials ){
			$this->credentials = $credentials;
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