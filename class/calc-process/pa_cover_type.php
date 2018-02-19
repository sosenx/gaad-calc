<?php 
namespace gcalc\pa;


class pa_cover_type extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->name = "pa_cover_type";
		$this->calculator = new \gcalc\calc\pa_cover_type( $product_attributes, $product_id, $parent, $group );
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
	
		return $this;
	}

	

}


?>