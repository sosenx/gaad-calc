<?php 
namespace gcalc;


abstract class call_stack{

	/**
	* Processes list
	*/
	private $plist;

	/**
	* Done status
	*/
	private $pdone;

	/**
	* Process attributes
	*/
	private $pa;

	/**
	* Process name
	*/
	private $name;

	/**
	* Total
	*/
	private $total;




	public function __construct( array $cpdata ){	
		$this->plist = $cpdata;
	}


	public function add( cprocess $cprocess ){	
		$R=1;
	}

	

}


?>