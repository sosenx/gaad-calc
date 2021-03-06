<?php 
namespace gcalc\pa;


class pa_multi_quantity extends \gcalc\cprocess{

	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
		$this->name = "pa_multi_quantity";
		
		$valid = false;
		$valid = $this->validate_cargs();

		if ( is_array( $valid ) ) {
			$this->cargs = $valid;
			$valid = true;
		}

		if ( $valid ) {
			parent::__construct( $this->cargs, $product_id, $parent, $group );		
			$this->calculator = new \gcalc\calc\pa_multi_quantity( $this->cargs, $product_id, $parent, $group, $this );
			return $this;
		} else { return false; }
	}

	/*
	* 
	*/		
	private function validate_cargs(){		
		$valid = true;
		return $this->validate_cargs_product( $valid );
	}

	/**
	 * Checks if product object have validation function and uses it
	 * @param  $valid [description]
	 * @return [type]         [description]
	 */
	private function validate_cargs_product( $valid ){
		$product_class = 'gcalc\db\product\\' . $this->parent->get_slug();
		if ( $valid && class_exists( $product_class ) && method_exists( $product_class, 'validate_cargs') ) {
			 $valid = call_user_func( $product_class . '::validate_cargs', $this, $this->cargs, $this->parent, $product_class );
		}
		return $valid;
	}

	/**
	*
	*/
	function get_carg( $arg_name ){
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