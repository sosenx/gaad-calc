<?php 
namespace gcalc;


/**
*
*
*
*/
class calculate extends calc_product {
	
	/**
	* Predefined order of processes for individual products handlindling
	*/
	private $calc_order;


	public function __construct( array $product_attributes, int $product_id = NULL ) {
		if ( !empty( $product_attributes ) ) {
			parent::__construct( $product_attributes, $product_id );
		
			$this->create_calculation_array_matrix();			
		}
	}

	public function get_price(){
		return rand( 10, 100 );
	}
}



 ?>