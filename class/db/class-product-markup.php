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
		$this->slug = $this->product->get_slug();

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
		$product_markup = !array_key_exists( $this->slug, $this->get_markups() ) ? $this->get_markups()[ '*' ] : $this->get_markups()[ $this->slug ];
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
				'pa_paper' => array( 'markup' => 1.1),
				'pa_sewing' => array( 'markup' => 2),
				'pa_wrap' => array( 'markup' => 1),
				'pa_spot_uv' => array( 'markup' => 1.6),
				'pa_quantity' => array( 'markup' => 1),
				'pa_cover_type' => array( 
					'hard' => array(							
						array( 'price' => 1, 	'v' => 0 ),
					),

					'perfect_binding' => array(							
						array( 'price' => 1, 	'v' => 0 ),
					),

					'saddle_stitch' => array(							
						array( 'price' => 1, 	'v' => 0 ),
					),

					'section_sewn' => array(							
						array( 'price' => 1, 	'v' => 0 ),
					),

					'spiral_binding' => array(							
						array( 'price' => 1, 	'v' => 0 ),
					),

					'hard-affiliate' => array(							
						array( 'price' => 3.5, 	'v' => 0 ),
						array( 'price' => 3.3, 	'v' => 99 ),
						array( 'price' => 3.2, 	'v' => 201 ),
						array( 'price' => 3.12, 'v' => 301 ),
						array( 'price' => 3.04, 'v' => 401 ),
						array( 'price' => 2.96, 'v' => 501 ),
						array( 'price' => 2.92, 'v' => 601 ),
						array( 'price' => 2.88, 'v' => 701 ),
						array( 'price' => 2.84, 'v' => 801 ),
						array( 'price' => 2.8, 	'v' => 901 )														
					)
				),
				'pa_print' => array( 
					'markup' => array(
						'0x' => array(
							0 => 0
						),
						'1x' => array(
							array( 'price' => 5.5,	'v' => 0 	),
							array( 'price' => 4.5,	'v' => 25 	),

							
							array( 'price' => 4,	'v' => 50 	),
							array( 'price' => 3,	'v' => 100  ),
							array( 'price' => 2.5, 'v' => 200  ),
							array( 'price' => 2.1, 'v' => 350  ),
							array( 'price' => 1.9, 'v' => 500  ),
							array( 'price' => 1.8, 'v' => 750  ),
							array( 'price' => 1.6, 'v' => 1000 ),
							array( 'price' => 1.5, 'v' => 1500 )
						),

						'4x' => array(
							array( 'price' => 5.5,	'v' => 0 	),
							array( 'price' => 4.5,	'v' => 25 	),

							
							array( 'price' => 4,	'v' => 50 	),
							array( 'price' => 3.5,	'v' => 100  ),
							array( 'price' => 2.7, 'v' => 200  ),
							array( 'price' => 2.2, 'v' => 350  ),
							array( 'price' => 2, 'v' => 500  ),
							array( 'price' => 1.9, 'v' => 750  ),
							array( 'price' => 1.8, 'v' => 1000 ),
							array( 'price' => 1.7, 'v' => 1500 )
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