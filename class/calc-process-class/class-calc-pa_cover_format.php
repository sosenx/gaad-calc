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
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			
		$pf = $this->parent->get_best_production_format( $this->group );	
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		$markup_ = 1;		
		$production_cost = $sheets_quantity * 0;
		$total_price = $production_cost * $markup_;
		$grain = $pf['grain'];

		return $this->parse_total( 			
			array(
				
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(				
				'product' => array(
					'width' => $this->get_width(),
					'height' => $this->get_height(),
				),
				'sheets_quantity' => $sheets_quantity,
				'production_format_short' => $pf['format'].' '.$grain.' ('. $pf['common_format']['width'] .'x'. $pf['common_format']['height'] . ')',
				'production_format' => $pf
			)
		);
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
		$this->set_width((int)$dim[0] * 2 + $this->calc_spine() );
		$this->set_height( (int)$dim[1] );
	}

	/**
	* Calculates spine thickness
	*/
	private function calc_spine(  ){		
		$production_paper_db = new \gcalc\db\production\paper();
		$pa_color_paper = $this->get_carg( 'pa_color_paper' );
		$pa_bw_paper = $this->get_carg( 'pa_bw_paper' );
		$pa_bw_pages = $this->get_carg( 'pa_bw_pages' );
		$pa_color_pages = $this->get_carg( 'pa_color_pages' );

		$pa_color_paper = $production_paper_db->get_paper( $pa_color_paper );
		$pa_bw_paper = $production_paper_db->get_paper( $pa_bw_paper );

		$bw_block = !is_null( $pa_bw_paper ) ? $pa_bw_pages / 2 * $pa_bw_paper['thickness'] : 0;
		$color_block = !is_null( $pa_color_paper ) ? $pa_color_pages / 2 * $pa_color_paper['thickness'] : 0;

		return $bw_block + $color_block;
	}


}


?>