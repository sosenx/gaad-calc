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
	* Production processes groups to calculate
	*/
	private $todo_groups;
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
	private $best_production_format = array();

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
		}
		return $this;
	}




	/**
	* calc product
	*
	*/
	function calc(){

		$this->create_todos_groups();
		$this->validate_todos_groups();
		$this->generate_todo_list();
		$this->process_todo_list();
		return $this->done;
	}





	/**
	* Check if main calculation layers are present in each group
	* Main layers are format, paper
	*
	*/
	function validate_todos_groups(){
		$todo_groups = $this->get_todo_groups();

		foreach ( $todo_groups as $group_name => $group) {
			$ok = false;
			foreach ($group as $process_name => $process) {
				$pattern = '/pa_format|pa_'.$group_name.'_format/';
				if ( preg_match( $pattern, $process_name ) ) {
					$ok = true;
				}
			}

			if ( !$ok) {
				$todo_groups[ $group_name ][ 'pa_format' ] = array(
					'class_name' => 'pa_format'
				);	
			}

		}

		$this->todo_groups = $todo_groups;
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
		
		foreach ($calc_order as $group_name => $group) {
			foreach ($group as $i => $process_name) { 
				if ( $process_name === '*' ) {
					
					foreach ($plist as $key => $value) {
						if ( preg_match( '/pa_'.$group_name.'_.*/', $key) && !in_array( $key, $used )) {
							$process_name = $key;
							$process = $plist[ $process_name ]; 
							array_push( $todo, $process );
							array_push( $used, $process_name );
						}
					}

				}
				elseif ( array_key_exists( $process_name, $plist ) && !in_array( $process_name, $used ) ) {
					$process = $plist[ $process_name ]; 
					array_push( $todo, $process );
					array_push( $used, $process_name );
				} else {
					$r=1;
				}
			}
		}
		
		foreach ( $todo as $key => $value) {						
			array_push( $this->done, $value->do() );
		}

		return $this->done;
	}


	/**
	* Sorts todos into nested categorized lists
	*
	*/
	function create_todos_groups(){		
		$groups = array( 'master' => array() );
		$groups_str = array();

		//creating grounps or master group
		foreach ($this->get_bvars() as $key => $value) {
			$match = array();
			if( preg_match( '/group_(.*)/', $key, $match ) ){
				$groups[$match[1]] = array();
				$groups_str[] = $match[1];
				foreach ($this->bvars as $key2 => $value2) {
					$match2 = array();
					if ( preg_match( '/pa_' . $match[1] . '_(.*)/', $key2, $match2 ) ) {						
						$class_name = str_replace( $match[1] . '_', '', $match2[0] );
						$groups[ $match[ 1 ] ][ $key2 ]['class_name'] = $class_name;						
					}
				}				
			} 
		}

		/*
		* Master group
		*/
		$groups_str = implode( '|', $groups_str );
		foreach ($this->bvars as $key => $value){
			if( ! preg_match( '/pa_['. $groups_str .')]{2,}(.*)/', $key) && ! preg_match('/group_/', $key) ){
				$class_name = $key;
				$groups[ 'master' ][$key]['class_name'] = $class_name;				
			} 
		}

		$this->todo_groups = $groups;		
	}

	/**
	* Generates process stack based on passed product attributes
	*
	* This list is a template classes array for further analisys and moderation. Actual calculations are managed elswhere.	 
	*
	*/
	function generate_todo_list(){
		$todo = array();
		$used = array();


		//calculating formats
		foreach ($this->todo_groups as $group_name => $value) {
			$group_process_name = 'pa_' . $group_name . '_format';
			$pa_class_name = '\gcalc\pa\\' . 'pa_' . $group_name . '_format'; //format process class name			
			if ( class_exists( $pa_class_name ) ) {
				$new_todo =
						new $pa_class_name( $this->bvars, $this->product_id, $this, array( $group_name,  $group_process_name ) );				
					
			} else {

				$pa_class_name = '\gcalc\pa\\pa_format'; //format process class name
				if ( class_exists( $pa_class_name ) ) {									
					$new_todo =
						new $pa_class_name( $this->bvars, $this->product_id, $this, array( $group_name,  $group_process_name ) );				
					} 
			}
			$todo[ $group_process_name ] = $new_todo;
			array_push( $used, $group_process_name );
		}

		foreach ($this->todo_groups as $group_name => $group) {
			foreach ($group as $process_name => $process) {
				$process_name = 'pa_' . $group_name .'_' . str_replace( array( $group_name .'_', 'pa_'), array('', ''), $process_name);	

				$pa_class_name = '\gcalc\pa\\' . $process['class_name'];

				if ( !in_array( $process_name, $used ) && class_exists( $pa_class_name ) ) {	
					$new_todo = new  $pa_class_name( $this->bvars, $this->product_id, $this, array( $group_name,  $process_name ) );

					$todo[ $process_name ] = $new_todo;				
					array_push( $used, $process_name );
				}		
			}
			
		}
		


		$this->todo->set_plist( $todo );				
		return $todo;
	}



	/**
	* Finds format class name
	*/
	function find_in_group( string $proceses_name, array $group_procesess ){
		foreach ($group_procesess as $key => $value) {
			if ( preg_match('/.*_'.$proceses_name.'/', $key)) {
				return $key;
			}
		}
		return $proceses_name;
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
	* getter bvars
	*/
	function get_bvars(){
		return $this->bvars;
	}


	/**
	* getter todo_groups
	*/
	function get_todo_groups(){
		return $this->todo_groups;
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
	public function set_best_production_format( $best_production_format, array $group){		
		$this->best_production_format[$group[0]] = $best_production_format;
	}


	/**
	* Getter best_production_format
	*/
	public function get_best_production_format( array $group ){		
		$production_formats = new \gcalc\db\production\formats();	

		if ( array_key_exists( $group[0], is_array($this->best_production_format) ? $this->best_production_format : array() ) ) {
			$group_name = $group[0];			
		}		
		$group_name = 'master';
		$best_production_format =  $this->best_production_format[ $group_name ];
		$best_production_format['format_sq'] = $best_production_format['width'] * $best_production_format['height'];

		$print_process = str_replace('__', '_', 'pa_' . str_replace( 'master', '', $group_name ) . '_print');
		$print_color_mode = $this->bvars[ $print_process ];
		
		$print_sides = $this->get_print_sides( $print_process );
		$click = $production_formats->get_click( 
			implode( "x", array($best_production_format['width'], $best_production_format['height']) ), $print_color_mode );
		$click_cost = $click[ $print_sides ];

		$best_production_format['print_color_mode'] = $print_color_mode;
		$best_production_format['print_cost'] = $click_cost;

$a =1;
		return $best_production_format;
	}


	/**
	* 
	*/
	function get_print_sides( string $print_process ){		
		$pa_print = $this->bvars[ $print_process ];
		$single = preg_match("/4x0|1x0/", $pa_print);
		$double = preg_match("/4x4|1x1/", $pa_print);
		return $double ? 1 : ( $single ? 0 : 1);		
	}


	/**
	* Getter todo
	*/
	public function get_todo( ){		
		return $this->todo;
	}


	/**
	* Getter parent
	*/
	public function get_parent( ){		
		return $this->parent;
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