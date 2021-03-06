<?php 
namespace gcalc\calc;


class pa_cover_type extends pa_format{


	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->group = $group;
		$this->product_id = $product_id;
		$this->name = "pa_cover_type";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->parse_dimensions();
		$this->calculate_best_production_format();
		$this->add_related_procesess();
		return $this;
	}

	function add_related_procesess( ){


	}



	/**
	* Section sewn costs
	*/
	function spiral_binding_cost( ){		
		$return = array(
			'binding_cost' => array(
				'total_price' => 0,				
				'production_cost' => 0
			)
		);

		return $return;
	}

	/**
	* Perfect binding costs
	*/
	function saddle_stitch_cost( ){		
		$return = array(
			'binding_cost' => array(
				'total_price' => 0,				
				'production_cost' => 0
			)
		);

		return $return;
	}


	/**
	* Section sewn costs
	*/
	function section_sewn_cost( ){		
		$return = array(
			'binding_cost' => array(
				'total_price' => 0,				
				'production_cost' => 0
			)
		);

		return $return;
	}

	/**
	* Perfect binding costs
	*/
	function perfect_binding_cost( ){				
		$return = array(
			'binding_cost' => array(
				'total_price' => 0,				
				'production_cost' => 0
			)
		);

		return $return;
	}

	/**
	* Hard cover costs
	*/
	function hard_cost( ){
		$production_formats         = new \gcalc\db\production\formats();
		$pa_quantity                = $this->get_carg( 'pa_master_quantity' );
		$group_name                 = $this->group[0];

		$cover_type                 = $this->cargs['pa_cover_type'];
		$cover_cost                 = $production_formats->get_binding_type( $cover_type );

		$endpaper_paper             = $this->get_endpaper_paper( $this->get_carg('pa_cover_endpaper_paper') );
		$endpaper_print             = $this->get_endpaper_print( $this->get_carg('pa_cover_endpaper_print') );

		$cloth_covering_paper       = $this->get_cloth_covering_paper( $this->get_carg('pa_cover_cloth_covering_paper') );
		$cloth_covering_print       = $this->get_cloth_covering_print( $this->get_carg('pa_cover_cloth_covering_print') );
		$cloth_covering_wrap        = $this->get_cloth_covering_wrap( $this->get_carg('pa_cover_cloth_covering_finish') );
		$cloth_covering_spot_uv     = $this->get_cloth_covering_spot_uv( $this->get_carg('pa_cover_cloth_covering_spot_uv') );
		
		$dust_jacket_paper          = $this->get_dust_jacket_paper( $this->get_carg('pa_cover_dust_jacket_paper') );
		$dust_jacket_print          = $this->get_dust_jacket_print( $this->get_carg('pa_cover_dust_jacket_print') );
		$dust_jacket_wrap           = $this->get_dust_jacket_wrap( $this->get_carg('pa_cover_dust_jacket_finish') );
		$dust_jacket_spot_uv        = $this->get_dust_jacket_spot_uv( $this->get_carg('pa_cover_dust_jacket_spot_uv') );
		
		$board_thickness            = $this->get_board_thickness( $this->get_carg('pa_cover_board_thickness') );
		$board_thickness_translate  = array( 'board-20' => 'board_20mm_cost', 'board-25' => 'board_25mm_cost' );
		$board_thickness_index      = $board_thickness_translate[$board_thickness];

		$ribbon                     = $this->get_ribbon( $this->get_carg('pa_cover_ribbon') );

		/**
		 * Overridden dust jacket print markup
		 * @var float|null
		 */
		$markup_cover_dust_jacket_print   = $this->get_carg( 'markup_cover_dust_jacket_print' );
		/**
		 * Overridden cloth covering print markup
		 * @var float|null
		 */
		$markup_cover_cloth_covering_print= $this->get_carg( 'markup_cover_cloth_covering_print' );
		/**
		 * Overridden endpaper print markup
		 * @var float|null
		 */
		$markup_cover_endpaper_print      = $this->get_carg( 'markup_cover_endpaper_print' );



		/*
		* Dust Jacket, if paper is set
		*/
		$dust_jacket                = 0;
		$dust_jacket_procesess      = array();
		$dust_jacket_production_cost= 0;
		if ( $dust_jacket_paper ) {			
			$pargs = array(	
				"apikey"  => "g1a2a3d",
			"apisecret" => "k1o2o3t",
			    "pa_format" => ( (2 * $this->get_width() + 120) < 700 ? 2 * $this->get_width() + 120 : 700 ) . 'x' . ( $this->get_height()  ),			   
			    "pa_paper" => $dust_jacket_paper,
			    "pa_print" => $dust_jacket_print,
			    "pa_quantity" => $pa_quantity,
			    "pa_finish" => $dust_jacket_wrap,
			    "pa_spot_uv" => $dust_jacket_spot_uv,
			    "product_slug" => "business-card",
			);

			if ( isset( $markup_cover_dust_jacket_print ) ) {
				$pargs[ 'markup_print' ] = $markup_cover_dust_jacket_print;				
			}

			$dust_jacket_calc = new \gcalc\calculate( $pargs );		
			$dust_jacket_calculation_array = $dust_jacket_calc->calc();

			$dust_jacket_calc_stat_ok = $dust_jacket_calc->status_ok();
			if ( $dust_jacket_calc_stat_ok ) {
				foreach ($dust_jacket_calculation_array['d'] as $key => $value) {
					if ( 	$value->total['name'] == 'pa_master_paper' 	||
							$value->total['name'] == 'pa_master_print' 	|| 
							$value->total['name'] == 'pa_master_finish' 	|| 
							$value->total['name'] == 'pa_master_spot_uv' ) {
						$dust_jacket += $value->total['total_price'];			
						$dust_jacket_procesess[] = $value;
						$dust_jacket_production_cost += $value->total['production_cost'];
					}		
				}
				//merging errors with master calculation parent as cloth_covering errors
				$this->parent->merge_errors( $dust_jacket_calculation_array['e'], 'dust_jacket' );
				$this->parent->merge_bvars( $dust_jacket_calc, $group_name, 'dust_jacket' );				
			} 
			else {
				//merging errors with master calculation parent as dust_jacket errors
				$this->parent->merge_errors( $dust_jacket_calculation_array, 'dust_jacket' );
			}			
		}

		
		/*
		* cloth_covering
		*/
		$cloth_covering = 0; 
		$cloth_covering_procesess = array();
		$cloth_covering_production_cost = 0;
		$pargs = array(	
			"apikey"  => "g1a2a3d",
			"apisecret" => "k1o2o3t",
		    "pa_format" => ( 2 * $this->get_width() + 60 ) . 'x' . ( $this->get_height() + 60 ),
		    "pa_paper" => $cloth_covering_paper,
		    "pa_print" => $cloth_covering_print,         
		    "pa_finish" => $cloth_covering_wrap,         
		    "pa_quantity" => $pa_quantity,
		    "pa_spot_uv" => $cloth_covering_spot_uv,
		    "product_slug" => "business-card",
		);

		if ( isset( $markup_cover_cloth_covering_print ) ) {
			$pargs[ 'markup_print' ] = $markup_cover_cloth_covering_print;				
		}

		$cloth_covering_calc = new \gcalc\calculate( $pargs );	
		$cloth_covering_calculation_array = $cloth_covering_calc->calc();
		$cloth_covering_calc_stat_ok = $cloth_covering_calc->status_ok();	

		if ( $cloth_covering_calc_stat_ok) {	
			
			
			
			foreach ($cloth_covering_calculation_array['d'] as $key => $value) {
				
				if ( 	$value->total['name'] == 'pa_master_paper' 	||
						$value->total['name'] == 'pa_master_print' 	|| 
						$value->total['name'] == 'pa_master_finish' 	|| 
						$value->total['name'] == 'pa_master_spot_uv' ) {
					
					$cloth_covering += (float)$value->total['total_price'];			
					$cloth_covering_procesess[] = $value;
					$cloth_covering_production_cost += (float)$value->total['production_cost'];
					
				}		
			} 
			
		
			//merging errors with master calculation parent as cloth_covering errors
			$this->parent->merge_errors( $cloth_covering_calculation_array['e'], 'cloth_covering' );
			$this->parent->merge_bvars( $cloth_covering_calc, $group_name, 'cloth_covering' );
		} else {
			//merging errors with master calculation parent as cloth_covering errors
			$this->parent->merge_errors( $cloth_covering_calculation_array, 'cloth_covering' );
		}


		/*
		* endpaper
		*/
		$endpaper = 0; 
		$endpaper_procesess = array();
		$endpaper_production_cost = 0;
		$pargs = array(	
			"apikey"  => "g1a2a3d",
			"apisecret" => "k1o2o3t",
		    "pa_format" => ( 2 * $this->get_width()) . 'x' . ( $this->get_height() ),
		    "pa_paper" => $endpaper_paper,
		    "pa_print" => $endpaper_print,         
		    "pa_finish" => '0x0',         
		    "pa_quantity" => $pa_quantity * 2,
		    "pa_spot_uv" => '0x0',
		    "product_slug" => "business-card",
		);

		if ( isset( $markup_cover_endpaper_print ) ) {
			$pargs[ 'markup_print' ] = $markup_cover_endpaper_print;				
		}

		$endpaper_calc = new \gcalc\calculate( $pargs );	
		$endpaper_calculation_array = $endpaper_calc->calc();
		$endpaper_calc_stat_ok = $endpaper_calc->status_ok();	

		if ( $endpaper_calc_stat_ok) {			
			foreach ($endpaper_calculation_array['d'] as $key => $value) {
				if ( 	$value->total['name'] == 'pa_master_paper' 	||
						$value->total['name'] == 'pa_master_print' 	|| 
						$value->total['name'] == 'pa_master_wrap' 	|| 
						$value->total['name'] == 'pa_master_spot_uv' ) {
					$endpaper += $value->total['total_price'];			
					$endpaper_procesess[] = $value;
					$endpaper_production_cost += $value->total['production_cost'];
				}		
			} 
			//merging errors with master calculation parent as endpaper errors
			$this->parent->merge_errors( $endpaper_calculation_array['e'], 'endpaper' );
			$this->parent->merge_bvars( $endpaper_calc, $group_name, 'endpaper' );
		} else {
			//merging errors with master calculation parent as endpaper errors
			$this->parent->merge_errors( $endpaper_calculation_array, 'endpaper' );
		}

		/*
		* case board
		*/
		$best_production_format = $this->parent->get_best_production_format( array( 'cover' ) );
		
		$common_format_name = $best_production_format['common_format']['name'];		
		$common_format_name = str_replace( array('A6', 'B6', 'A5'), array('A5', 'B5', 'A4'), $common_format_name );
		
		$board_cost = $this->get_val_from( 
			'', 
			"exact", 
			$cover_cost[ $board_thickness_index ][ 'scale' ],
			'"'.$common_format_name.'"'
			)['price'];
		$board_cost *= $pa_quantity;
		

		/*
		* ribbon cost
		*/
		if( $ribbon && $ribbon !== 'ribbon-0'){
			$ribbon_cost = $cover_cost['extended']['ribbon_cost'] * $pa_quantity;
		} else {
			$ribbon_cost = 0;
		}		
		$ribbon_cost *= $pa_quantity;
		
		
		
		$return = array(
			'endpaper' => array(
				'total_price' => $endpaper,				
				'production_cost' => $endpaper_production_cost,
				'parts' => $endpaper_procesess
			),
			'cloth_covering' => array(
				'total_price' => $cloth_covering,				
				'production_cost' => $cloth_covering_production_cost,
				'parts' => $cloth_covering_procesess
			),
			'dust_jacket' => array(
				'total_price' => $dust_jacket,
				'production_cost' => $dust_jacket_production_cost,
				'parts' => $dust_jacket_procesess
			),
			'board_cost' => array(
				'total_price' => $board_cost,
				'production_cost' => $board_cost
			),
			'ribbon_cost' => array(
				'total_price' => $ribbon_cost,
				'production_cost' => $ribbon_cost
			),
		);

		return $return;	
	}

	/**
	* Returns total price of additional covering costs array
	*/
	function parse_additional_cover_cost( $additional_cover_cost_array ){
		if ( empty( $additional_cover_cost_array)) {
			return 0;
		}
		$total = 0;
		$total_production = 0;

		foreach ($additional_cover_cost_array as $key => $value) {
			if ( array_key_exists('total_price', $value)) {
				$total += $value['total_price'];
			}

			if ( array_key_exists('production_cost', $value)) {
				$total_production += $value['production_cost'];
			}
		}
		$return = array(
			'total_price' => $total,
			'production_cost' => $total_production
		);
		
		return $return;	
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
		$pa_quantity = (int)$this->get_carg( 'pa_master_quantity' );
		$pf = $this->parent->get_best_production_format( $this->group );	
		$cover_type = $this->cargs['pa_cover_type'];
		$cover_cost = $production_formats->get_binding_type( $cover_type );
		$additional_cover_cost_array = array();
		$additional_cover_cost = array( 'production_cost' => 0, 'total_price' => 0);

		/*
		* bounding cost
		*/
		$min_bounding_cost = array_key_exists('minimal_cost', $cover_cost) ? $this->get_val_from( 
			$cover_cost['minimal_cost']['pa_attr'], 
			"min", 
			$cover_cost[ 'minimal_cost' ][ 'scale' ]
			) 
		: -1;

		
		$bounding_cost_tmp = $min_bounding_cost != -1 ? $min_bounding_cost : $this->get_val_from( 
			$cover_cost['cost']['pa_attr'], 
			"min", 
			$cover_cost[ 'cost' ][ 'scale' ]
			);

		
		if ( $cover_type === 'hard') {
			$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
			$markup = $markup_db->get_markup( );
			$markup_val = $this->get_val_from( 
				'',
				"min", 
				$markup['hard-affiliate'],
				$pa_quantity
				);
			
			
			$bounding_cost = $bounding_cost_tmp * $markup_val * ($bounding_cost_tmp === $min_bounding_cost ? 1 : $pa_quantity);

			
			$additional_cover_cost_array = $this->additional_cover_cost();
			$additional_cover_cost = $this->parse_additional_cover_cost( $additional_cover_cost_array );
		}
		


		/**
		 * outside markup source (prom requst attributes)		  
		 */
		$group = $this->get_group();
		$markup_attr_name = 'markup_' . str_replace( 'pa_', '', $group[1] );
		$overridden_markup_value = (int)$this->get_carg( $markup_attr_name ) / 100;
		
		
		
		if ( is_null( $overridden_markup_value ) || $overridden_markup_value == 0) {				
			$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
			
			
			
			
			$markup = $markup_db->get_markup( );	//true = gets markup from markup product group, not product type
			if( $cover_type !== 'hard' ){
				$markup_ = $this->get_val_from( 
					'',
					"min", 
					$markup[ $cover_type ],
					$pa_quantity
				);	
			} else {
				$markup_ = $this->get_val_from( 
					'',
					"min", 
					$markup["hard-affiliate"],
					$pa_quantity
				);	
				
			}
			
			
		} else {
			$markup_ = $overridden_markup_value;
		}

		

 		$bounding_cost = isset( $bounding_cost ) ? $bounding_cost : $bounding_cost_tmp * ($bounding_cost_tmp === $min_bounding_cost ? 1 : $pa_quantity);
		
		$production_cost = $bounding_cost + $additional_cover_cost['production_cost'];
		$total_price = ( $bounding_cost == 0 ? 1 : $bounding_cost ) * $markup_;
		$total_price += $additional_cover_cost['total_price'];
	

		$return = $this->parse_total( 			
			array(				
				'production_cost' 	=> 	$production_cost,				
				'total_price' 		=> 	$total_price,
				'markup_value' 		=> 	$total_price - $production_cost,
				'markup' 			=> 	1 + ( $total_price - $production_cost ) / $production_cost
			),
			array(
				'children_calculations' 	=>	$additional_cover_cost_array,
				'additional_cover_cost' 		=>	$additional_cover_cost
			)
		);
		//var_dump($return);
		return $return;
	}
	
	/**
	* Returns default cloth covering paper if there is no in attributes
	*/
	function get_cloth_covering_paper( $cloth_covering_paper = NULL){
		if ( isset( $cloth_covering_paper ) ) {
			return $cloth_covering_paper;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10009,  ' -> coated-130g') );
		}
		return 'coated-130g';
	}

	/**
	* Returns default cloth covering paper if there is no in attributes
	*/
	function get_endpaper_paper( $endpaper_paper = NULL){
		if ( isset( $endpaper_paper ) ) {
			return $endpaper_paper;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10009,  ' -> coated-130g') );
		}
		return 'coated-130g';
	}


	/**
	* Returns default cloth covering paper if there is no in attributes
	*/
	function get_cloth_covering_wrap( $cloth_covering_wrap = NULL){
		if ( isset( $cloth_covering_wrap ) ) {
			return $cloth_covering_wrap;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10011,  ' -> 0x0') );
		}
		return '0x0';
	}
	
	/**
	* Returns default cloth covering print if there is no in attributes
	*/
	function get_cloth_covering_print( $cloth_covering_print = NULL){
		if ( isset( $cloth_covering_print ) ) {
			return $cloth_covering_print;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10010,  ' -> 4x0') );
		}
		return '4x0';
	}

	/**
	* Returns default cloth covering print if there is no in attributes
	*/
	function get_endpaper_print( $endpaper_print = NULL){
		if ( isset( $endpaper_print ) ) {
			return $endpaper_print;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10010,  ' -> 4x0') );
		}
		return '0x0';
	}

	/** 
	* Returns default cloth covering print if there is no in attributes
	*/
	function get_cloth_covering_spot_uv( $cloth_covering_spot_uv = NULL){
		if ( isset( $cloth_covering_spot_uv ) ) {

			$r=1;

			return $cloth_covering_spot_uv;
		}
		return '0x0';
	}

	/** 
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_dust_jacket_spot_uv( $dust_jacket_spot_uv = NULL){
		if ( isset( $dust_jacket_spot_uv ) ) {
			return $dust_jacket_spot_uv;
		}
		return '0x0';
	}

	/**
	* Returns default dust jacket paper if there is no in attributes
	*/
	function get_dust_jacket_paper( $dust_jacket_paper = NULL){
		if ( isset( $dust_jacket_paper ) ) {
			return $dust_jacket_paper;
		}
		return false;
	}

	/**
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_dust_jacket_print( $dust_jacket_print = NULL){
		if ( isset( $dust_jacket_print ) ) {
			return $dust_jacket_print;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10007 ) );
		}
		return '4x0';
	}

	/**
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_board_thickness( $board_thickness = NULL){
		if ( isset( $board_thickness ) ) {
			return $board_thickness;
		}
		return '2.0mm';
	}

	/**
	* Returns default dust jacket print if there is no in attributes
	*/
	function get_dust_jacket_wrap( $dust_jacket_wrap = NULL){
		if ( isset( $dust_jacket_wrap ) ) {
			return $dust_jacket_wrap;
		} else {
			$this->parent->get_errors()->add( new \gcalc\error( 10008 ) );
		}
		return '0x0';
	}

	/**
	* Returns default ribbon
	*/
	function get_ribbon( $ribbon = NULL){
		if ( isset( $ribbon ) ) {
			return true;
		}
		return false;
	}
}


?>