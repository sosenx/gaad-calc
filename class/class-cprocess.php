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

	/**
	* done with no errors
	*/
	private $done = false;

	/**
	* parent object
	*/
	private $parent;


	
	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		$this->parent = $parent;
	}


	public function do( ){
		$this->ptotal = $this->calculator->do();
		$this->done = $this->calculator->get_done();
		return $this->ptotal;
	}

	
	

}


?>