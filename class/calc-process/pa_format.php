<?php 
namespace gcalc\pa_;


class format extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id ){	
		parent::__construct( $product_attributes, $product_id );
		$this->name = "pa_format";
		$this->cclass = 
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>