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

	/**
	* Process group array
	*/
	private $pa_parent;

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group, \gcalc\cprocess $pa_parent ){	
		$this->parent = $parent;
		$this->pa_parent = $pa_parent;
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


	function get_val_from( string $factor, string $compare, array $scale, string $outside_factor = NULL ){
		$compare_sign = array(
			'exact' => '==',
			'min' => '>='
		);
		$attr = is_null( $outside_factor ) ? $this->get_carg( $factor ) : $outside_factor ;		
		
		if ( $compare_sign[ $compare ] !== '==' ) {
			$array = array();
			foreach ($scale as $key => $value) {
				$array[(int)$value['v']] = $value['price']; 
			}
			asort($array);
		} else {
			$array = $scale;
			foreach ($array as $key => $value) {	
				if ( $value['v'] == $attr) {
					return $value;	
				}
			}


		}	
			
		foreach ($array as $key => $value) {
			$eval_str = '$comp = ' .$attr . ' ' . $compare_sign[ $compare ] . ' '. $key .';';			
			$comp_str = eval( $eval_str ); 			
			if ($comp) {
				$return = $array[$key];		
				return $return;	
			}
			
		}		
		
	}


/**
	* Calculates paper cost and margin
	*/
	function get_pages(){
		$group_name = $this->get_group()[0];		
		foreach ($this->cargs as $key => $value) {
			//var_dump(preg_match( '/'.$group_name.'_pages/', $key ), $key, $group_name);
			if ( preg_match( '/'.$group_name.'_pages/', $key ) ) {
				return $value;
				var_dump($value);
			}
		}
	return 1;
	}

	/**
	* 
	*/
	function parse_total( array $calc_total, array $extended = array()){			
		$return = $calc_total;
		$return[ 'name' ] = $this->get_name();

		//checking credentials for data filter		
		$credetials = $this->parent->login();
		$al = $credetials['access_level'];

		if ( !empty( $extended ) && ( $al >=  1 ) ) {
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
	* Getter pa_parent
	*/
	public function get_pa_parent( ){		
		return $this->pa_parent;
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

		$process__ = $this->get_carg( $process_slug );
		if ( is_null( $process__ ) ) {
			$this->parent->get_errors()->add( new \gcalc\error( 4003 ) );
			//$this->set_errors( true );
			return '0x';
		}

		$process_ = $this->cargs[ $process_slug ];
		$color = preg_match("/4x4|4x0/", $process_);
		$bw = preg_match("/1x1|1x0/", $process_);
		$noprint = preg_match("/0x0/", $process_);
		if ($noprint) {
			return '0x';
		}
		return $color ? '4x' : ( $bw ? '1x' : '0x');		
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