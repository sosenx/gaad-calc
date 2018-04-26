<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class catalog extends product {
	
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
	 * setter for base
	 * @param $base Array of primary product parameters
	 */
	function set_base_defaults( ){
		
		if ( empty( $this->base ) || is_null( $this->base ) ) {
			$this->base = array(
				'post_title' => __( 'Catalog', 'gcalc' ),
				'post_content' => __( '', 'gcalc' ),
				'author' => 1
			);	
		}	
	}



/**
	 * Return array with essential attributes list and some attributes base parameters (the last one is work in progress)
	 * 
	 * @return [type] [description]
	 */
	public static function get_attr_filter( ) {
		
		$attr_filter = array(
			'groups'=> array( 'cover', 'bw', 'color' ),		
			'matrix' => array(		
				'format' => array( 'default' => ''),
				'cover_format' => array( 'default' => ''),
				'pa_cover_format' => array( 'default' => ''),
				'pa_color_format' => array( 'default' => ''),
				'volume' => array( 'default' => ''),
				'paper' => array( 'default' => ''),
				'cover_paper' => array( 'default' => ''),
				'color_paper' => array( 'default' => ''),
				'cover_type' => array( 'default' => ''),
				'spot_uv' => array( 'default' => ''),
				'cover_spot_uv' => array( 'default' => ''),
				'finish' => array( 'default' => ''),
				'cover_finish' => array( 'default' => ''),
				'print' => array( 'default' => ''),
				'cover_print' => array( 'default' => ''),
				'cover_flaps' => array( 'default' => ''),
				'cover_left_flap_width' => array( 'default' => ''),
				'cover_right_flap_width' => array( 'default' => ''),
				'color_pages' => array( 'default' => '')
				
			)

		);
		return $attr_filter;
	}

/**
	 * Getter for attributes default values
	 * @return [type] [description]
	 */
	public static function get_attr_defaults(  ){
		$r = array( 
				array( 'format', 		array( 'custom-value' ), '111' ),				

				array( 'cover_format', 	array( 'custom-value' ), '111' ),
				array( 'pa_cover_format', 	array( 'custom-value' ), '111' ),				
				array( 'pa_color_format', 	array( 'custom-value' ), '111' ),

				array( 'volume', array( '10','20','30','40','50','100','200','300','400','500','custom-value' ), '111' ),
				
				array( 'paper', array( 
					'coated-70g', 'coated-80g', 'coated-90g', 'coated-115g', 'coated-135g','coated-170g', 'coated-250g', 'coated-300g', 'coated-350g',
					'uncoated-70g', 'uncoated-80g', 'uncoated-90g', 'uncoated-100g', 'uncoated-120g', 'uncoated-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),
				array( 'cover_paper', array( 
					'coated-115g', 'coated-135g','coated-170g', 'coated-250g', 'coated-300g', 'coated-350g',
				), '111' ),
				
				array( 'color_paper', array( 
					'coated-115g', 'coated-135g','coated-170g', 'coated-250g', 'coated-300g', 'coated-350g',
				), '111' ),

				array( 'cover_type', array( 'Perfect binding', 'Saddle stitch', 'Spiral binding' ), '111' ),
				

				array( 'spot_uv', array( '0x0', '1x0', '1x1' ), '111' ),
				array( 'cover_spot_uv', array( '0x0', '1x0', '1x1' ), '111' ),
				
				array( 'finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				
				array( 'print', 		array( '1x0','1x1','4x0','4x4' ), '111' ),
				array( 'cover_print', array( '4x4', '4x0' ), '111' ),
				
				array( 'cover_flaps', array( 'true', 'false' ), '111' ),
				array( 'cover_left_flap_width', array( 'custom-value' ), '111' ),
				array( 'cover_right_flap_width', array( 'custom-value' ), '111' ),

				array( 'color_pages', array( 'custom-value' ), '111' ),
			);
		return $r;
	}

	/**
	 * setter for product attributes array
	 * @param $attr peoduct attributes array
	 */
	public function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\catalog::get_attr_defaults();
		}
	}
	
	

}

