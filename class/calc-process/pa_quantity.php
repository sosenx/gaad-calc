<?php 
namespace gcalc\pa;


class pa_quantity extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->name = "pa_quantity";
		$this->cclass = "";
		$this->calculator = new \gcalc\calc\pa_quantity( $product_attributes, $product_id, $parent, $group, $this );
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>