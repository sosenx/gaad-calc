<?php 
namespace gcalc;


class error  {

	public $label;
	public $err;
	public $code;
	public $type;
	public $solution;



	/**
	*
	*/
	function __construct( int $code, string $msg = NULL ){	
		$codes = new \gcalc\db\error\codes();
		$error_data = $codes->get( $code );

		$this->code = $code;
		$this->label = array_key_exists( 'label', $error_data ) ? $error_data['label'] : 'Error code#'.$code;	
		$this->type = array_key_exists( 'type', $error_data ) ? $error_data['type'] : 'Unknown error type';	
		$this->err = array_key_exists( 'err', $error_data ) ? $error_data['err'] : 'Unknown error type';	

		if ( !is_null( $msg)) {
			$this->err .= $msg;
		}

		$this->solution = array_key_exists( 'solution', $error_data ) ? $error_data['solution'] : 'call administrator';	

		return $this;
	}



	

}


?>