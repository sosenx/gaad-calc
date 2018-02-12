<?php 
namespace gcalc\calc;


class pa_zadruk extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		parent::__construct( $product_attributes, $product_id, $parent );
		$this->name = "pa_zadruk";		
		$this->cargs = $product_attributes;
		$this->product_id = $product_id;
		$this->dependencies = NULL;
	
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){
		$pf = $this->parent->get_best_production_format();				
		$sheets_quantity = (int)($this->cargs['pa_naklad'] / $pf['PPP']) + ( $this->cargs['pa_naklad'] % $pf['PPP'] > 0 ? 1 : 0 );
		$print_color_mode = $this->get_print_color_mode('pa_zadruk');
		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
		$markup = $markup_db->get_markup();
		
		$markup_ = $markup_db->get_markup_value( $sheets_quantity, $markup['markup'][$print_color_mode] );		
		$production_cost = $sheets_quantity * $pf['print_cost'];
		$total_price = $production_cost * $markup_;
		
		return $this->parse_total( 
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(
				'print_cost' => $pf['print_cost'],
				'sheets_quantity' => $sheets_quantity
			)
		);
	}


	/**
	*
	*/
	function do( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

}


?>