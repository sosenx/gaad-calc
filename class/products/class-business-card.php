<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class business_card extends product {
	
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
				'post_title' => __( 'Business card', 'gcalc' ),
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
				array( 'paper', array( 'couted-300g', 'couted-350g' ), '111' ),
				array( 'volume', array( '50-szt', '100-szt', '250-szt', '500-szt', '1000-szt', '2500-szt' ), '111' ),
				array( 'sizemm', array( '90x50', '85x55' ), '111' ),
				array( 'finish', array( 'gloss', 'matt', 'soft-touch' ), '111' ),
				array( 'print', array( '44', '40' ), '111' )
			);
		}
	}
	
	

}

