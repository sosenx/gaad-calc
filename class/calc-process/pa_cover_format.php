<?php 
namespace gcalc\pa;


class pa_cover_format extends \gcalc\cprocess{



	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;

		if ( $this->validate_cargs() ) {
			parent::__construct( $this->cargs, $product_id, $parent, $group );
			$this->name = "pa_cover_format";
			
			$this->calculator = new \gcalc\calc\pa_cover_format( $this->cargs, $product_id, $parent, $group, $this );
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

		$pa_wrap = $this->get_carg( 'pa_' . $group_name . '_finish' );
		$pa_spot_uv = $this->get_carg( 'pa_' . $group_name . '_spot_uv' );
		$pa_cloth_covering_wrap = $this->get_carg( 'pa_' . $group_name . '_cloth_covering_wrap' );
		$pa_cloth_covering_spot_uv = $this->get_carg( 'pa_' . $group_name . '_cloth_covering_spot_uv' );

		/*
		* Cover wrap, unsetting because cloth covering wrap is set
		*/
		if ( !is_null( $pa_cloth_covering_wrap ) && !is_null( $pa_wrap ) ) {
			$this->cargs['pa_' . $group_name . '_finish'] = '0x0';
			$this->parent->set_bvar('pa_finish', $group_name, '0x0', array( new \gcalc\error( 10014 ) ) );	
		}

		/*
		* Cover spot uv, unsetting because cloth covering spot uv is set
		*/
		if ( !is_null( $pa_cloth_covering_spot_uv ) && !is_null( $pa_spot_uv ) ) {
			$this->cargs['pa_' . $group_name . '_spot_uv'] = '0x0';
			$this->parent->set_bvar('pa_spot_uv', $group_name, '0x0', array( new \gcalc\error( 10015 ) ) );			
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