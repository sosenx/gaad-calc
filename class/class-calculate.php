<?php 
namespace gcalc;


/**
*
*
*
*/
class calculate extends calc_product{

	function __construct( array $product_attributes, int $product_id = NULL ) {
		parent::__construct( $product_attributes, $product_id );
		$r=1;
	}


	public function calc(){}

	public function get_price(){
		return rand( 10, 100 );
	}
}



 ?>