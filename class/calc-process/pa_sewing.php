<?php 
namespace gcalc\pa;


class pa_sewing extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
		
		parent::__construct( $this->cargs, $product_id, $parent, $group );
		$this->name = "pa_sewing";
		$this->calculator = new \gcalc\calc\pa_sewing( $this->cargs, $product_id, $parent, $group, $this );
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>