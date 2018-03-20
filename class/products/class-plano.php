<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class plano extends product {
	
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
	 * Returns product calculation data
	 * @return [type] [description]
	 */
	public static function get_calc_data( string $key = NULL ){
		$calc_data = array(
			'equasion' => 'pa_bw_paper + pa_bw_print + pa_color_paper + pa_color_print', 
			'order' => array ( 
				"bw" => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*'),
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', '*' )
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
				'post_title' => __( 'Plano', 'gcalc' ),
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
				array( 'format', 			array( '105x148','148x210','210x297','297x420','125x176','176x250','custom-value' ), '111' ),								
				array( 'pa_bw_format', 		array( '105x148','148x210','210x297','297x420','125x176','176x250','custom-value' ), '111' ),
				array( 'pa_color_format', 	array( '105x148','148x210','210x297','297x420','125x176','176x250','custom-value' ), '111' ),

				array( 'volume', array( 'custom-volume' ), '111' ),
				
				array( 'paper', array( 
					'couted-70g', 'couted-80g', 'couted-90g', 'couted-115g', 'couted-135g','couted-170g', 'couted-250g', 'couted-300g', 'couted-350g',
					'uncouted-70g', 'uncouted-80g', 'uncouted-90g', 'uncouted-100g', 'uncouted-120g', 'uncouted-150g',
					'eccobook_cream_16-60g', 'eccobook_cream_16-70g','eccobook_cream_16-80g', 'eccobook_cream_20-60g','eccobook_cream_20-70g', 'eccobook_cream_20-80g', 	
					'ibook_white_16-60g','ibook_white_16-70g', 'ibook_cream_20-60g', 'ibook_cream_20-70g', 'ibook_cream_20-80g', 		
					'munken_cream_18-80g','munken_cream_18-90g','munken_cream_15-80g','munken_cream_15-90g','munken_white_18-80g','munken_white_18-90g','munken_white_15-80g','munken_white_15-90g',
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
				
				array( 'print', 		array( '1x0','1x1','4x0','4x4' ), '111' ),				
				array( 'bw_pages', array( 'custom-value' ), '111' ),				
				array( 'color_pages', array( 'custom-value' ), '111' ),
				array( 'color_stack', array( 'stack', 'shuffled' ), '111' ),
			);
		return $r;
	}

	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	public function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\plano::get_attr_defaults();
		}
	}
	
	

}

