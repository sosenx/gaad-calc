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


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		$this->parent = $parent;
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

		if ( !empty( $extended ) ) {
			$return['extended'] = $extended;
		}
		return $return;
	}

	/**
	* Getter for done
	*/
	function get_done( ){			
		return $this->done;
	}

	/**
	* Is double side
	*/
	function get_print_sides( ){			
		$pa_zadruk = $this->cargs['pa_zadruk'];
		$single = preg_match("/4x0|1x0/", $pa_zadruk);
		$double = preg_match("/4x4|1x1/", $pa_zadruk);
		return $double ? 1 : ( $single ? 0 : 1);		
	}


	/**
	* Is double side
	*/
	function get_print_color_mode( string $process_slug = "" ){			
		$process_slug = $process_slug == "" ? 'pa_zadruk' : $process_slug;
		$process_ = $this->cargs[ $process_slug ];
		$color = preg_match("/4x4|4x0/", $process_);
		$bw = preg_match("/1x1|1x0/", $process_);
		return $color ? '4x' : ( $bw ? '1x' : '4x');		
	}

	

}


?>