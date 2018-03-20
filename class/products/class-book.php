<?php
namespace gcalc\db\product;

/**
* 
*/
class book extends product {
	
	public $base;
	public $attr;

	function __construct( array $base = NULL, array $attr = NULL )	{
		parent::__construct( $base, $attr );
		
		$this->set_base_defaults( );
		$this->set_attr_defaults( );
		
		$this->set_title( );
		$this->set_exists( );

		$this->create_product( );
		$this->add_product_attributes( );
	}


	/**
	 * Return product specific data for frontend rest endpoint
	 * @return array Product costruction data
	 */
		public static function get_rest_data(  ){
			$r = array();
			$r['KOOT'] = 'JEST KTAKI KOCHANY';
			return $r;
		}

	/**
	 * Method overrides cprocess pa_cover_format.
	 *
	 * Method should be clone of original function with nessesary modifcations or there can be calculations issues
	 * 
	 * @param  [type] $cprocess [description]
	 * @return [type]           [description]
	 */
	public static function parse_dimensions__pa_format( $cprocess )	{
		
		//var_dump($cprocess->get_cargs()['pa_cover_format']);
		$group = $cprocess->get_group();
		$array_key = str_replace('master_', '', 'pa_format');

		if ( array_key_exists( $array_key, $cprocess->get_cargs() ) ) {
			$dim = explode( "x", $cprocess->get_cargs()[ $array_key ] ); 
		} else  {
			$dim = explode( "x", $cprocess->get_cargs()[ 'pa_format' ] );
		}		
		$cprocess->set_width((int)$dim[0]);
		$cprocess->set_height((int)$dim[1]);
	}


	/**
	 * Returns product calculation data
	 * @return [type] [description]
	 */
	public static function get_calc_data( string $key = NULL ){
		$calc_data = array(
			'equasion' => 'pa_cover_type + pa_cover_paper + pa_cover_print + pa_cover_finish + pa_cover_spot_uv + pa_bw_paper + pa_bw_print + pa_color_paper + pa_color_print + pa_bw_sewing + pa_color_sewing', 
			'order' => array ( 
				'master' =>array('pa_master_format', '*'),
				'cover' => array( 'pa_cover_format','pa_cover_paper', 'pa_cover_print', '*' ),
			    'bw' => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*'),
			    'color' => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', '*' ),
			)
		);
		return is_null( $key ) ? $calc_data : ( array_key_exists( $key, $calc_data ) ? $calc_data[ $key ] : $calc_data );
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
				'pa_folding' => array( 'default' => ''),
				'pa_cover_format' => array( 'default' => ''),
				'pa_cover_paper' => array( 'default' => ''),
				'pa_cover_print' => array( 'default' => ''),
				'pa_cover_type' => array( 'default' => ''),
				'pa_cover_dust_jacket_paper' => array( 'default' => ''),
				'pa_cover_dust_jacket_print' => array( 'default' => ''),
				'pa_cover_dust_jacket_finish' => array( 'default' => ''),
				'pa_cover_dust_jacket_spot_uv' => array( 'default' => ''),
				'pa_cover_cloth_covering_paper' => array( 'default' => ''),
				'pa_cover_cloth_covering_finish' => array( 'default' => ''),
				'pa_cover_cloth_covering_print' => array( 'default' => ''),
				'pa_cover_cloth_covering_spot_uv' => array( 'default' => ''),
				'pa_cover_ribbon' => array( 'default' => ''),
				'pa_cover_finish' => array( 'default' => ''),
				'pa_cover_spot_uv' => array( 'default' => ''),
				'pa_cover_flaps' => array( 'default' => ''),
				'pa_cover_left_flap_width' => array( 'default' => ''),
				'pa_cover_right_flap_width' => array( 'default' => ''),
				'pa_cover_board_thickness' => array( 'default' => ''),
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
	 * setter for base
	 * @param array $base Array of primary product parameters
	 */
	function set_base_defaults( ){
		
		if ( empty( $this->base ) || is_null( $this->base ) ) {
			$this->base = array(
				'post_title' => __( 'Book', 'gcalc' ),
				'post_content' => __( '', 'gcalc' ),
				'author' => 1
			);	
		}	
	}

	/**
	 * Gettr for default attributes values
	 * @return array Default attributes values
	 */
		public static function get_attr_defaults( ){
			$r = array( 

				array( 'format', 		array( 'custom-format' ), '111' ),				
				array( 'cover_format', 	array( 'custom-format' ), '111' ),
				array( 'pa_cover_format', 	array( 'custom-format' ), '111' ),
				array( 'pa_bw_format', 	array( 'custom-format' ), '111' ),
				array( 'pa_color_format', 	array( 'custom-format' ), '111' ),
				array( 'volume', array( 'custom-volume' ), '111' ),				
				array( 'paper', array( 
					'couted-70g', 'couted-80g', 'couted-90g', 'couted-115g', 'couted-135g','couted-170g', 'couted-250g', 'couted-300g', 'couted-350g',
					'uncouted-70g', 'uncouted-80g', 'uncouted-90g', 'uncouted-100g', 'uncouted-120g', 'uncouted-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),
				array( 'cover_paper', array( 
					'couted-300g', 'couted-350g'
				), '111' ),
				array( 'cover_dust_jacket_paper', array( 
					'couted-170g', 'couted-250g'
				), '111' ),
				array( 'cover_cloth_covering_paper', array( 
					'couted-170g'
				), '111' ),
				array( 'bw_paper', array( 
					'couted-70g', 'couted-80g', 'couted-90g', 'couted-115g', 'couted-135g','couted-170g', 'couted-250g', 'couted-300g', 'couted-350g',
					'uncouted-70g', 'uncouted-80g', 'uncouted-90g', 'uncouted-100g', 'uncouted-120g', 'uncouted-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),
				array( 'color_paper', array( 
					'couted-70g', 'couted-80g', 'couted-90g', 'couted-115g', 'couted-135g','couted-170g', 'couted-250g', 'couted-300g', 'couted-350g',
					'uncouted-70g', 'uncouted-80g', 'uncouted-90g', 'uncouted-100g', 'uncouted-120g', 'uncouted-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),

				array( 'cover_type', array( 'perfect_binding', 'saddle_stitch', 'spiral_binding', 'section_sewn', 'hard' ), '111' ),
				

				array( 'spot_uv', array( '0x0', '1x0', '1x1' ), '111' ),
				array( 'cover_spot_uv', array( '0x0', '1x0', '1x1' ), '111' ),
				array( 'cover_cloth_covering_spot_uv', array( '0x0', '1x0', '1x1' ), '111' ),
				array( 'cover_dust_jacket_spot_uv', array( '0x0', '1x0', '1x1' ), '111' ),

				array( 'finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_cloth_covering_finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_dust_jacket_finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),

				array( 'print', 		array( '1x0','1x1','4x0','4x4' ), '111' ),
				array( 'cover_print', array( '4x4', '4x0' ), '111' ),
				array( 'cover_cloth_covering_print', array( '4x4', '4x0' ), '111' ),
				array( 'cover_dust_jacket_print', array( '4x4', '4x0' ), '111' ),
				

				array( 'cover_ribbon', array( 'true', 'false' ), '111' ),
				array( 'cover_flaps', array( 'true', 'false' ), '111' ),
				array( 'cover_left_flap_width', array( 'custom-value' ), '111' ),
				array( 'cover_right_flap_width', array( 'custom-value' ), '111' ),
				array( 'cover_board_thickness', array( 'custom-value' ), '111' ),

				array( 'bw_pages', array( 'custom-value' ), '111' ),
				array( 'cover_board_thickness', array( 'custom-value' ), '111' ),
				array( 'color_pages', array( 'custom-value' ), '111' ),

				array( 'color_stack', array( 'stack', 'shuffled' ), '111' ),
			);
			


			return $r;
		}


	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\product::get_attr_defaults();
		}
	}
	
	

}

