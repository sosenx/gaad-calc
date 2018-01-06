<?php 
namespace gcalc;


/**
*
*
*
*/
abstract class calc_product{
	/**
	* Tax info object
	*/
	private $tax;
	/**
	* Ship info object
	*/
	private $ship;
	/**
	* Production processes to calculate
	*/
	private $todo;
	/**
	* Base variables for calculation
	*/
	private $bvars;
	/**
	* Markup info object
	*/
	private $markup;
	/**
	* Total cost string equasion to eval
	*/
	private $costeq;
	/**
	* Reference to assosiated with calculation shop product object
	*/
	private $product_id;
	/**
	* Unique calculation id
	*/
	private $CID;
	/**
	* Array stores all calculations details
	*/
	private $calculation_array;

	/**
	* Class constructor
	*/
	function __construct( array $product_attributes, int $product_id = NULL ) {

		$this->bvars = $product_attributes;
		$this->product_id = $product_id;
		$this->CID = uniqid();
		$this->todo = new call_stack;

		return $this;
	}


	/**
	* getter for calculation_array
	*/
	function get_calculation_array(){

	}

	/**
	* getter for CID
	*/
	function get_CID(){
		return $this->CID;
	}

	/**
	* getter for PID
	*/
	function get_PID(){
		return $this->product_id;
	}



}



 ?>