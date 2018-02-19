<?php 
namespace gcalc\calc;


class pa_quantity extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
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
	function do( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "*", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

}


?>