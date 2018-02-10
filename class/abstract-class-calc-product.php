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
	* Matrix for calculation array. Helps working with protected/public types od calculations
	*/
	private $calculation_array_matrix;

	/**
	* Class constructor
	*/
	function __construct( array $product_attributes, int $product_id = NULL ) {
		
		if ( !empty( $product_attributes ) ) {		
			$this->bvars = $product_attributes;
			$this->product_id = $product_id;
			$this->CID = uniqid();
			$this->todo = new todo_list( $this->generate_todo_list() );
			$this->markup = new product_markup( $this->bvars, $this->product_id );
			$this->tax = new product_tax( $this->bvars, $this->product_id );
			$this->ship = new product_shipment( $this->bvars, $this->product_id );
		}
		return $this;
	}


	/**
	* 
	*/
	function generate_todo_list(){


		foreach ($this->bvars as $key => $value) {
			$pa_class_name = '\gcalc\pa_\\' . str_replace( "pa_", "", $key );
			if ( class_exists( $pa_class_name ) ) {
				$pa_obj = new $pa_class_name( $this->bvars );
				$this->todo->add( $pa_obj );
				$r=1;
			}
		}
		
	}


	/**
	* getter for calculation_array
	*/
	function get_calculation_array(){
		return $this->calculation_array;
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



	/**
	* setter for calculation_array (brutal array overwriting, not recomended in common use, specific cases only)
	*
	* To manage parts of $calculation_array use other more sophisticated methods like set_calculation_array_part.
	*
	* @param array $calculation_array
	*/
	public function set_calculation_array( array $calculation_array ){
		$this->calculation_array = $calculation_array;
	}

	

	/**
	* setter for calculation_array (brutal array overwriting, not recomended in common use, specific cases only)
	*
	* To manage parts of $calculation_array use other more sophisticated methods like set_calculation_array_part.
	*
	* @param array $calculation_array
	*/
	public function set_calculation_array_part( string $name, array $calculation_array_part, string $mode = "public" ){
		
		/*
		* Need some atention here and do some work with permission check
		*/
		$this->calculation_array[ $mode ][ $name ] = $calculation_array_part;


	}

	

	/**
	* Sets all parts of current calculation.
	*
	* 	
	*/
	public function create_calculation_array_matrix(){
		/*
		* Public and private sets of date for more complex frontend managament
		*/
		$calculation_array_matrix = array(
			"public" => array(
				'calc' => array()
			),
			"auth" => array(
				'calc_details' => array()
			)
		);
		return $calculation_array_matrix;
	}


}



 ?>