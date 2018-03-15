<?php 
namespace gcalc\calc;


class pa_folding extends \gcalc\cprocess_calculation{

	
	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->group = $group;
		$this->name = "pa_folding";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		
		

		return $this;
	}


	/**
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			
		$production_formats = new \gcalc\db\production\formats();
		$pf = $this->parent->get_best_production_format( $this->group );	
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		$folding = $this->get_carg('pa_folding') ;		

		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->parent->get_product_id(), $this);
		$markup = $markup_db->get_markup();

		$markup_ = $markup['markup'];		
		$production_cost = 0;
		$total_price = $production_cost * $markup_;
		
		return $this->parse_total( 			
			array(				
				'production_cost' => $production_cost,				
				'markup' => $markup_
			),
			array(											
			)
		);
	}


	
	/**
	*
	*/
	function do__( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}


}


?>