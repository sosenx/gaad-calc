<?php 
namespace gcalc\calc;


class pa_naklad extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		parent::__construct( $product_attributes, $product_id, $parent );
		$this->name = "pa_naklad";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->product_id = $product_id;
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){
		$production_formats = new \gcalc\db\production\formats();
		$pf = $this->parent->get_best_production_format();				
		$sheets_quantity = (int)($this->cargs['pa_naklad'] / $pf['PPP']) + ( $this->cargs['pa_naklad'] % $pf['PPP'] > 0 ? 1 : 0 );
		
		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
		$markup = $markup_db->get_markup();
		$wrap_cost = $production_formats->get_wrap_cost( $this->cargs['pa_wrap'] );

		$markup_ = 1;		
		$production_cost = 1;
		$total_price = $production_cost * $markup_;
		
		return $this->parse_total( 
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(				
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