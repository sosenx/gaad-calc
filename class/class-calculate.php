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

	/**
	* Returns named process from done array
	*/
	public function get_done_process( string $name ){
		if ( $name != "" ) {
			foreach ( $this->done as $key => $value ) {
				if ( $value->total['name'] == $name) {
					return $value;
				}
			}
		}
	}

	/**
	* Returns named process from done array
	*/
	public function get_todo_process( string $name ){
		if ( $name != "" ) {
			foreach ( $this->get_todo()->get_plist() as $key => $value ) {
				if ( $value->name == $name) {
					return $value;
				}
			}
		}
	}

	public function parse_total_cost_equasion( string $equasion ){
		$plist = $this->get_todo()->get_plist();
		$parsed_equasion = $equasion;
		$equasion_parts = array();

		if ( !empty( $plist ) ) {
			foreach ($plist as $key => $value) {
				$done_process = $this->get_done_process( $key );
				$process_common_name = str_replace( 'pa_', '', $key );
				$total_price = $key == 'pa_naklad' ? (int)$this->get_bvars()['pa_naklad'] : $done_process->total['total_price'];
				
				$parsed_equasion = str_replace( $process_common_name, $total_price, $parsed_equasion );						
				$equasion_parts[ $process_common_name ] = $total_price;
			}
		}
		
		$eval_str = '$calculated_total = ' . $parsed_equasion .";";
		eval( $eval_str );
		
		return array( 
			'total_price' => $calculated_total,
			"equasion" => $equasion,
			"parsed_equasion" => $eval_str,
			"equasion_parts" => $equasion_parts
			);
	}

}



 ?>