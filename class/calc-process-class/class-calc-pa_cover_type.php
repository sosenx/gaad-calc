<?php 
namespace gcalc\calc;


class pa_cover_type extends pa_format{


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->group = $group;
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

	function get_val_from( string $factor, string $compare, array $scale ){
		$compare_sign = array(
			'min' => '>',
			'exact' => '==',
		);
		$attr = $this->get_carg( $factor );
		$array = array();
		foreach ($scale as $key => $value) {
			$array[(int)$value['v']] = $value['price'];
		}
		asort($array);

		foreach ($array as $key => $value) {
			$comp_str = eval('$comp = ' .$attr . ' ' . $compare_sign[ $compare ] . ' '. $key .';'); 
			if ($comp) {
				return $value;	
			}
			
		}		
		
	}

	/**
	*
	*/
	function hard_cost( ){
	$pa_quantity = $this->get_carg( 'pa_master_quantity' );
	$cloth_covering_paper = $this->get_carg('pa_cover_cloth_covering_paper');

	$pargs = array(	
	    "pa_format" => ( $this->get_width() + 60 ) . 'x' . ( $this->get_height() + 60 ),
	    "pa_paper" => $cloth_covering_paper,
	    "pa_print" => "0x0",         
	    "pa_quantity" => $pa_quantity
	);
	$cloth_covering_calc = new \gcalc\calculate( $pargs, 22986 );		
	$cloth_covering_calculation_array = $cloth_covering_calc->calc();
	foreach ($cloth_covering_calculation_array as $key => $value) {
		if ( $value->total['name'] == 'pa_master_paper' ) {
			$cloth_covering = $value->total['total_price'] * 2;
			break;
		}
	}

$r=1;
	
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

		$additional_cover_cost = $this->additional_cover_cost();

		$markup_ = 1;		
		$production_cost = 1;
		$total_price = $production_cost * $markup_;
		

		return $this->parse_total( 			
			array(
				
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			)
		);
	}


	
}


?>