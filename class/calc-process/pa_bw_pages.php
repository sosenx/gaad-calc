<?php 
namespace gcalc\pa;


class pa_bw_pages extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;

		if ( $this->validate_cargs() ) {
			parent::__construct( $this->cargs, $product_id, $parent, $group );
			$this->name = "pa_bw_pages";
			$this->calculator = new \gcalc\calc\pa_bw_pages( $this->cargs, $product_id, $parent, $group, $this );
			$this->cargs = $product_attributes;
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
		$group_name = $this->group[0];
		/*
		$pa_format = $this->get_carg( $this->group[1] );
		if ( is_null( $pa_format )) {
			$this->parent->get_errors()->add( new \gcalc\error( 4002, ' group_name: ' . $group_name ) );
			$this->set_errors( true );
			$valid = false;
		}

		
		

*/

		$r=1;

		return $valid;
	}







	/**
	*
	*/
	function get_carg( string $arg_name ){
		if ( !array_key_exists( $arg_name, $this->cargs ) ) {
			$arg_name = str_replace( '_master', '', $arg_name);
			if ( array_key_exists( $arg_name, $this->cargs ) ) {
				return $this->cargs[ $arg_name ];
			}
		} else return $this->cargs[ $arg_name ];
		return null;
	}


}


?>