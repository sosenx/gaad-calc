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




	public function __construct( $cpdata ){	
		$this->plist = $cpdata;
	}


	public function add( cprocess $cprocess ){	
		$R=1;
	}


	/**
	* Getter for plist
	*/
	public function get_plist( ){	
		return $this->plist;
	}


	/**
	* Setter for plist
	*/
	public function set_plist( $plist ){	
		$this->plist = $plist;
	}

	

}


?>