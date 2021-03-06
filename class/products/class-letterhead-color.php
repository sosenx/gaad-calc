<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class letterhead_color extends letterhead {
	
	public $base;
	public $attr;

	function __construct( $base = NULL, $attr = NULL )	{
		parent::__construct( $base, $attr );
		
		$this->set_base_defaults( );
		$this->set_attr_defaults( );
		
		$this->set_title( );
		$this->set_exists( );

		$this->create_product( );
		$this->add_product_attributes( );
	}

	/**
	 * Returns product calculation data
	 * @return [type] [description]
	 */
	public static function get_calc_data( $key = NULL ){
		$calc_data = array(
			'equasion' => 'pa_color_paper + pa_color_print', 
			'order' => array ( 				
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print' )
			)
		);
		return is_null( $key ) ? $calc_data : ( array_key_exists( $key, $calc_data ) ? $calc_data[ $key ] : $calc_data );
	}

	/**
	 * setter for base
	 * @param $base Array of primary product parameters
	 */
	function set_base_defaults( ){
		
		if ( empty( $this->base ) || is_null( $this->base ) ) {
			$this->base = array(
				'post_title' => __( 'Letterhead color', 'gcalc' ),
				'post_content' => __( '', 'gcalc' ),
				'author' => 1
			);	
		}	
	}
	
	/**
	 * Getter for attributes default values
	 * @return [type] [description]
	 */
	public static function get_attr_defaults(  ){
		$r = array( 
				array( 'format', 			array( '210x297', 'custom-value' ), '111' ),												
				
				array( 'pa_color_format', 	array( '210x297', 'custom-value' ), '111' ),

				array( 'volume', array( '1','2','3','4','5','6','7','8','9','10','custom-value' ), '111' ),
				
				array( 'paper', array( 
					'coated-70g', 'coated-80g', 'coated-90g', 'coated-115g', 'coated-135g','coated-170g', 'coated-250g', 'coated-300g', 'coated-350g',
					'uncoated-70g', 'uncoated-80g', 'uncoated-90g', 'uncoated-100g', 'uncoated-120g', 'uncoated-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),				
				
				
				array( 'color_paper', array( 
					'coated-70g', 'coated-80g', 'coated-90g', 'coated-115g', 'coated-135g','coated-170g', 'coated-250g', 'coated-300g', 'coated-350g',
					'uncoated-70g', 'uncoated-80g', 'uncoated-90g', 'uncoated-100g', 'uncoated-120g', 'uncoated-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),
				
				array( 'print', 		array( '4x0','4x4' ), '111' ),				
				array( 'color_pages', array( '500' ), '111' )					
			);
		return $r;
	}

	/**
	 * setter for product attributes array
	 * @param $attr peoduct attributes array
	 */
	public function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\letterhead_color::get_attr_defaults();
		}
	}
}

