<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class saddle_stitched_catalog extends catalog {
	
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
			'equasion' => 'pa_cover_type + pa_cover_paper + pa_cover_print + pa_cover_finish + pa_cover_spot_uv + pa_bw_paper + pa_bw_print + pa_color_paper + pa_color_print', 
			'order' => array ( 				
				'cover' => array( 'pa_cover_format','pa_cover_paper', 'pa_cover_print', '*' ),
			    'bw' => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*'),
			    'color' => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', '*' ),
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
				'post_title' => __( 'Saddle stitched catalog', 'gcalc' ),
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
				'pa_format' => array( 'default' => ''),
				'pa_quantity' => array( 'default' => ''),
				'pa_paper' => array( 'default' => ''),
				'pa_print' => array( 'default' => ''),
				'pa_finish' => array( 'default' => ''),
				'pa_spot_uv' => array( 'default' => ''),
				//'pa_folding' => array( 'default' => ''),
				'pa_cover_format' => array( 'default' => ''),
				'pa_cover_paper' => array( 'default' => ''),
				'pa_cover_print' => array( 'default' => ''),
				'pa_cover_type' => array( 'default' => ''),
				//'pa_cover_dust_jacket_paper' => array( 'default' => ''),
				//'pa_cover_dust_jacket_print' => array( 'default' => ''),
				//'pa_cover_dust_jacket_finish' => array( 'default' => ''),
				//'pa_cover_dust_jacket_spot_uv' => array( 'default' => ''),
				//'pa_cover_cloth_covering_paper' => array( 'default' => ''),
				//'pa_cover_cloth_covering_finish' => array( 'default' => ''),
				//'pa_cover_cloth_covering_print' => array( 'default' => ''),
				//'pa_cover_cloth_covering_spot_uv' => array( 'default' => ''),
				//'pa_cover_ribbon' => array( 'default' => ''),
				'pa_cover_finish' => array( 'default' => ''),
				'pa_cover_spot_uv' => array( 'default' => ''),
				'pa_cover_flaps' => array( 'default' => ''),
				'pa_cover_left_flap_width' => array( 'default' => ''),
				'pa_cover_right_flap_width' => array( 'default' => ''),
				//'pa_cover_board_thickness' => array( 'default' => ''),
				'pa_bw_pages' => array( 'default' => ''),
				'pa_bw_format' => array( 'default' => ''),
				'pa_bw_paper' => array( 'default' => ''),
				'pa_bw_print' => array( 'default' => ''),
				'pa_color_pages' => array( 'default' => ''),
				'pa_color_format' => array( 'default' => ''),
				'pa_color_paper' => array( 'default' => ''),
				'pa_color_print' => array( 'default' => ''),
				'pa_color_stack' => array( 'default' => '')				
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

				array( 'cover_type', array( 'saddle_stitch' ), '111' ),
				

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
			$this->attr = \gcalc\db\product\saddle_stitched_catalog::get_attr_defaults();
		}
	}
	
	

}

