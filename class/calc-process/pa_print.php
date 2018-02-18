<?php 
namespace gcalc\pa;


class pa_print extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		parent::__construct( $product_attributes, $product_id, $parent );
		$this->name = "pa_print";
		$this->calculator = new \gcalc\calc\pa_print( $product_attributes, $product_id, $parent );
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>