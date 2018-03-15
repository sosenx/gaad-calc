<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

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
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = array( 


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
		}
	}
	
	

}

