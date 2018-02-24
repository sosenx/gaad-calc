<?php 
namespace gcalc\pa;


class pa_print extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;

		if ( $this->validate_cargs() ) {
			parent::__construct( $product_attributes, $product_id, $parent, $group );
			$this->name = "pa_print";
			$this->calculator = new \gcalc\calc\pa_print( $product_attributes, $product_id, $parent, $group, $this );			
			$this->dependencies = NULL;		
			return $this;
		} else {
			return false;
		}
	}

	/*
	* 
	*/		
	private function validate_cargs(){		
		$valid = true;
		/*
		$pa_format = $this->get_carg('pa_format');
		if ( is_null( $pa_format )) {
			$this->parent->get_errors()->add( new \gcalc\error( 4002 ) );
			$this->set_errors( true );
			$valid = false;
		}
		*/
		$r=1;

		return $valid;
	}

	

}


?>