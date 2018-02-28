<?php 
namespace gcalc\calc;


class pa_sewing extends \gcalc\cprocess_calculation{

	
	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->group = $group;
		$this->name = "pa_sewing";		
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
		$pages = (int)$this->get_carg('pa_' . $this->group[0] . '_pages') ;
		$signatures = ceil( $pages / 16 ) * $this->cargs['pa_quantity'];

		$cover_type = $this->cargs['pa_cover_type'];
		$cover_cost = $production_formats->get_binding_type( $cover_type );
		
		$sewing_cost = $cover_cost['extended']['signature_cost'] * $signatures;
		//$sewing_cost = $sewing_cost < $cover_cost['extended']['min_signature_cost']? $cover_cost['extended']['min_signature_cost'] : $sewing_cost;

		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->parent->get_product_id(), $this);
		$markup = $markup_db->get_markup();

		$markup_ = $markup['markup'];		
		$production_cost = $sewing_cost;
		$total_price = $production_cost * $markup_;
		

		return $this->parse_total( 			
			array(				
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(							
				'signature_cost' => $cover_cost['extended']['signature_cost'],
				'signatures' => $signatures
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