<?php 
namespace gcalc;

/*
* Abstract for actual calculation class attached to cprocess object
*
*/
abstract class cprocess_calculation{

	/**
	* Process name
	*/
	public $name;

	/**
	* Product full set of arguments
	*/
	private $cargs;

	/**
	* Process dependencies
	*/
	private $dependencies;

	/**
	* Process calculator
	*/
	private $calculator;

	/**
	* total
	*/
	private $ptotal;

	/**
	* done with no errors
	*/
	private $done = false;

	/**
	* Reference to assosiated with calculation shop product object
	*/
	private $product_id;

	/**
	* Calculatro Class
	*/
	private $cclass;

	/**
	* Process group array
	*/
	private $group;

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		$this->parent = $parent;
		$this->group = $group;
		$this->product_id = $product_id;
		$this->cargs = $product_attributes;
		$this->cclass = get_class( $parent );
	}

	function do( ){	
		$this->ptotal = new \gcalc\ptotal( 0, "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

	/**
	* 
	*/
	function parse_total( array $calc_total, array $extended = array()){			
		$return = $calc_total;
		$return[ 'name' ] = $this->get_name();
		if ( !empty( $extended ) ) {
			$return['extended'] = $extended;
		}
		return $return;
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

	/**
	* Getter for done
	*/
	function get_done( ){			
		return $this->done;
	}

	/**
	* Getter parent
	*/
	public function get_parent( ){		
		return $this->parent;
	}

	/**
	* Is double side
	*/
	function get_print_sides( ){			
		$pa_print = $this->cargs['pa_print'];
		$single = preg_match("/4x0|1x0/", $pa_print);
		$double = preg_match("/4x4|1x1/", $pa_print);
		return $double ? 1 : ( $single ? 0 : 1);		
	}


	/**
	* Is double side
	*/
	function get_spot_uv_sides( ){			
		$group = $this->get_group();			
		$process_slug = $group[1];
		if ( array_key_exists($process_slug, $this->cargs ) ) {
			$pa_attr = $this->cargs[ $process_slug ];
		} elseif (!array_key_exists($process_slug, $this->cargs ) && preg_match('/_master_/', $process_slug) ) {
			$key = str_replace('master_', '', $process_slug );
			$pa_attr = $this->cargs[ $key ];
		}
		
		$single = preg_match("/1x0/", $pa_attr );
		$double = preg_match("/1x1/", $pa_attr );
		$none = preg_match("/0x0/", $pa_attr );
		return $double ? 1 : ( $single ? 0 : -1);		
	}


	/**
	* Is double side
	*/
	function get_print_color_mode( string $process_slug = "" ){			
		$group = $this->get_group();
		//$process_slug = $group[0] === 'master' ? $process_slug : 'pa_' . $group[0] . '_' . str_replace('pa_', '', $group[1]);
		$process_slug = str_replace('master_', '', str_replace('pa_', 'pa_'.$group[0].'_', $process_slug) );

		if ( !array_key_exists( $process_slug , $this->cargs) ) {
			$process_slug = str_replace( $group[0].'_', '', $process_slug );
		} 

		$process_ = $this->cargs[ $process_slug ];
		$color = preg_match("/4x4|4x0/", $process_);
		$bw = preg_match("/1x1|1x0/", $process_);
		$noprint = preg_match("/0x0/", $process_);
		if ($noprint) {
			return '0x';
		}
		return $color ? '4x' : ( $bw ? '1x' : '1x');		
	}

	/**
	* Getter for name
	*/
	function get_name( ){					
		return $this->group[1];
	}

	
	/**
	* Getter for group
	*/
	function get_group( ){					
		return $this->group;
	}


	/**
	* Getter for cargs
	*/
	function get_cargs( ){					
		return $this->cargs;
	}

}


?>