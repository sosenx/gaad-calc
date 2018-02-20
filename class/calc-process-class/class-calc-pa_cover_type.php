<?php 
namespace gcalc\calc;


class pa_cover_type extends pa_format{


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->group = $group;
		$this->product_id = $product_id;
		$this->name = "pa_cover_type";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->parse_dimensions();
		$this->calculate_best_production_format();

		return $this;
	}



	function get_carg( string $arg_name ){
		if ( !array_key_exists( $arg_name, $this->cargs ) ) {
			$arg_name = str_replace( '_master', '', $arg_name);
			if ( array_key_exists( $arg_name, $this->cargs ) ) {
				return $this->cargs[ $arg_name ];
			}
		} else return $this->cargs[ $arg_name ];
		return null;
	}

	function get_val_from( string $factor, string $compare, array $scale, string $outside_factor = NULL ){
		$compare_sign = array(
			'exact' => '==',
			'min' => '>='
		);
		$attr = is_null( $outside_factor ) ? $this->get_carg( $factor ) : $outside_factor ;		
		
		if ( $compare_sign[ $compare ] !== '==' ) {
			$array = array();
			foreach ($scale as $key => $value) {
				$array[(int)$value['v']] = $value['price']; 
			}
			asort($array);
		} else {
			$array = $scale;
			foreach ($array as $key => $value) {	
				if ( $value['v'] == $attr) {
					return $value;	
				}
			}


		}	
			
		foreach ($array as $key => $value) {
			$comp_str = eval('$comp = ' .$attr . ' ' . $compare_sign[ $compare ] . ' '. $key .';'); 
			//var_dump('$comp = ' .$attr . ' ' . $compare_sign[ $compare ] . ' '. $key .';');
			if ($comp) {
				return $value;	
			}
			
		}		
		
	}

	/**
	* Returns default cloth covering paper if there is no in attributes
	*/
	function get_cloth_covering_paper( string $cloth_covering_paper = NULL){
		if ( isset( $cloth_covering_paper ) ) {
			return $cloth_covering_paper;
		}
		return 'offset-130g';
	}

	/**
	* Returns default cloth covering print if there is no in attributes
	*/
	function get_cloth_covering_print( string $cloth_covering_print = NULL){
		if ( isset( $cloth_covering_print ) ) {
			return $cloth_covering_print;
		}
		return '4x0';
	}

	/** 
	* Returns default cloth covering print if there is no in attributes
	*/
	function get_cloth_covering_spot_uv( string $cloth_covering_spot_uv = NULL){
		if ( isset( $cloth_covering_spot_uv ) ) {
			return $cloth_covering_spot_uv;
		}
		return '0x0';
	}


	/** 
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_dust_jacket_spot_uv( string $dust_jacket_spot_uv = NULL){
		if ( isset( $dust_jacket_spot_uv ) ) {
			return $dust_jacket_spot_uv;
		}
		return '0x0';
	}


	/**
	* Returns default dust jacket paper if there is no in attributes
	*/
	function get_dust_jacket_paper( string $dust_jacket_paper = NULL){
		if ( isset( $dust_jacket_paper ) ) {
			return $dust_jacket_paper;
		}
		return false;
	}

	/**
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_dust_jacket_print( string $dust_jacket_print = NULL){
		if ( isset( $dust_jacket_print ) ) {
			return $dust_jacket_print;
		}
		return '4x0';
	}

	/**
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_board_thickness( string $board_thickness = NULL){
		if ( isset( $board_thickness ) ) {
			return $board_thickness;
		}
		return '2.0mm';
	}

	/**
	* Returns default ribbon
	*/
	function get_ribbon( string $ribbon = NULL){
		if ( isset( $ribbon ) ) {
			return true;
		}
		return false;
	}


	/**
	* Hard cover costs
	*/
	function hard_cost( ){
		$production_formats = new \gcalc\db\production\formats();
		$pa_quantity = $this->get_carg( 'pa_master_quantity' );

		$cover_type = $this->cargs['pa_cover_type'];
		$cover_cost = $production_formats->get_binding_type( $cover_type );

		$cloth_covering_paper = $this->get_cloth_covering_paper( $this->get_carg('pa_cover_cloth_covering_paper') );
		$cloth_covering_print = $this->get_cloth_covering_print( $this->get_carg('pa_cover_cloth_covering_print') );
		$cloth_covering_spot_uv = $this->get_cloth_covering_spot_uv( $this->get_carg('pa_cover_cloth_covering_spot_uv') );
		
		$dust_jacket_paper = $this->get_dust_jacket_paper( $this->get_carg('pa_cover_dust_jacket_paper') );
		$dust_jacket_print = $this->get_dust_jacket_print( $this->get_carg('pa_cover_dust_jacket_print') );
		$dust_jacket_spot_uv = $this->get_dust_jacket_spot_uv( $this->get_carg('pa_cover_dust_jacket_spot_uv') );
		
		$board_thickness = $this->get_board_thickness( $this->get_carg('pa_cover_board_thickness') );
		$board_thickness_translate = array( '2.0mm' => 'board_20mm_cost', '2.5mm' => 'board_25mm_cost' );
		$board_thickness_index = $board_thickness_translate[$board_thickness];

		$ribbon = $this->get_ribbon( $this->get_carg('pa_cover_ribbon') );

		/*
		* Dust Jacket, if paper is set
		*/
		$dust_jacket = 0;
		$dust_jacket_procesess = array();
		if ( $dust_jacket_paper ) {			
			$pargs = array(	
			    "pa_format" => ( (2 * $this->get_width() + 120) < 700 ? 2 * $this->get_width() + 120 : 700 ) . 'x' . ( $this->get_height()  ),
			    "pa_paper" => $dust_jacket_paper,
			    "pa_print" => $dust_jacket_print,         
			    "pa_quantity" => $pa_quantity,
			    "pa_spot_uv" => $dust_jacket_spot_uv
			);
			$dust_jacket_calc = new \gcalc\calculate( $pargs, 22986 );		
			$dust_jacket_calculation_array = $dust_jacket_calc->calc();
			foreach ($dust_jacket_calculation_array as $key => $value) {
				if ( $value->total['name'] == 'pa_master_paper' ) {
					$dust_jacket += $value->total['total_price'];			
					$dust_jacket_procesess[] = $value;
				}

				if ( $value->total['name'] == 'pa_master_print' ) {
					$dust_jacket += $value->total['total_price'];			
					$dust_jacket_procesess[] = $value;
				}

				if ( $value->total['name'] == 'pa_master_spot_uv' ) {
					$dust_jacket += $value->total['total_price'];			
					$dust_jacket_procesess[] = $value;
				}		
			}
		}

		
		/*
		* cloth_covering
		*/
		$cloth_covering = 0;
		$cloth_covering_procesess = array();

		$pargs = array(	
		    "pa_format" => ( 2 * $this->get_width() + 60 ) . 'x' . ( $this->get_height() + 60 ),
		    "pa_paper" => $cloth_covering_paper,
		    "pa_print" => $cloth_covering_print,         
		    "pa_quantity" => $pa_quantity,
		    "pa_spot_uv" => $cloth_covering_spot_uv
		);
		$cloth_covering_calc = new \gcalc\calculate( $pargs, 22986 );		
		$cloth_covering_calculation_array = $cloth_covering_calc->calc();
		foreach ($cloth_covering_calculation_array as $key => $value) {
			if ( $value->total['name'] == 'pa_master_paper' ) {
				$cloth_covering += $value->total['total_price'];			
				$cloth_covering_procesess[] = $value;
			}

			if ( $value->total['name'] == 'pa_master_print' ) {
				$cloth_covering += $value->total['total_price'];			
				$cloth_covering_procesess[] = $value;
			}

			if ( $value->total['name'] == 'pa_master_spot_uv' ) {
				$cloth_covering += $value->total['total_price'];			
				$cloth_covering_procesess[] = $value;
			}		
		} 

		/*
		* case board
		*/
		$best_production_format = $this->parent->get_best_production_format( array( 'cover' ) );
		$common_format_name = $best_production_format['common_format']['name'];		
		$common_format_name = str_replace( array('A6', 'B6'), array('A5', 'B5'), $common_format_name );
		$board_cost = $this->get_val_from( 
			'', 
			"exact", 
			$cover_cost[ $board_thickness_index ][ 'scale' ],
			'"'.$common_format_name.'"'
			)['price'];
		
		/*
		* bounding cost
		*/
		$min_bounding_cost = $this->get_val_from( 
			$cover_cost['minimal_cost']['pa_attr'], 
			"min", 
			$cover_cost[ 'minimal_cost' ][ 'scale' ]
			);

		$bounding_cost = $min_bounding_cost != -1 ? $min_bounding_cost : $this->get_val_from( 
			$cover_cost['cost']['pa_attr'], 
			"min", 
			$cover_cost[ 'cost' ][ 'scale' ]
			);
		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
		$markup = $markup_db->get_markup();
		$markup_val = $this->get_val_from( 
			'',
			"min", 
			$markup['markup'],
			$pa_quantity
			);
		$bounding_cost *= $markup_val * $pa_quantity;

		/*
		* ribbon cost
		*/
		if( $ribbon ){
			$ribbon_cost = $cover_cost['extended']['ribbon_cost'] * $pa_quantity;
		}		

		return array(
			'cloth_covering' => array(
				'total_price' => $cloth_covering,
				'parts' => $cloth_covering_procesess
			),
			'dust_jacket' => array(
				'total_price' => $dust_jacket,
				'parts' => $dust_jacket_procesess
			),
			'board_cost' => array(
				'total_price' => $board_cost
			),
			'bounding_cost' => array(
				'total_price' => $bounding_cost,
				'parts' => array(
					'markup' => $markup_val
				)
			),
			'ribbon_cost' => array(
				'total_price' => $ribbon_cost
			),
		);	
	}

	/**
	* Returns total price of additional covering costs array
	*/
	function parse_additional_cover_cost( array $additional_cover_cost_array ){
		if ( empty( $additional_cover_cost_array)) {
			return 0;
		}
		$total = 0;
		foreach ($additional_cover_cost_array as $key => $value) {
			if ( array_key_exists('total_price', $value)) {
				$total += $value['total_price'];
			}
		}
		return $total;
	}

	/**
	*
	*/
	function additional_cover_cost(){
		$cover_type = $this->cargs['pa_cover_type'];	
		$cover_type_cost_fn_name = $cover_type . '_cost';
		if ( method_exists( $this, $cover_type_cost_fn_name ) ) {
			return $this->$cover_type_cost_fn_name();
		}
		return 0;
	}

	/**
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			
		$production_formats = new \gcalc\db\production\formats();
		$pf = $this->parent->get_best_production_format( $this->group );	
		$cover_type = $this->cargs['pa_cover_type'];
		$cover_cost = $production_formats->get_binding_type( $cover_type );
		
		$binding_cost = $this->get_val_from( $cover_cost['cost']['pa_attr'], $cover_cost['cost']['compare'], $cover_cost['cost']['scale'] );

		$additional_cover_cost_array = $this->additional_cover_cost();
		$additional_cover_cost = $this->parse_additional_cover_cost( $this->additional_cover_cost() );


 		$markup_ = 1;		
		$production_cost = 1;
		$total_price = $production_cost * $markup_;
		$total_price += $additional_cover_cost;

		return $this->parse_total( 			
			array(				
				'production_cost' 	=> 	$production_cost,				
				'total_price' 		=> 	$total_price,
				'markup_value' 		=> 	$total_price - $production_cost,
				'markup' 			=> 	$markup_
			),
			array(
				'additional_cover_cost_array' 	=>	$additional_cover_cost_array,
				'additional_cover_cost' 		=>	$additional_cover_cost
			)
		);
	}


	
}


?>