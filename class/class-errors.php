<?php 
namespace gcalc;

/**
*
*	Error codes:
*	4xxx - input data errors
*		4001 - No 
*
*
*
*
*/
class errors  {

	/**
	* errors storage
	*/
	private $errors = false;

	/**
	* errors storage
	*/
	private $data;

	/**
	* errors storage
	*/
	private $error_reporting = 0;


	/**
	* errors storage
	*/
	private $allowed_error_level = 3;

	/**
	* types of errors to report in seniority order from unimportant to fatal
	*/
	private $error_reporting_array = array( 'info', 'notice', 'attr_change', 'warning',  'fatal' );

	/**
	* current number of errors, warnings etc
	*/
	private $status_count = array( 'info' => 0, 'notice' => 0, 'warning' => 0, 'attr_change' => 0, 'fatal' => 0  );

	

	/**
	*
	*/
	public function __construct( array $data = NULL ){	
		$this->data = is_null( $data ) ? array() : $data ;

		return $this;
	}


	/**
	* Adds an error obj to data var
	*/
	public function add( \gcalc\error $error){	
		$error_reporting_array = $this->get_error_reporting_array();
		$error_reporting = $this->get_error_reporting();

		if ( array_search($error->type, $error_reporting_array) >= $error_reporting ) {
			array_push( $this->data, $error );
			$this->add_status_count( $error->type );
			$this->errors = true;
		}
		
	}

	/**
	* returns errors var as fast check if there are any errors at all
	*/
	public function add_status_count( string $index ){			
		if ( array_key_exists( $index, $this->status_count ) ) {
			$this->status_count[ $index ]++;	
		}		
	}

	/**
	* returns errors var as fast check if there are any errors at all
	*/
	public function fcheck(){	
		$error_reporting_array = $this->get_error_reporting_array();
		$error_reporting = $this->get_error_reporting();		
		$allowed_error_level = $this->get_allowed_error_level();
		$status_count = $this->get_status_count();
		$errors = 0;		

		$max = count( $error_reporting_array );
		for ($i=$error_reporting; $i < $max ; $i++) { 

			if ( $i > $allowed_error_level) {
				$errors += $status_count[ $error_reporting_array[ $i ] ];
			} 
			
		}

		$this->errors = $errors == 0 ? false : $errors;
		return $this->errors;
	}


	/**
	* returns errors var as fast check if there are any errors at all
	*/
	public function get_data(){			
		$errors = array();
		$error_reporting_array = $this->get_error_reporting_array();
		$error_reporting = $this->get_error_reporting();

		foreach ($this->data as $key => $value) {			
			$index = array_search( $value->type, $error_reporting_array);
			if ( $index >= $error_reporting) {
				array_push( $errors, $value);
			}			
		}
		return array(
			'info' => $this->get_status_count(),
			'errors' => $errors
		);
	}



	/**
	* returns errors var as fast check if there are any errors at all
	*/
	public function get(){			
		return $this;
	}


	/**
	* returns error_reporting_array
	*/
	public function get_error_reporting_array(){			
		return $this->error_reporting_array;
	}


	/**
	* returns error_reporting level
	*/
	public function get_error_reporting(){			
		return $this->error_reporting;
	}

	/**
	* returns error_reporting level
	*/
	public function get_allowed_error_level(){			
		return $this->allowed_error_level;
	}


	/**
	* returns error_reporting level
	*/
	public function get_status_count(){			
		return $this->status_count;
	}





}


?>