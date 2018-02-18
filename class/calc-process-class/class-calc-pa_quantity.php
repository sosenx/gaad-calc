<?php 
namespace gcalc\calc;


class pa_quantity extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		parent::__construct( $product_attributes, $product_id, $parent );
		$this->name = "pa_quantity";		
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
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['PPP']) + ( $this->cargs['pa_quantity'] % $pf['PPP'] > 0 ? 1 : 0 );
		$total_cost_equasion = $this->parent->parse_total_cost_equasion( $production_formats->get_total_cost_equasion( $this->product_id )['equasion'] );

		
		return $this->parse_total( 
			$total_cost_equasion
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