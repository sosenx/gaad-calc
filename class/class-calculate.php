<?php 
namespace gcalc;


/**
*
*
*
*/
class calculate extends calc_product{
	
	public function __construct( array $product_attributes, int $product_id = NULL ) {
		if ( !empty( $product_attributes ) ) {
			parent::__construct( $product_attributes, $product_id );
			
			$this->create_calculation_array_matrix();
			$this->calc();
		}
	}
	

	public function calc(){
		$this->set_calculation_array_part('calc', 
			array( 
				"price" => $this->get_price()
			)
		);
	}

	public function get_price(){
		return rand( 10, 100 );
	}
}



 ?>