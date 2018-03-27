<?php
namespace gcalc\db\product;

/**
* 
*/
class folded_business_card extends product {
	
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
			'equasion' => 'pa_master_paper + pa_master_print + pa_master_wrap + pa_master_folding + pa_master_spot_uv', 
			'order' => array ( 
				'master' =>array('pa_master_format', '*')
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
			'groups'=> array( 'master' ),		
			'matrix' => array(				
				'pa_quantity' => array(
					'default' => 5
				),
				'pa_format' => array(
					'default' => '180x50'
				),
				'pa_paper' => array(
					'default' => 'coated-300g'
				),
				'pa_print' => array(
					'default' => '4x4'
				),
				'pa_finish' => array(
					'default' => '0x0'
				),
				'pa_spot_uv' => array(
					'default' => '0x0'
				),
				'pa_folding' => array(
					'default' => 'half-fold'
				),
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
				'post_title' => __( 'Folded business card', 'gcalc' ),
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
				array( 'paper', array( 'coated-300g', 'coated-350g' ), '111' ),
				array( 'volume', array( '50', '100', '200', '300', '400', '500', '1000', '1500', '2500' ), '111' ),
				array( 'format', array( '170x55', '180x50', '85x170', '90x180', 'custom-value' ), '111' ),
				array( 'folding', array( 'half-fold' ), '111' ),
				array( 'folding_dir', array( 'folding-dir-h', 'folding-dir-v' ), '111' ),
				array( 'finish', array( 'gloss-1x0', 'gloss-1x1', 'matt-1x0','matt-1x1', 'soft-touch-1x0', 'soft-touch-1x1' ), '111' ),
				array( 'print', array( '4x4', '4x0' ), '111' ),
				array( 'spot_uv', array( '0x0', '1x0', '1x1' ), '111' )
			);
		return $r;
	}

	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	public function set_attr_defaults(  ){
		
		if ( empty( $this->attr ) || is_null( $this->attr ) ) {
			$this->attr = \gcalc\db\product\folded_business_card::get_attr_defaults();
		}
	}
	
	

}




