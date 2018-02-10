<?php 
namespace gcalc;

/*
* Abstract for actual calculation class attached to cprocess object
*
*/
abstract class cprocess_calculation{

	/**
	* Process name
	*/
	public $name;

	/**
	* Product full set of arguments
	*/
	private $cargs;

	/**
	* Process dependencies
	*/
	private $dependencies;

	/**
	* Process calculator
	*/
	private $calculator;

	/**
	* total
	*/
	private $ptotal;


	function __construct( array $product_attributes, int $product_id ){	

	}

	

}


?>