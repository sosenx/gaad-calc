<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class letterhead extends product {
	
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
			'equasion' => 'pa_color_paper + pa_color_print + pa_bw_paper + pa_bw_print', 
			'order' => array ( 
				"bw" => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*' ),
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print' )
			)
		);
		return is_null( $key ) ? $calc_data : ( array_key_exists( $key, $calc_data ) ? $calc_data[ $key ] : $calc_data );
	}

	/**
	 * Additional validation of attribute specific to product type.
	 * 
	 * @param  array            $cargs  Calculation argumetns (product attributes) array
	 * @param  \gcalc\calculate $parent Parent object to add errors and info
	 * @return [type]                   [description]
	 */
	public static function validate__pa_color_format( array $cargs, \gcalc\calculate $parent, $process ){
		$valid = true;
		$value = $parent->get_bvar( str_replace('validate__', '', explode( '::' , __METHOD__)[1] ) );

		if ( $value !== '210x297' ) {
			$parent->set_bvar('pa_format', 'color', '210x297', array( new \gcalc\error( 10000, ' Letterheads are in 210x297 (A4) format only.' ) ) );		
		}
		
		return $parent->get_bvars();
	}


	/**
	 * Additional validation of attribute specific to product type.
	 * 
	 * @param  array            $cargs  Calculation argumetns (product attributes) array
	 * @param  \gcalc\calculate $parent Parent object to add errors and info
	 * @return [type]                   [description]
	 */
	public static function validate__pa_bw_pages( array $cargs, \gcalc\calculate $parent, $process ){
		$valid = true;
		$value = $parent->get_bvar( str_replace('validate__', '', explode( '::' , __METHOD__)[1] ) );

		if ( (int)$value !== 500 ) {
			$parent->set_bvar('pa_pages', 'bw', 500, array( new \gcalc\error( 10000, ' Ream = 500 sheets' ) ) );		
		}
		
		return $parent->get_bvars();
	}

	/**
	 * Additional validation of attribute specific to product type.
	 * 
	 * @param  array            $cargs  Calculation argumetns (product attributes) array
	 * @param  \gcalc\calculate $parent Parent object to add errors and info
	 * @return [type]                   [description]
	 */
	public static function validate__pa_color_pages( array $cargs, \gcalc\calculate $parent, $process ){
		$valid = true;
		$value = $parent->get_bvar( str_replace('validate__', '', explode( '::' , __METHOD__)[1] ) );

		if ( (int)$value !== 500 ) {
			$parent->set_bvar('pa_pages', 'color', 500, array( new \gcalc\error( 10000, ' Ream = 500 sheets' ) ) );		
		}
		
		return $parent->get_bvars();
	}



	/**
	 * setter for base
	 * @param array $base Array of primary product parameters
	 */
	function set_base_defaults( ){
		
		if ( empty( $this->base ) || is_null( $this->base ) ) {
			$this->base = array(
				'post_title' => __( 'Letterhead', 'gcalc' ),
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
				array( 'pa_bw_format', 	array( '210x297', 'custom-value' ), '111' ),
				array( 'pa_color_format', 	array( '210x297', 'custom-value' ), '111' ),

				array( 'volume', array( '1','2','3','4','5','6','7','8','9','10','custom-value' ), '111' ),
				
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
				array( 'color_pages', array( '500' ), '111' ),				
				array( 'bw_pages', array( '500' ), '111' )				
			);
		return $r;
	}

	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	public function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\letterhead::get_attr_defaults();
		}
	}
	
	

}

