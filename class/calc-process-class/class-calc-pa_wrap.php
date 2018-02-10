<?php 
namespace gcalc\calc;


class pa_wrap extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id ){	
		parent::__construct( $product_attributes, $product_id );
		$this->name = "pa_wrap";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>