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
		
		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this->name);
		$markup = $markup_db->get_markup();
		$total_price = $sheets_quantity * $pf['print_cost'];
		//$markup_ = $total_price * $markup['markup'];

		return $total_price;// + $markup_ ;
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