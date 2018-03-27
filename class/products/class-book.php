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
	 * rETURNS ATTRIBUTES BLACK AND WHITE LIST OF VALUES
	 * @return [type] [description]
	 */
	public static function get_attr_bw_lists( ){
		$r = array(

array(
	'name' => 'pa_cover_print',
	'data' => array(
		'4x0' => array(
			'pa_cover_finish' => array(
				'values' => array( 'gloss-1x0', 'matt-1x0', 'soft-touch-1x0'),
				'default' => 'matt-1x0'
			)
		),
		'4x4' => array(
			'pa_cover_finish' => array(
				'values' => array( 'gloss-1x0', 'matt-1x0', 'soft-touch-1x0' ),
				'default' => 'matt-1x0'
			)
		)
	)
),
array(
	'name' => 'pa_cover_finish',
	'data' => array(
		'1x0' => array(
			'pa_cover_spot_uv' => array(
				'values' => array( '0x0', '1x0' ),
				'default' => '0x0'
			)
		)
	)
),
array(
	'name' => 'pa_cover_spot_uv',
	'data' => array(
		'0x0' => array(
			'pa_cover_finish' => array(
				'values' => array( 'gloss-1x0', 'matt-1x0', 'soft-touch-1x0' ),
				'default' => 'matt-1x0'
			)
		),
		'1x0' => array(
			'pa_cover_finish' => array(
				'values' => array( 'matt-1x0', 'soft-touch-1x0' ),
				'default' => 'matt-1x0'
			)
		)
	)
),
array(
	'name' => 'pa_cover_ribbon',
	'data' => array(
		'ribbon-0' => array(
			'pa_cover_ribbon_width' => array(
				'values' => array( 'ribbon-0' ),
				'default' => 'ribbon-0'
			)
		),
		'ribbon-.*' => array(
			'pa_cover_ribbon_width' => array(
				'values' => array( 'ribbon-3', 'ribbon-6' ),
				'default' => 'ribbon-3'
			)
		),
	)
)







			
		);
			
		return $r;
	}	
	
	/**
	 * Returns validations object for vuelidate
	 * @return [type] [description]
	 */
		public static function get_form_validations(  ){
			$r = array(
				'matrix' => array(		
					'pa_format' => 							array( 'required' => false ),
					'pa_quantity' => 						array( 'required' => true, 	'minValue' => 10, 	'maxValue' => 1500 ),
					'pa_paper' => 							array( 'required' => false ),
					'pa_print' => 							array( 'required' => false ),
					'pa_finish' => 							array( 'required' => false ),
					'pa_spot_uv' => 						array( 'required' => false ),
					'pa_folding' => 						array( 'required' => false ),
					'pa_cover_format' => 					array( 'required' => false ),
					'pa_cover_paper' => 					array( 'required' => false, 'selected' => ''),
					'pa_cover_print' => 					array( 'required' => false ),
					'pa_cover_type' => 						array( 'required' => false ),
					'pa_cover_dust_jacket_paper' => 		array( 'required' => false ),
					'pa_cover_dust_jacket_print' => 		array( 'required' => false ),
					'pa_cover_dust_jacket_finish' => 		array( 'required' => false ),
					'pa_cover_dust_jacket_spot_uv' => 		array( 'required' => false ),
					'pa_cover_cloth_covering_paper' => 		array( 'required' => false ),
					'pa_cover_cloth_covering_finish' => 	array( 'required' => false ),
					'pa_cover_cloth_covering_print' => 		array( 'required' => false ),
					'pa_cover_cloth_covering_spot_uv' => 	array( 'required' => false ),
					'pa_cover_ribbon' => 					array( 'required' => false ),
					'pa_cover_finish' => 					array( 'required' => false ),
					'pa_cover_spot_uv' => 					array( 'required' => false ),
					'pa_cover_flaps' => 					array( 'required' => false ),
					'pa_cover_left_flap_width' => 			array( 'required' => false ),
					'pa_cover_right_flap_width' => 			array( 'required' => false ),
					'pa_cover_board_thickness' => 			array( 'required' => false ),
					'pa_bw_pages' => 						array( 'required' => true, 	'minValue' => 2, 	'maxValue' => 500 ),
					'pa_bw_format' => 						array( 'required' => false ),
					'pa_bw_paper' => 						array( 'required' => false ),
					'pa_bw_print' => 						array( 'required' => false ),
					'pa_color_pages' => 					array( 'required' => false ),
					'pa_color_format' =>					array( 'required' => false ),
					'pa_color_paper' => 					array( 'required' => false ),
					'pa_color_print' => 					array( 'required' => false ),
					'pa_color_stack' => 					array( 'required' => false ),
					


					'pa_cover_ribbon_width' =>				array( 'required' => false ),
					'pa_cover_endpaper_paper' =>			array( 'required' => false ),
					'pa_cover_endpaper_print' =>			array( 'required' => false ),
					'pa_orientation' =>						array( 'required' => false ),
					'pa_groupwrap' =>						array( 'required' => false ),
					'pa_color_pages_numbers' =>				array( 'required' => false ),					
					'pa_drilling_holes' =>					array( 'required' => false ),
					'pa_holes_dia' =>						array( 'required' => false ),
					'pa_holes_pos' =>						array( 'required' => false ),
					'pa_pieces_per_carton' =>				array( 'required' => false ),				
					'pa_title' =>							array( 'required' => false ),
					'pa_book_number' =>						array( 'required' => false ),
					'pa_comments' =>						array( 'required' => false ),








				)
			);			
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
				'pa_format' => 							array( 'default' => '148x210',			'type' 			=> 'select', 
																								'placeholder' 	=> __('Selcet format', 'gcalc') 
				),

				'pa_quantity' => 						array( 'default' => 50, 				'type' 			=> 'number', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_paper' => 							array( 'default' => 'uncouted-80g', 	'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_print' => 							array( 'default' => '1x1', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_finish' => 							array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_spot_uv' => 						array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_folding' => 						array( 'default' => 'no-fold', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_format' =>					array( 'default' => '148x210', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_paper' => 					array( 'default' => 'couted-300g', 		'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_print' => 					array( 'default' => '4x4', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_type' => 						array( 'default' => 'perfect_binding', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_dust_jacket_paper' => 		array( 'default' => 'couted-170g', 		'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_dust_jacket_print' => 		array( 'default' => '4x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_dust_jacket_finish' => 		array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_dust_jacket_spot_uv' => 		array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_cloth_covering_paper' => 		array( 'default' => 'couted-170g', 		'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_cloth_covering_finish' => 	array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_cloth_covering_print' => 		array( 'default' => '4x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_cloth_covering_spot_uv' => 	array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_ribbon' => 					array( 'default' => 'ribbon-0', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_finish' => 					array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_spot_uv' => 					array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_flaps' => 					array( 'default' => 'false', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_left_flap_width' => 			array( 'default' => 0, 					'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_right_flap_width' => 			array( 'default' => 0, 					'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_board_thickness' => 			array( 'default' => 'board-25',			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_bw_pages' => 						array( 'default' => 100, 				'type' 			=> 'number', 
																								'placeholder' 	=> __('Enter B&W pages number', 'gcalc'),
																								'min' 	=> 2,
																								'max' 	=> 1000,
																								'var' 	=> 'int', 
				),

				'pa_bw_format' => 						array( 'default' => '148x210', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_bw_paper' => 						array( 'default' => 'uncouted-80g',		'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_bw_print' => 						array( 'default' => '1x1', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_color_pages' => 					array( 'default' => 20, 				'type' 			=> 'number', 
																								'placeholder' 	=> __('Enter color pages number', 'gcalc'),
																								'min' 	=> 2,
																								'max' 	=> 1000,
																								'var' 	=> 'int',

				),

				'pa_color_format' => 					array( 'default' => '148x210', 			'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_color_paper' => 					array( 'default' => 'uncouted-80g',		'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_color_print' => 					array( 'default' => '4x4', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_color_stack' => 					array( 'default' => 'true', 			'type' 			=> 'checkbox', 
																								'placeholder' 	=> __('', 'gcalc') 
				),












				'pa_cover_ribbon_width' => 				array( 'default' => 'ribbon-0', 		'type' 			=> 'select', 
																								'placeholder' 	=> __('', 'gcalc') 
				),

				'pa_cover_endpaper_paper' => 			array( 'default' => 'uncouted-80g', 	'type' 			=> 'select', 
																								'placeholder' 	=> __('Select endpaper material', 'gcalc') 
				),

				'pa_cover_endpaper_print' => 			array( 'default' => '0x0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('Select endpaper print', 'gcalc') 
				),

				'pa_orientation' => 					array( 'default' => 'portrait', 		'type' 			=> 'select', 
																								'placeholder' 	=> __('Select book orientation', 'gcalc') 
				),

				'pa_groupwrap' => 					array( 'default' => '0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('Select book orientation', 'gcalc') 
				),

				'pa_color_pages_numbers' => 			array( 'default' => '0', 				'type' 			=> 'textarea', 
																								'placeholder' 	=> __('Enter color pages number comma or space separated', 'gcalc') 
				),

				'pa_drilling_holes' => 			array( 'default' => '0', 				'type' 			=> 'select', 
																								'placeholder' 	=> __('Select number of holes to drill', 'gcalc') 
				),

				'pa_holes_dia' => 			array( 'default' => '8', 					'type' 			=> 'select', 
																								'placeholder' 	=> __('Select holes diameter', 'gcalc') 
				),

				'pa_holes_pos' => 			array( 'default' => 'long-center', 					'type' 			=> 'select', 
																								'placeholder' 	=> __('Select holes position', 'gcalc') 
				),

				'pa_pieces_per_carton' => 			array( 'default' => '12', 					'type' 			=> 'select', 
																								'placeholder' 	=> __('How many pieces per carton', 'gcalc') 
				),




				'pa_title' => 			array( 'default' => '', 					'type' 			=> 'textarea', 
																								'placeholder' 	=> __('Enter book title', 'gcalc') 
				),

				'pa_book_number' => 			array( 'default' => 'no-number', 					'type' 			=> 'select', 
																								'placeholder' 	=> __('Select book number ', 'gcalc') 
				),

				'pa_comments' => 			array( 'default' => '', 					'type' 			=> 'textarea', 
																								'placeholder' 	=> __('You can leve any nessesary information about this work here ', 'gcalc') 
				)	










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

				array( 'format', 		array( '148x210','210x297','297x420','125x176','176x250','custom-value' ), '111' ),				
				array( 'quantity', 	array( 'custom-value' ), '111' ),
				array( 'cover_format', 	array( 'custom-value' ), '111' ),
				array( 'bw_format', 	array( 'custom-value' ), '111' ),
				array( 'color_format', 	array( 'custom-value' ), '111' ),
				array( 'volume', array( 'custom-value' ), '111' ),				
				array( 'paper', array( 
					'couted-70g', 'couted-80g', 'couted-90g', 'couted-115g', 'couted-135g','couted-170g', 'couted-250g', 'couted-300g', 'couted-350g',
					'uncouted-70g', 'uncouted-80g', 'uncouted-90g', 'uncouted-100g', 'uncouted-120g', 'uncouted-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),
				array( 'cover_paper', array( 
					'couted-300g', 'couted-350g', 'gc1-230g', 'gc1-250g', 'gc2-230g', 'gc2-250g' 
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

				array( 'cover_endpaper_paper', array( 
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

				array( 'finish', array( '0x0', 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_finish', array( '0x0', 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_cloth_covering_finish', array( '0x0', 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'cover_dust_jacket_finish', array( '0x0', 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),

				array( 'print', 		array( '1x0','1x1','4x0','4x4' ), '111' ),
				array( 'cover_print', array( '4x4', '4x0' ), '111' ),
				array( 'color_print', array( '4x4', '4x0' ), '111' ),
				array( 'bw_print', array( '1x1', '1x0' ), '111' ),
				array( 'cover_cloth_covering_print', array( '4x4', '4x0' ), '111' ),
				array( 'cover_dust_jacket_print', array( '4x4', '4x0' ), '111' ),
				array( 'cover_endpaper_print', array( '0x0', '1x0', '4x0' ), '111' ),
				

				array( 'cover_ribbon', array( 'ribbon-0', 'ribbon-red', 'ribbon-orange', 'ribbon-green', 'ribbon-yellow' ), '111' ),
				array( 'cover_ribbon_width', array( 'ribbon-0', 'ribbon-3', 'ribbon-6' ), '111' ),
				array( 'cover_flaps', array( 'true', 'false' ), '111' ),
				array( 'cover_left_flap_width', array( 'custom-value' ), '111' ),
				array( 'cover_right_flap_width', array( 'custom-value' ), '111' ),
				array( 'cover_board_thickness', array( 'custom-value' ), '111' ),

				array( 'bw_pages', array( 'custom-value' ), '111' ),
				array( 'cover_board_thickness', array( 'board-20', 'board-25'), '111' ),
				array( 'color_pages', array( 'custom-value' ), '111' ),

				array( 'color_stack', array( 'stack', 'shuffled' ), '111' ),
				array( 'orientation', array( 'portrait', 'album' ), '111' ),
				array( 'groupwrap', array( '0', '1','2', '3', '4', '5' ), '111' ),
				array( 'color_pages_numbers', array( 'custom-value' ), '111' ),
				
				array( 'drilling_holes', array( 'custom-value', '0','2','4', ), '111' ),
				array( 'holes_dia', array( '4', '5', '6', '8' ), '111' ),
				array( 'holes_pos', array( 'long-center', 'short-center' ), '111' ),
				array( 'pieces_per_carton', array( '8', '10', '12', '14', '16', '18', '20', '22', '24', '26', '28', '30', '36', '40', '44', '48' ), '111' ),


				array( 'title', array( 'custom-value' ), '111' ),	
				array( 'book_number', array( 'no-number', 'isbn', 'issn' ), '111' ),	
				array( 'comments', array( 'custom-value' ), '111' ),	
			);
			


			return $r;
		}


	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\book::get_attr_defaults();
		}
	}
	
	

}

