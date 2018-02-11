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
	* Production processes done
	*/
	public $done = array();
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
	* Order that calculation needs to be done
	*/
	private $calc_order;

	/**
	* best_production_format object
	*/
	private $best_production_format;

	/**
	* Class constructor
	*/
	function __construct( array $product_attributes, int $product_id = NULL ) {
		
		if ( !empty( $product_attributes ) ) {		
			$this->bvars = $product_attributes;
			$this->product_id = $product_id;
			$this->CID = uniqid();
			$this->todo = new todo_list( array() );
			$this->markup = array();
			$this->tax = new product_tax( $this->bvars, $this->product_id );
			$this->ship = new product_shipment( $this->bvars, $this->product_id );
			$this->calc_order = new \gcalc\db\calc_order( $product_id );
			
			$this->generate_todo_list();
			$this->process_todo_list();
						

		}
		return $this;
	}




	/**
	* calc product
	*
	*/
	function calc(){
		
		return $this->done;
	}

	/**
	* calculates process stack 
	*
	*/
	function process_todo_list(){
		$todo = array();		
		$plist = $this->todo->get_plist();
		$used = array();
		$calc_order = $this->calc_order->get_order();
		
		foreach ( $calc_order as $key => $value) {
			if ( $value != "*") {
				$process = $plist[ $value ]; 
				array_push( $todo, $process );
				array_push( $used, $value );

			} else {
				foreach ( $plist as $key2 => $value2 ) {
					if ( !in_array( $key2, $used ) ) {
						$process = $plist[ $key2 ]; 
						array_push( $used, $key2 );
						array_push( $todo, $process );
					}
				}
				break;
			}
		}		
		
		foreach ( $todo as $key => $value) {			
			array_push( $this->done, $value->do() );
		}

		return $this->done;
	}


	/**
	* Generates process stack based on passed product attributes
	*
	* This list is a template classes array for further analisys and moderation. Actual calculations are managed elswhere.	 
	*
	*/
	function generate_todo_list(){
		$todo = array();

		foreach ($this->bvars as $key => $value) {
			$pa_class_name = '\gcalc\pa\\' . $key;
			if ( class_exists( $pa_class_name ) ) {				
				$todo[ $key ] = new $pa_class_name( $this->bvars, $this->product_id, $this );				
			} 
		}		
		$this->todo->set_plist( $todo );		
		return $todo;
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
	* setter best_production_format
	*/
	public function set_best_production_format( $best_production_format ){		
		$this->best_production_format = $best_production_format;
	}


	/**
	* Getter best_production_format
	*/
	public function get_best_production_format( ){		
		return $this->best_production_format;
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