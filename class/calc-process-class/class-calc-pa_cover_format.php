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
	* spine thickness
	*/
	private $spine;

	/**
	* spine thickness
	*/
	private $flaps;
	
	/**
	* best_production_format object
	*/
	private $best_production_format;

	/**
	* Process errors
	*/
	private $errors = false;

	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		$this->cargs = $product_attributes;
		$this->parent = $parent;
		$this->group = $group;
		
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );		
		$this->name = "pa_cover_format";				
		$this->dependencies = NULL;
		$this->parse_dimensions();
		$this->calculate_best_production_format();
		return $this;
			
	}



	

	/**
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			

		/**
		 * Function override by product contructor method
		 *
		 * method name should be calc__[cprocess class name]
		 */
		$product_constructor_method = $this->parent->get_product_constructor_method( 'calc__' . substr( __CLASS__, strrpos( __CLASS__, '\\') + 1 ), $this->parent->get_bvar('product_slug') );
		if ( $product_constructor_method['exists'] ) {
			$calculation_override = $product_constructor_method['product_constructor_name'].'::'.$product_constructor_method['method_name'];	
			return $calculation_override( $this );	
		}

		/**
		 * Normal algorithm
		 */

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
				'spine' => $this->spine,
				'production_format_short' => $pf['format'].' '.$grain.' ('. $pf['common_format']['width'] .'x'. $pf['common_format']['height'] . ')',
				'production_format' => $pf
			)
		);
	}

	/**
	*
	*/
	function parse_dimensions( ){	

		/**
		 * Function override by product contructor method
		 *
		 * method name should be parse_dimensions__[cprocess class name]
		 */
		$product_constructor_method = $this->parent->get_product_constructor_method( 'parse_dimensions__' . substr( __CLASS__, strrpos( __CLASS__, '\\') + 1 ), $this->parent->get_bvar('product_slug') );
		if ( $product_constructor_method['exists'] ) {
			$calculation_override = $product_constructor_method['product_constructor_name'].'::'.$product_constructor_method['method_name'];	
			return $calculation_override( $this );	
		}


		$group = $this->get_group();
		$array_key = str_replace('master_', '', 'pa_' . $group[0] . '_format');
		$pa_cover_flaps = $this->get_carg( 'pa_cover_flaps' );

		if ( array_key_exists( $array_key, $this->get_cargs() ) ) {
			$dim = explode( "x", $this->get_cargs()[ $array_key ] ); 
		} else  {
			$dim = explode( "x", $this->get_cargs()[ 'pa_format' ] );
		}		

		if ( !$pa_cover_flaps ) {
			$width = (int)$dim[0] * 2 + $this->calc_spine();
		} else {
			$width = (int)$dim[0] * 2 + $this->calc_spine();
			$max_width = 680;
			$max_flaps_width = $max_width - $width >= $dim[0] * 2 * .9 ? $max_width - $width : $dim[0] * 2 * .9;
			$pa_cover_left_flap_width = $this->get_carg( 'pa_cover_left_flap_width' );
			$pa_cover_right_flap_width = $this->get_carg( 'pa_cover_right_flap_width' );
			$total_declared_flaps_width = $pa_cover_right_flap_width + $pa_cover_left_flap_width;
			if ( $total_declared_flaps_width > $max_flaps_width ) {				
				$this->set_carg( 'pa_cover_left_flap_width', $max_flaps_width / 2 );
				$this->set_carg( 'pa_cover_right_flap_width', $max_flaps_width / 2 );
				$total_declared_flaps_width = $max_flaps_width;
			} 
			$width += $total_declared_flaps_width;
		}

		$this->set_width($width);
		$this->set_height( (int)$dim[1] );
	}

	/**
	* Calculates spine thickness
	*/
	public function calc_spine(  ){		
		$production_paper_db = new \gcalc\db\production\paper();
		$pa_color_paper = $this->get_carg( 'pa_color_paper' );
		$pa_bw_paper = $this->get_carg( 'pa_bw_paper' );
		$pa_bw_pages = $this->get_carg( 'pa_bw_pages' );
		$pa_color_pages = $this->get_carg( 'pa_color_pages' );		


		$pa_color_paper = is_null( $pa_color_paper ) ? NULL : $production_paper_db->get_paper( $pa_color_paper );
		$pa_bw_paper = is_null( $pa_bw_paper ) ? NULL : $production_paper_db->get_paper( $pa_bw_paper );

		$bw_block = !is_null( $pa_bw_paper ) ? $pa_bw_pages / 2 * $pa_bw_paper['thickness'] : 0;
		$color_block = !is_null( $pa_color_paper ) ? $pa_color_pages / 2 * $pa_color_paper['thickness'] : 0;
		$this->spine = $bw_block + $color_block;
		return $this->spine;
	}


	/**
	 * Getter for spine
	 * @return [type] [description]
	 */
	function get_spine( ){
		return $this->spine;
	}

}


?>