<?php 
namespace gcalc;

error_reporting( E_ALL - E_NOTICE);

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
	* Product slug name
	*/
	private $slug;

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
	*
	*/
	private $total_;

	/**
	*
	*/
	private $errors;

	/**
	*
	*/
	private $children = array();

	/**
	* Merges errors array with another object errors array
	*/
	public function merge_errors( array $errors, string $label ){
		$this_errors = $this->get_errors();
		foreach ($errors['errors'] as $key => $value) {
			$this_errors->add( new \gcalc\error( $value->code, ' ('.$label.')') );
		}

	}

	/**
	* getter gor total_
	*/
	public function get_total(){
		if ( is_array( $this->total_)) {
			return $this->total_;
		}
		return NULL;
	}

	/**
	* Merges errors array with another object errors array
	*/
	public function merge_bvars( \gcalc\calc_product $donor, string $recipient_group_name, string $recipient_sub_group_name  ){
		
		$donor_bvars = $donor->get_bvars();	
		$recipient_bvars = $this->get_bvars();	
		$name_pattern = 'pa_' . $recipient_group_name .'_' . $recipient_sub_group_name;
		$this->children[$name_pattern] = $donor->get_total();
		foreach ( $recipient_bvars as $key => $value ) {
			if ( preg_match('/'.$name_pattern.'/', $key ) ) {
				foreach ($donor_bvars as $key2 => $value2) {
					$bvar_name = preg_replace('/^pa_/', '', $key2);					
					if ( preg_match('/'.$bvar_name.'$/', $key) ) {
						$this->bvars[ $key ] = $value2;
					}
				}					
			}
		}		
	}


	public function status_ok(){
		return $this->get_errors()->fcheck() == 0;

	}

	/**
	* Class constructor
	*/
	function __construct( array $product_attributes, int $product_id = NULL ) {
		
		if ( !empty( $product_attributes ) ) {	

			$this->errors = new errors();
			$this->bvars = $product_attributes;
			$this->set_product_id( $product_id, $product_attributes );
			if ( $this->errors->fcheck() ) {
				return $this->errors->get();
			}
			$this->CID = uniqid();
			$this->todo = new todo_list( array() );
			$this->markup = array();
			$this->tax = new product_tax( $this->bvars, $this->product_id );
			$this->ship = new product_shipment( $this->bvars, $this->product_id );
			$this->calc_order = new \gcalc\db\calc_order( $this->get_product_id() );	
		}

		
		return $this;
	}

	/**
	*
	*/
	function get_product_slug( int $product_id ){		
		$product = new \WC_Product( $product_id );		
		return $product->get_slug();
	}

	/**
	* calc product
	*
	*/
	function set_product_id( int $product_id = NULL, array $product_attributes = NULL){
		if ( !isset( $product_id ) && isset( $product_attributes['product_slug'] )) {			
			$args = array(
				'post_type' => 'product',
				'name' => $product_attributes['product_slug'],
				'post_status' => 'publish',
  				'numberposts' => 1
			);
			$product = \get_posts( $args );
			if ( count( $product ) == 1 && array_key_exists('ID', $product[0]) ) {
				$product_id = $product[0]->ID;
				$this->slug = $product_attributes['product_slug'];
			} else {
				$this->errors->add( new error( 4001 ) );
				return NULL;
			}
			

		}
		else {	
			if( isset( $product_id ) ){
				$this->slug = $this->get_product_slug( $product_id );
			} else {
				$this->errors->add( new error( 4001 ) );
				return NULL;	
			}			
		}
		$this->product_id = $product_id;
		return $product_id;
	}

	/**
	* calc product
	*
	*/
	function calc( ){
		
		if ( $this->errors->fcheck() ) { return $this->errors->get_data(); }		

		$this->create_todos_groups();
		$this->validate_todos_groups();
		if ( $this->errors->fcheck() ) { return $this->errors->get_data(); }				

		if ( 
			! $this->generate_formats_list()	||
			! $this->generate_todo_list() 		||
			! $this->process_todo_list()
		) {
			return $this->errors->get_data();
		}
		
		//last status check
		if ( !$this->status_ok() ) {
			return $this->errors->get_data();
		} else {
			$this->parse_total();

			/*
			* Checks from where this function was called
			
			$trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2);
			$last_trace = array_pop( $trace );

			if ( array_key_exists('class', $last_trace ) ) {
				$inner_origin = preg_match( '/^gcalc/', array_pop( $trace )['class'] );	
			} else $inner_origin = false;			
			var_dump($inner_origin);
*/
			$return = array(
				
				't' => $this->total_,
				'd' => $this->done,
				'e' => $this->errors->get_data(),
				'a' => $this->get_bvars()
			);
			
return $return;
			
			//	$data_permissions_f = new data_permissions_filter( $this );
			//	return $data_permissions_f->get();
			
		}
	}

	/*
	* Returns api key from request 
	*/
	public function get_api_key(){
		$apikey = array_key_exists( 'apikey', $this->bvars) ? $this->bvars['apikey'] : false;
		if (!$apikey) {			
			$this->get_errors()->add( new \gcalc\error( 10100 ) );
			return 'anonymous';
		}
		return $apikey;
	}

	/*
	* Returns api secret from request 
	*/
	public function get_api_secret(){
		$apisecret = array_key_exists( 'apisecret', $this->bvars) ? $this->bvars['apisecret'] : false;
		if (!$apisecret) {
			$this->get_errors()->add( new \gcalc\error( 10101 ) );
			return 'anonymous-secret';
		}
		return $apisecret;
	}



	/**
	* Concat data from whole object and assign it as an array to total_
	*/
	private function parse_total(){
		$production_formats = new \gcalc\db\production\formats();
		$total_cost_equasion = $production_formats->get_total_cost_equasion( $this->get_product_id() );
		$total_cost_equasion_string = $total_cost_equasion['equasion'];

		$total_cost_equasion = $total_cost_equasion_string;
		$total_pcost_equasion = $total_cost_equasion_string;

		$total_cost_array = array();
		$total_pcost_array = array();
		$total_markup_array = array();
		$used_formats_array = array();
		$used_media_array = array();

		foreach ($this->done as $key => $value) {	
			if ( preg_match( '/'.$value->total['name'].'/', $total_cost_equasion_string )) {
				$total_cost_equasion = str_replace($value->total['name'], $value->total['total_price'], $total_cost_equasion);						
				$total_pcost_equasion = str_replace($value->total['name'], $value->total['production_cost'], $total_pcost_equasion);		

				$total_cost_array[ $value->total['name'] ] = $value->total['total_price'];
				$total_pcost_array[ $value->total['name'] ] = $value->total['production_cost'];
				$total_markup_array[ $value->total['name'] ] = $value->total['markup'];
			}	

			//used formats total
			if ( preg_match( '/_format/', $value->total['name'] )) {
				$production_format_pieces = $value->total['extended']['production_format']['pieces'];
				$common_format_name = $value->total['extended']['production_format']['common_format']['name'];
				$common_format_width = $value->total['extended']['production_format']['common_format']['width'];
				$common_format_height = $value->total['extended']['production_format']['common_format']['height'];

				$production_format_format = $value->total['extended']['production_format']['format'];
				$production_format_width = $value->total['extended']['production_format']['width'];
				$production_format_height = $value->total['extended']['production_format']['height'];

				$format_str = $production_format_pieces .' '. __('on', 'gcalc') .' '. $common_format_name .'('.$common_format_width.'x'.$common_format_height.')' 
				.' @ '. $production_format_format.'('.$production_format_width.'x'.$production_format_height.')';

				$used_formats_array[ $value->total['name'] ] = $format_str;
			}
			
			//used papers total
			if ( preg_match( '/_paper/', $value->total['name'] )) {
				$sheet_cost = $value->total['extended']['sheet_cost'];
				$sheets_quantity = $value->total['extended']['sheets_quantity'];
				$paper_price_per_kg = $value->total['extended']['paper']['price_per_kg'];
				$paper_label = $value->total['extended']['paper']['label'];				
				$paper_thickness = $value->total['extended']['paper']['thickness'];

				$media_str = $sheets_quantity .' x ' . $paper_label . ' (' . $paper_thickness . 'mm)'
				.' @ ' . $sheet_cost . ' PLN / '. __('sheet','gcalc') .' (' . $paper_price_per_kg . '/kg) ';

				$used_media_array[ $value->total['name'] ] = $media_str;
			}
		}
		eval('$total_cost_ = ' . $total_cost_equasion . ';');
		eval('$total_pcost_ = ' . $total_pcost_equasion . ';');

		$average_markup = count($total_markup_array) > 0 ? array_sum( $total_markup_array ) / count($total_markup_array) : 1;

		$total_ = array(
			'equasion' => $total_cost_equasion_string,			
			'used_formats' => $used_formats_array,
			'used_media' => $used_media_array,

			'total_markup' => $total_markup_array,
			'total_cost_equasion' => $total_cost_array,
			'total_pcost_equasion' => $total_pcost_array,
			
			'average_markup' => $average_markup, 
			'total_cost_' => $total_cost_,
			'total_pcost_' => $total_pcost_
		);

		$total_ = $this->merge_children_totals( $total_ );
		$this->total_ = $total_;

	}

	private function merge_children_totals( array $total_ ){
		if ( !empty( $this->children ) ) {
			foreach ($this->children as $key => $value) {	

				foreach ( $value['used_formats'] as $key2 => $value2 ) {
					$index = $key . '_' . str_replace( array('pa_', 'master_' ), array('',''), $key2 );
					$total_[ 'used_formats' ][ $index ] = $value2;
				}

				foreach ( $value['used_media'] as $key2 => $value2 ) {
					$index = $key . '_' . str_replace( array('pa_', 'master_' ), array('',''), $key2 );
					$total_[ 'used_media' ][ $index ] = $value2;
				}

			}
		}

		return $total_;
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
		$this->groups_check();
		$this->conflict_check();
	}


	/**
	*
	*/
	function set_bvar( string $arg_name, string $group_name, $value, $error ){
		if ( !isset( $value)) {
			return false;
		}
		$arg_name = str_replace( 'master_', '', 
			( 'pa_' . $group_name . '_' . str_replace('pa_', '', $arg_name ) )
		);
		$todo_groups = $this->get_todo_groups();

		if ( !array_key_exists( $arg_name, $this->bvars ) ) {
			$this->bvars[ $arg_name ] = $value;
			$todo_groups[ $group_name ][ $arg_name ] = array( 'class_name' => $arg_name );
			$this->errors->add( $error[0] );
		} else {
			$this->bvars[ $arg_name ] = $value;	
			$this->errors->add( $error[0] );
		}
		$this->set_todo_groups( $todo_groups );		
		return null;
	}

	/**
	* 
	*/
	private function conflict_check(){

		$pa_quantity = $this->get_bvar('pa_quantity');
		$todo_groups = $this->get_todo_groups();


		if ( is_null( $pa_quantity ) ) {
			$this->set_bvar('pa_quantity', 'master', 1, array( new error( 10001 ) ) );
			$r=1;
		}		
		
		if ( array_key_exists( 'cover', $todo_groups ) ) {
			$pa_cover_type = $this->get_bvar('pa_cover_type');
			if ( is_null($pa_cover_type)) {
				$this->set_bvar('pa_type', 'cover', 'perfect_binding', array( new error( 10006 ) ) );
			}
		}

		if ( array_key_exists( 'bw', $todo_groups ) ) {
			$pa_bw_pages = $this->get_bvar('pa_bw_pages');
			if ( is_null($pa_bw_pages)) {
				$this->set_bvar('pa_pages', 'bw', 1, array( new error( 10002 ) ) );
			}
		}

		if ( array_key_exists( 'color', $todo_groups ) ) {
			$pa_color_pages = $this->get_bvar('pa_color_pages');
			if ( is_null($pa_color_pages)) {
				$this->set_bvar('pa_pages', 'color', 1, array( new error( 10003 ) ) );
			}			

			$pa_color_stack = $this->get_bvar('pa_color_stack');
			if ( is_null($pa_color_stack)) {
				$this->set_bvar('pa_stack', 'color', 'shuffled', array( new error( 10004 ) ) );
			}			


			$a=1;
		}
$r=1;

		

	}

	/**
	* Checks if every declared group exists in headers  
	*
	*/
	private function groups_check(){
		
		$production_formats = new \gcalc\db\production\formats();
		$needed_groups = $production_formats->get_product_groups( $this->slug );
		$needed_groups_ = array_flip( $needed_groups );
		$todo_groups = $this->get_todo_groups();
		foreach ($todo_groups as $key => $value) {		
			if ( array_key_exists( $key, $needed_groups_)) {
				$index = $needed_groups_[ $key ];
				unset($needed_groups[ $index ]);
			}			
		}
		if ( count( $needed_groups) > 0) {
					
		}
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
						$pa_class_name = '\gcalc\pa\\' . $class_name;
						if ( !class_exists( $pa_class_name ) ) {
							if ( class_exists( '\gcalc\pa\\' . $key2 ) ) {
								$class_name = $key2;
							}
						}

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
	function generate_formats_list(){
		$todo = array();
		$used = array();
//var_dump($this->todo_groups);
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
			if ( !$new_todo->ok() ) {
				return false;
			}
			array_push( $this->done, $new_todo->do() );
			array_push( $used, $group_process_name );
			
		}

		$this->todo->set_plist( $todo );				
		return $todo;
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

		
		foreach ($this->todo_groups as $group_name => $group) {
			foreach ($group as $process_name => $process) {
				$process_name = 'pa_' . $group_name .'_' . str_replace( array( $group_name .'_', 'pa_'), array('', ''), $process_name);	

				$pa_class_name = '\gcalc\pa\\' . $process['class_name'];

				if ( !in_array( $process_name, $used ) && class_exists( $pa_class_name ) && !preg_match('/format/', $pa_class_name)) {	
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
	* setter todo_groups
	*/
	function set_todo_groups( array $todo_groups ){
		$this->todo_groups = $todo_groups;
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


	public function check_best_production_format( array $group ){
		if ( array_key_exists( $group[0], $this->best_production_format ) ) {
			return $this->best_production_format[$group[0]];			
		}
		return false;
	}

	/**
	* Getter best_production_format
	*/
	public function get_best_production_format( array $group ){		
		$production_formats = new \gcalc\db\production\formats();	

		if ( array_key_exists( $group[0], is_array($this->best_production_format) ? $this->best_production_format : array() ) ) {
			$group_name = $group[0];			
		}		
		
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
		return $double ? 1 : ( $single ? 0 : -1);		
	}


	/**
	* Getter todo
	*/
	public function get_todo( ){		
		return $this->todo;
	}

	/**
	* Setter todo
	*/
	public function set_todo( array $todo ){		
		$this->todo = $todo;
	}


	/**
	* Getter parent
	*/
	public function get_parent( ){		
		return $this->parent;
	}

	/**
	* Getter errors
	*/
	public function get_errors( ){		
		return $this->errors;
	}



	/**
	* Getter parent
	*/
	public function get_product_id( ){		
		return $this->product_id;
	}

	/**
	* Getter done
	*/
	public function get_done( ){		
		return $this->done;
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



	/**
	*
	*/
	function get_bvar( string $arg_name ){
		if ( !array_key_exists( $arg_name, $this->bvars ) ) {
			$arg_name = str_replace( '_master', '', $arg_name);
			if ( array_key_exists( $arg_name, $this->bvars ) ) {
				return $this->bvars[ $arg_name ];
			}
		} else return $this->bvars[ $arg_name ];
		return null;
	}


	

}



 ?>