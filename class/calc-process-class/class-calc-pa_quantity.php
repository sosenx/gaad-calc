<?php 
namespace gcalc\calc;


class pa_quantity extends \gcalc\cprocess_calculation{

	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->name = "pa_quantity";
		$this->group = $group;		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->product_id = $product_id;
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){		
		
		return $this->parse_total( 
			array(				
			),
			array(
				'value' => (int)$this->cargs['pa_quantity']
			)
		);
	}

	/**
	*
	*/
	function do__( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "*", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

}


?>