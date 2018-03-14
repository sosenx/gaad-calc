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
		$this->set_exists( );
		$this->create_product( );
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

/**
	* Adds calling cards to product base
	
	public static function product_calling_card(){
		$product_title = \__( 'Calling card','gcalc' );
		$post_content = '';
		$user_id = 1;
		$product_exists = \gcalc\register_woo_elements::product_exists( $product_title );


		if ( !$product_exists || \gcalc\GAAD_PLUGIN_TEMPLATE_FORCE_CREATE_WOO_ELEMENTS ) {	

			$post_id = wp_insert_post( array(
		        'post_author' => $user_id,
		        'post_title' => $product_title,
		        'post_content' => $post_content,
		        'post_status' => 'publish',
		        'post_type' => "product",
		    ) );
		    wp_set_object_terms( $post_id, 'variable', 'product_type' );
			
	  		\gcalc\register_woo_elements::add_product_attribute( $post_id, 'paper',		array( 'couted-300g', 'couted-350g' ), '111' );

	  		\gcalc\register_woo_elements::add_product_attribute( $post_id, 'volume',	array( '50-szt', '100-szt', '250-szt', '500-szt', '1000-szt', '2500-szt' ), '111' );

			\gcalc\register_woo_elements::add_product_attribute( $post_id, 'sizemm',	array( '90x50', '85x55' ), '111' );

			\gcalc\register_woo_elements::add_product_attribute( $post_id, 'finish',	array( 'gloss', 'matt', 'soft-touch' ), '111' );

			\gcalc\register_woo_elements::add_product_attribute( $post_id, 'print',		array( '44', '40' ), '111' );
		}

	}*/