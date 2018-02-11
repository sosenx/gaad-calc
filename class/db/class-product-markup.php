<?php 
namespace gcalc\db;


/**
* Products, semi products,
*
*
*/
class product_markup{

	/**
	* parent string name
	*/
	private $parent;

	/**
	* parent string name
	*/
	private $product;
	
	/**
	* markup object
	*/
	private $markups;
	

	function __construct( array $product_attributes, int $product_id, string $parent ) {
		$this->parent = $parent;	
		$this->product_id = $product_id;
		$this->product = new \WC_Product( $product_id );
		$this->slug = $this->product->get_name();

		$this->aquire();
	}

	/**
	*
	*/
	public function get_markup(){
		$product_markup = $this->get_markups()[ $this->slug ] == NULL ? $this->get_markups()[ '*' ] : $this->get_markups()[ $this->slug ];
		$process_markup = $product_markup[ $this->parent ]  == NULL ? 0 : $product_markup[ $this->parent ];
		return $process_markup;
	}

	/**
	* This function needs to aquire formats data from db
	fo dev version it just sets an array
	*/
	public function aquire( ){
		$this->markups = array(
			'*' => array(
				'pa_podloze' => array( 'markup' => .1),
				'pa_zadruk' => array( 
					'markup' => array(
						'1x' => array(
							100 => 6,
							200 => 5,
							500 => 4,
							1000 => 3,
							2000 => 2,
							3000 => 1.8
						),
						'4x' => array(
							100 => 6,
							200 => 5,
							500 => 4,
							1000 => 3,
							2000 => 2,
							3000 => 1.8
						)

					)
				),
			)

		);
$r=1;

	}



	/**
	* Getter for markups
	*
	*/
	function get_markups( ){			
		return $this->markups;		
	}

}



 ?>