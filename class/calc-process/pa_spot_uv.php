<?php 
namespace gcalc\pa;


class pa_spot_uv extends \gcalc\cprocess{

	
	function __construct( array $product_attributes, integer $product_id, \gcalc\calculate $parent, array $group ){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
		$this->name = "pa_spot_uv";

		$valid = false;
		$valid = $this->validate_cargs();

		if ( is_array( $valid ) ) {
			$this->cargs = $valid;
			$valid = true;
		}

		if ( $valid ) {
			parent::__construct( $this->cargs, $product_id, $parent, $group );		
			$this->calculator = new \gcalc\calc\pa_spot_uv( $this->cargs, $product_id, $parent, $group, $this );
			return $this;
		} else { return false; }
	}


	/*
	* 
	*/		
	private function validate_cargs(){		
		$valid = true;
		$group_name = $this->group[0];
		
		$pa_wrap = $this->get_carg( 'pa_' . $group_name . '_finish' );
		$pa_spot_uv = $this->get_carg( 'pa_' . $group_name . '_spot_uv' );

		/*
		* Adding wrap, before spot uv paper needs to be wrapped
		*/
		if ( is_null( $pa_wrap )) {			
			$process_name = 'pa_' . $group_name .'_finish';			
			$this->parent->set_bvar('pa_finish', $group_name, 'mat-' . $pa_spot_uv, array( new \gcalc\error( 10012, ' -> mat-' . $pa_spot_uv ) ) );						
			$this->cargs['pa_finish'] = 'mat-'.$pa_spot_uv;
			$this->parent->add_todo_process( $this->cargs, array( $group_name,  $process_name )  );
		} else {
			/*
			* pa_wrap is set, checking if setting is correct
			*/

			//change gloss to mat
			if ( preg_match('/gloss-/', $pa_wrap) ) {
				$pa_wrap = str_replace( 'gloss-', 'mat-', $pa_wrap );
				$this->parent->set_bvar('pa_finish', $group_name, 'mat-' . $pa_spot_uv, array( new \gcalc\error( 10013, ' -> mat-' . $pa_spot_uv ) ) );					
				$this->cargs['pa_finish'] = 'mat-'.$pa_spot_uv;
			}	


			if ( preg_match('/1x0|1x1/', $pa_spot_uv) && preg_match('/0x0/', $pa_wrap) ) {
				$pa_wrap = 'mat-' . $pa_spot_uv;
				$this->parent->set_bvar('pa_finish', $group_name, 'mat-' . $pa_spot_uv, array( new \gcalc\error( 10012, ' -> mat-' . $pa_spot_uv ) ) );					
				$this->cargs['pa_finish'] = 'mat-'.$pa_spot_uv;	
							
			}
		return $this->validate_cargs_product( $valid );
		}

	}

	/**
	 * Checks if product object have validation function and uses it
	 * @param  boolean $valid [description]
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