<?php 
namespace gcalc;


class ptotal {

	/**
	* total
	*/
	public $total;

	/**
	* math sign for total equasion
	*/
	public $vsign;

	/**
	* anything that needs to be logged with total object
	*/
	public $log;

	/**
	* error object
	*/
	public $error;

	/**
	* success with no errors
	*/
	private $success = false;


	public function __construct( $total, $vsign, $error = NULL, $log = NULL ){	

		$this->total 	= $total;
		$this->vsign 	= $vsign;
		$this->error 	= $error;
		$this->log 		= $log;

		if ( $this->error == NULL) {
			$this->success = true;
		}

		return $this;
	}

}