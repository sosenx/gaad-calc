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
			'kreda-350g' => array(
					'price_per_kg' => 3.6,
					'label' => 'Kreda 350g',
					'weight' => .35
				)	

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