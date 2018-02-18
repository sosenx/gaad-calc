<?php 
namespace gcalc\calc;


class pa_wrap extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->cargs = $product_attributes;
		$this->name = "pa_wrap";	
		$this->group = $group;
		$this->dependencies = NULL;
		$this->product_id = $product_id;
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){
		$production_formats = new \gcalc\db\production\formats();
		$pf = $this->parent->get_best_production_format( $this->group );				
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		
		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
		$markup = $markup_db->get_markup();		
		$wrap_cost = array_key_exists( 'pa_wrap', $this->cargs ) ? $production_formats->get_wrap_cost( $this->cargs['pa_wrap'] ) : 0;

		$markup_ = $markup['markup'];		
		$production_cost = $sheets_quantity * $wrap_cost;
		$total_price = $production_cost * $markup_;
		
		return $this->parse_total( 
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(
				'wrap_cost' => $wrap_cost,
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