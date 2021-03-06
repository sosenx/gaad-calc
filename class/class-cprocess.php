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
	private $cargs = array();

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

	/**
	* Process group array
	*/
	private $group;


	/**
	* Process group array
	*/
	private $errors = false;

	
	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group ){	
		
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
	}


	public function do__( ){
		$this->ptotal = $this->calculator->do__();
		$this->done = $this->calculator->get_done();
		return $this->ptotal;
	}

	/**
	*
	*/
	function get_carg( $arg_name ){
		if ( !array_key_exists( $arg_name, $this->cargs ) ) {
			$arg_name = str_replace( '_master', '', $arg_name);
			if ( array_key_exists( $arg_name, $this->cargs ) ) {
				return $this->cargs[ $arg_name ];
			}
		} else return $this->cargs[ $arg_name ];
		return null;
	}

	/**
	* Setter for errors
	*/
	public function set_errors( $value ){
		$this->errors = $value;
	}

	/**
	* Setter for errors
	*/
	public function set_carg( $name, $value ){
		$this->cargs[ $name ] = $value;
	}
	
	/**
	* Setter for errors
	*/
	public function set_cargs( $cargs ){
		$this->cargs = $cargs;
	}


	/**
	* Getter for errors
	*/
	public function ok( ){
		return !$this->errors;
	}
	


	/**
	 * Getter for parent
	 * @return [type] [description]
	 */
	function get_parent( ){
		return $this->parent;
	}

	
}


?>