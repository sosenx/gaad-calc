<?php 
namespace gcalc\calc;


class pa_cover_format extends pa_format{

	/**
	* net width
	*/
	private $width;

	/**
	* net height
	*/
	private $height;
	
	/**
	* best_production_format object
	*/
	private $best_production_format;


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->group = $group;
		$this->name = "pa_cover_format";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->parse_dimensions();
		$this->calculate_best_production_format();

		return $this;
	}

	/**
	*
	*/
	function parse_dimensions( ){	
		$group = $this->get_group();
		$array_key = str_replace('master_', '', 'pa_' . $group[0] . '_format');

		if ( array_key_exists( $array_key, $this->get_cargs() ) ) {
			$dim = explode( "x", $this->get_cargs()[ $array_key ] ); 
		} else  {
			$dim = explode( "x", $this->get_cargs()[ 'pa_format' ] );
		}		
		$this->set_width((int)$dim[0]*2);
		$this->set_height((int)$dim[1]);		
	}

	
}


?>