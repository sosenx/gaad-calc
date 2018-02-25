<?php 
namespace gcalc\pa;


class pa_spot_uv extends \gcalc\cprocess{

	/**
	* Product full set of arguments
	*/
	private $cargs = array();


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;

		if ( $this->validate_cargs() ) {
			parent::__construct( $this->cargs, $product_id, $parent, $group );
			$this->name = "pa_spot_uv";
			$this->cclass = "";
			$this->calculator = new \gcalc\calc\pa_spot_uv( $this->cargs, $product_id, $parent, $group, $this );
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
		
		$pa_wrap = $this->get_carg( 'pa_' . $group_name . '_wrap' );
		$pa_spot_uv = $this->get_carg( 'pa_' . $group_name . '_spot_uv' );

		/*
		* Adding wrap, before spot uv paper needs to be wrapped
		*/
		if ( is_null( $pa_wrap )) {			
			$process_name = 'pa_' . $group_name .'_wrap';			
			$this->parent->set_bvar('pa_wrap', $group_name, 'mat-' . $pa_spot_uv, array( new \gcalc\error( 10012, ' -> mat-' . $pa_spot_uv ) ) );						
			$this->cargs['pa_wrap'] = 'mat-'.$pa_spot_uv;
			$this->parent->add_todo_process( $this->cargs, array( $group_name,  $process_name )  );
		} else {
			/*
			* pa_wrap is set, checking if setting is correct
			*/

			//change gloss to mat
			if ( preg_match('/gloss-/', $pa_wrap) ) {
				$pa_wrap = str_replace( 'gloss-', 'mat-', $pa_wrap );
				$this->parent->set_bvar('pa_wrap', $group_name, 'mat-' . $pa_spot_uv, array( new \gcalc\error( 10013, ' -> mat-' . $pa_spot_uv ) ) );					
				$this->cargs['pa_wrap'] = 'mat-'.$pa_spot_uv;
			}	


			if ( preg_match('/1x0|1x1/', $pa_spot_uv) && preg_match('/0x0/', $pa_wrap) ) {
				$pa_wrap = 'mat-' . $pa_spot_uv;
				$this->parent->set_bvar('pa_wrap', $group_name, 'mat-' . $pa_spot_uv, array( new \gcalc\error( 10012, ' -> mat-' . $pa_spot_uv ) ) );					
				$this->cargs['pa_wrap'] = 'mat-'.$pa_spot_uv;	
							
			}
			
			$R=1;
				
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