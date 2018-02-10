<?php 
namespace gcalc;


abstract class cprocess{

	/**
	* Process name
	*/
	public $name;

	/**
	* Calculating class
	*/
	private $cclass;

	/**
	* Product full set of arguments
	*/
	private $cargs;

	/**
	* Process dependencies
	*/
	private $dependencies;

	/**
	* total
	*/
	private $ptotal;


	function __construct( array $product_attributes, int $product_id ){	
		
	}

	

}


?>