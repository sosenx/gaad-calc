<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class writing_pad extends product {
	
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
	 * Method overrides cprocess pa_cover_format.
	 *
	 * Method should be clone of original function with nessesary modifcations or there can be calculations issues
	 * 
	 * @param  [type] $cprocess [description]
	 * @return [type]           [description]
	 */
	public static function parse_dimensions__pa_cover_format( $cprocess )	{
		$group = $cprocess->get_group();
		$array_key = str_replace('master_', '', 'pa_' . $group[0] . '_format');
		
		if ( array_key_exists( $array_key, $cprocess->get_cargs() ) ) {
			$dim = explode( "x", $cprocess->get_cargs()[ $array_key ] ); 
		} else  {
			$dim = explode( "x", $cprocess->get_cargs()[ 'pa_format' ] );
		}		

		$width = (int)$dim[0];
		$max_width = 680;
		
		$cprocess->set_width($width);
		$cprocess->set_height( (int)$dim[1] );
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
		$array_key = str_replace('master_', '', 'pa_cover_format');

		if ( array_key_exists( $array_key, $cprocess->get_cargs() ) ) {
			$dim = explode( "x", $cprocess->get_cargs()[ $array_key ] ); 
		} else  {
			$dim = explode( "x", $cprocess->get_cargs()[ 'pa_format' ] );
		}		
		$cprocess->set_width((int)$dim[0]);
		$cprocess->set_height((int)$dim[1]);
	}




/* oveeride cprocess
public static function calc__pa_cover_format( $cprocess ){
		$pf = $cprocess->parent->get_best_production_format( $cprocess->group );
		$sheets_quantity = (int)($cprocess->cargs['pa_quantity'] / $pf['pieces']) + ( $cprocess->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		$markup_ = 1;		
		$production_cost = $sheets_quantity * 0;
		$total_price = $production_cost * $markup_;
		$grain = $pf['grain'];

		return $cprocess->parse_total( 			
			array(				
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(				
				'product' => array(
					'width' => $cprocess->get_width(),
					'height' => $cprocess->get_height(),
				),
				'sheets_quantity' => $sheets_quantity,
				'spine' => $cprocess->get_spine(),
				'production_format_short' => $pf['format'].' '.$grain.' ('. $pf['common_format']['width'] .'x'. $pf['common_format']['height'] . ')',
				'production_format' => $pf
			)
		);
}
*/
	/**
	 * Returns product calculation data
	 * @return [type] [description]
	 */
	public static function get_calc_data( string $key = NULL ){
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
				'pa_cover_finish' => array( 'default' => ''),
				'pa_cover_spot_uv' => array( 'default' => ''),
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
				'post_title' => __( 'Writing pad', 'gcalc' ),
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
				array( 'format', 			array(  '105x148','148x210','210x297','125x176','176x250','custom-value' ), '111' ),												
				array( 'pa_bw_format', 	array(  '105x148','148x210','210x297','125x176','176x250','custom-value' ), '111' ),
				array( 'pa_color_format', 	array(  '105x148','148x210','210x297','125x176','176x250','custom-value' ), '111' ),

				array( 'volume', array( '10','20','30','50','100','200','300','400','500','custom-value' ), '111' ),
				
				array( 'paper', array( 					
					'uncoated-70g', 'uncoated-80g', 'uncoated-90g', 'uncoated-100g', 'uncoated-120g', 'uncoated-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),				
				
				array( 'bw_paper', array( 					
					'uncoated-70g', 'uncoated-80g', 'uncoated-90g', 'uncoated-100g', 'uncoated-120g', 'uncoated-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),				
				
				array( 'color_paper', array( 					
					'uncoated-70g', 'uncoated-80g', 'uncoated-90g', 'uncoated-100g', 'uncoated-120g', 'uncoated-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
				), '111' ),
				
				array( 'print', 		array( '1x0','4x0'), '111' ),				
				array( 'color_pages', array( '25', '50', '100' ), '111' ),				
				array( 'bw_pages', array( '25', '50', '100' ), '111' ),



				array( 'cover_paper', array( 
					'coated-170g', 'coated-250g', 'coated-300g'
				), '111' ),
				array( 'cover_type', array( 'Perfect binding', 'Spiral binding' ), '111' ),
				array( 'cover_spot_uv', array( '0x0', '1x0' ), '111' ),
				array( 'cover_finish', array( 'gloss-1x0', 'matt-1x0','soft-touch-1x0' ), '111' ),
				array( 'cover_print', array( '4x4', '4x0' ), '111' ),				
			);
		
		return $r;
	}

	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	public function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\writing_pad::get_attr_defaults();
		}
	}
	
	

}

