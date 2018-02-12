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
	

	function __construct( array $product_attributes, int $product_id, $parent ) {
		$this->parent = $parent;	
		$this->product_id = $product_id;
		$this->product = new \WC_Product( $product_id );
		$this->slug = $this->product->get_name();

		$this->aquire();
	}



	/**
	* branch
	*/
	public function get_markup_value( $needle, array $haystack){
		arsort( $haystack );
		foreach ($haystack as $key => $value) {
			if ( $needle < $key) {
				return $value;
			}
		}
		return 1;
	}

	/**
	* Return branch from markup tree.
	*
	* Branches have irregular shape, needs to be treted individually with cprocess_calculation obj
	*/
	public function get_markup(){
		$product_markup = $this->get_markups()[ $this->slug ] == NULL ? $this->get_markups()[ '*' ] : $this->get_markups()[ $this->slug ];
		$process_markup = $product_markup[ $this->parent->name ]  == NULL ? 0 : $product_markup[ $this->parent->name ];
		
		return $process_markup;
	}

	/**
	* This function needs to aquire formats data from db
	fo dev version it just sets an array
	*/
	public function aquire( ){
		$this->markups = array(
			'*' => array(
				'pa_podloze' => array( 'markup' => 1.1),
				'pa_wrap' => array( 'markup' => 1),
				'pa_naklad' => array( 'markup' => 1),
				'pa_zadruk' => array( 
					'markup' => array(
						'1x' => array(
							5 => 7,
							10 => 6,
							25 => 5,
							50 => 4,
							200 => 3.5,
							500 => 3,
							1000 => 2.5,
							2000 => 2.3,
							3000 => 1.8
						),
						'4x' => array(
							5 => 7,
							10 => 6,
							25 => 5,
							50 => 4,
							200 => 3.5,
							500 => 3,
							1000 => 2.5,
							2000 => 2.3,
							3000 => 1.8
						)
					)
				)
			)
		);
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