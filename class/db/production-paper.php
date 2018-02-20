<?php 
namespace gcalc\db\production;


/**
*
*
*
*/
class paper{

	/**
	* Production format
	*/
	public $papers;

	



	function __construct( ){	
		$this->aquire();
	}

	
	/**
	* Return click cost
	*/
	function get_paper( string $paper_slug = "" ){	
		$paper_slug = $paper_slug === "" ? "kreda-350g" : $paper_slug;
		return isset( $this->papers[ $paper_slug ] ) ? $this->papers[ $paper_slug ] : 'error-paper-name';
	}



	/**
	* This function needs to aquire formats data from db
fo dev version it just sets an array
	*/
	public function aquire( ){
		

		/*
		* papers
		*/
		$this->papers = array(
			'*' => array(
					'price_per_kg' => 3.6,
					'label' => 'Papier do druku cyfrowego 80g',
					'weight' => .08
				),
			'kreda-90g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 90g', 'weight' => .09 ),
			'kreda-115g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 115g', 'weight' => .115 ),
			'kreda-130g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 135g', 'weight' => .135 ),
			'kreda-135g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 135g', 'weight' => .135 ),
			'kreda-150g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 150g', 'weight' => .15 ),
			'kreda-170g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 170g', 'weight' => .17 ),
			'kreda-200g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 200g', 'weight' => .2 ),
			'kreda-250g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 250g', 'weight' => .25 ),
			'kreda-300g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 300g', 'weight' => .3 ),			
			'kreda-350g' => array( 'price_per_kg' => 3.6, 'label' => 'Kreda 350g', 'weight' => .35 ),
			
			'offset-70g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 70g', 'weight' => .07 ),
			'offset-80g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 80g', 'weight' => .08 ),
			'offset-90g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 90g', 'weight' => .09 ),
			'offset-100g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 100g', 'weight' => .1 ),
			'offset-120g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 120g', 'weight' => .12 ),
			'offset-150g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 150g', 'weight' => .15 ),
			'offset-250g' => array( 'price_per_kg' => 3.6, 'label' => 'Offset 250g', 'weight' => .25 )

			
			
			

			/*Ecobook vol 2.0 70g
			Kreda 170g
			Munken cream vol 1.5 80g
			Offset 100g
			Offset 70g
			Alto vol 1.5 80g
			Alto vol 1.5 90g
			Ecobook vol 2.0 80g
			Ecobook vol 2.0 90g
			Kreda 115g
			Kreda 135g
			Kreda 150g
			Kreda 170g
			Kreda 200g
			Kreda 250g
			Kreda 300g
			Kreda 350g
			Kreda 90g
			Munken cream vol 1.5 90g
			Munken white vol 1.5 80g
			Munken white vol 1.5 90g
			Offset 120g
			Offset 80g
			Offset 90g*/	
		);

		
	}

}