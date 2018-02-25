<?php 
namespace gcalc\pa;


class pa_paper extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
		
		parent::__construct( $this->cargs, $product_id, $parent, $group );
		$this->name = "pa_paper";
		$this->calculator = new \gcalc\calc\pa_paper( $this->cargs, $product_id, $parent, $group, $this);
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>