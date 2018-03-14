<?php
namespace gcalc\db\product;
/**
 *
 * 
 */

/**
* 
*/
class product {
	
	public $base;
	public $attr;
	private $title;
	private $exists;

	/**
	 * 
	 * @param array|null $base array of primary product parameters
	 * @param array|null $attr [description]
	 */
	function __construct( array $base = NULL, array $attr = NULL )	{
		$this->set_base( $base );
		$this->set_attr( $attr );
	}

	/**
	 * add product post using base as data source
	 * @return [type] [description]
	 */
	public function create_product( ){
		var_dump( $this->get_base());
		var_dump( $this->get_attr());
	}

	public function product_exists( ){
		
	}




		

	/**
	 * setter for base
	 * @param array $base array of primary product parameters
	 */
	function set_base( array $base = NULL ){
		$this->base = is_array( $base ) ? $base : 
			( method_exists( $this, 'set_base_defaults' ) ? $this->set_base_defaults( ) : array() )
		;
		
	}

	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	function set_attr( array $attr = NULL ){
		$this->attr = is_array( $attr ) ? $attr :
			( method_exists( $this, 'set_attr_defaults' ) ? $this->set_attr_defaults( ) : array() )
		;
	}
	

	/**
	 * Setter for product title
	 * @param string $title product title
	 */
	function set_title( string $title ){
		$this->title = $title;
	}
	
	/**
	 * Setter for exists	 
	 */
	function set_exists( ){
		$exists = false;
		if ( !empty( $this->base ) ) {
			
		}
		$this->exists = $exists;
	}
	



			
	/**
	 * Getter for base
	 * @return array base set of product data, title etc.
	 */
	function get_base( ){
		return $this->base;
	}


	/**
	 * Getter for attr
	 * @return array Set of product attributes and its values
	 */
	function get_attr( ){
		return $this->attr;
	}

}