<?php 
namespace gcalc\calc;


class pa_format extends \gcalc\cprocess_calculation{

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


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->group = $group;
		$this->name = "pa_format";		
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
	* Calculates best production format fit
	*/
	function calc_common_format(  ){	
		$width = $this->get_width();
		$height = $this->get_height();
		
		$production_formats = new \gcalc\db\production\formats();
		$common_format = $production_formats->get_common_format();

		$checked_formats = array();

		foreach ( $common_format as $key => $cformat) {
			if ( $cformat['width'] >= $width && $cformat['height'] >= $height ) {
				$cformat['name'] = $key;
				return $cformat;				
			}
		}
		return false;
	}	

	/**
	* Calculates best production format fit
	*/
	function calculate_best_production_format( ){	
		$best_production_format_check = $this->parent->check_best_production_format( $this->group );

		if ( $best_production_format_check ) {
			$this->best_production_format = $best_production_format_check;
		} else {
			$production_formats = new \gcalc\db\production\formats();
			$all_formats = $production_formats->get_formats();
		
			$print_color_mode = $this->get_print_color_mode('pa_print');
			$std_format = $this->calc_common_format(); //a4, a5 etc 
			$name = $this->get_name();
			$this->best_production_format = $production_formats->get_production_format( $std_format, $print_color_mode, $name );
			$this->parent->set_best_production_format( $this->best_production_format, $this->group );
		}		
	}

	/**
	*
	*/
	function str_dim_to_format( string $format_str ){	
		$production_formats = new \gcalc\db\production\formats();
		$str_dim_to_format = $production_formats->get_str_dim_to_format( $format_str );

		return $str_dim_to_format;
	}

	/**
	*
	*/
	function do__( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
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

		if ( array_key_exists( $array_key, $this->get_cargs() ) ) {
			$dim = explode( "x", $this->get_cargs()[ $array_key ] ); 
		} else  {
			$dim = explode( "x", $this->get_cargs()[ 'pa_format' ] );
		}		
		$this->set_width((int)$dim[0]);
		$this->set_height((int)$dim[1]);		
	}

	/**
	* Getter for width
	*
	*/
	function get_width( ){			
		return $this->width;		
	}

	/**
	* Getter for height
	*
	*/
	function get_height( ){			
		return $this->height;		
	}
	/**
	* Setter for width
	*
	*/
	function set_width( $val ){			
		$this->width = $val;		
	}

	/**
	* Setter for height
	*
	*/
	function set_height( $val ){			
		$this->height = $val;		
	}

}


?>