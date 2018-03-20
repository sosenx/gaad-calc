<?php 
namespace gcalc\pa;


class pa_format extends \gcalc\cprocess{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
		$this->name = "pa_format";
		$valid = false;
		$valid = $this->validate_cargs();

		if ( is_array( $valid ) ) {
			$this->cargs = $valid;
			$valid = true;
		}

		if ( $valid ) {
			parent::__construct( $this->cargs, $product_id, $this->parent, $this->group );		
			$this->calculator = new \gcalc\calc\pa_format( $this->cargs, $product_id, $this->parent, $this->group, $this );
			return $this;
		} else { return false; }
		
	}

	/*
	* 
	*/		
	private function validate_cargs(){		
		$valid = true;
		$group_name = $this->group[0];
		$pa_format = $this->get_carg( $this->group[1] );
		if ( is_null( $pa_format )) {
			$this->parent->get_errors()->add( new \gcalc\error( 4002, ' group_name: ' . $group_name ) );
			$this->set_errors( true );
			$valid = false;
		}

		$pa_print = $this->get_carg( 'pa_' . $group_name . '_print' );
		if ( is_null( $pa_print )) {
			$this->parent->get_errors()->add( new \gcalc\error( 4003, ' group_name: ' . $group_name ) );
			$this->set_errors( true );
			$valid = false;
		}

		$pa_paper = $this->get_carg( 'pa_' . $group_name . '_paper' );
		if ( is_null( $pa_paper )) {
			$this->parent->get_errors()->add( new \gcalc\error( 4004, ' group_name: ' . $group_name ) );
			$this->set_errors( true );
			$valid = false;
		}

		//$this->parent->set_bvar('pa_format', 'color', '210x297', array( new \gcalc\error( 10012, ' -> msadaasdsddddddddddddddddddddddddddddddddddddddddddddddat-' . $pa_spot_uv ) ) );	

		$valid = $this->validate_cargs_product( $valid );

		return $valid; 
	}

	/**
	 * Checks if product object have validation function and uses it
	 * @param  boolean $valid [description]
	 * @return [type]         [description]
	 */
	private function validate_cargs_product( $valid ){
		$product_class = 'gcalc\db\product\\' . $this->parent->get_slug();
		if ( $valid && class_exists( $product_class ) && method_exists( $product_class, 'validate_cargs') ) {
			$valid = $product_class::validate_cargs( $this, $this->cargs, $this->parent, $product_class );
			 //$valid = call_user_func( $product_class . '::validate_cargs', $this, $this->cargs, $this->parent, $product_class );
		}
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