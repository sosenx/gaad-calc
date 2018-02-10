<?php 
namespace gcalc\pa;


class pa_wrap extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id ){	
		parent::__construct( $product_attributes, $product_id );
		$this->name = "pa_wrap";
		$this->calculator = new \gcalc\calc\pa_wrap( $product_attributes, $product_id );
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>