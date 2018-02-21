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
			'kreda-90g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 90g', 	'weight' => .09, 	'thickness' => .074 ),
			'kreda-115g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 115g', 	'weight' => .115, 	'thickness' => .09 ),
			'kreda-130g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 135g', 	'weight' => .135, 	'thickness' => .1 ),
			'kreda-135g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 135g', 	'weight' => .135, 	'thickness' => .1 ),
			'kreda-150g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 150g', 	'weight' => .15, 	'thickness' => .105 ),
			'kreda-170g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 170g', 	'weight' => .17, 	'thickness' => .13 ),
			'kreda-200g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 200g', 	'weight' => .2, 	'thickness' => .15 ),
			'kreda-250g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 250g', 	'weight' => .25, 	'thickness' => .19 ),
			'kreda-300g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 300g', 	'weight' => .3, 	'thickness' => .235 ),			
			'kreda-350g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Kreda 350g', 	'weight' => .35, 	'thickness' => .274 ),
			
			'offset-70g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 70g', 	'weight' => .07, 	'thickness' => .09 ),
			'offset-80g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 80g', 	'weight' => .08, 	'thickness' => .1 ),
			'offset-90g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 90g', 	'weight' => .09, 	'thickness' => .11 ),
			'offset-100g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 100g', 	'weight' => .1, 	'thickness' => .12 ),
			'offset-120g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 120g', 	'weight' => .12, 	'thickness' => .14 ),
			'offset-150g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 150g', 	'weight' => .15, 	'thickness' => .17 ),
			'offset-250g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 250g', 	'weight' => .25, 	'thickness' => .27 ),
			
			'ekobookc-60g-2.0' 	=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Ekobook kremowy 60g pulchny 2.0', 	'weight' => .06, 	'thickness' => .117 ),
			'ekobookw-60g-2.0' 	=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Ekobook bialy 60g pulchny 2.0', 	'weight' => .06, 	'thickness' => .117 ),
			'ekobookc-70g-2.0' 	=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Ekobook kremowy 70g pulchny 2.0', 	'weight' => .07, 	'thickness' => .127 ),
			'ekobookw-70g-2.0' 	=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Ekobook bialy 70g pulchny 2.0', 	'weight' => .07, 	'thickness' => .127 ),
			'ekobookc-80g-2.0' 	=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Ekobook kremowy 80g pulchny 2.0', 	'weight' => .08, 	'thickness' => .137 ),
			'ekobookw-80g-2.0' 	=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Ekobook bialy 80g pulchny 2.0', 	'weight' => .08, 	'thickness' => .137 ),


			'munkenw-80g-1.5' 	=> array( 
				'price_per_kg' 	=> 5.6, 'label' => 'Munken bialy 80g pulchny 1.5', 	'weight' => .08, 	'thickness' => .116 ),
			'munkenc-80g-1.5' 	=> array( 
				'price_per_kg' 	=> 5.6, 'label' => 'Munken kremowy 80g pulchny 1.5', 	'weight' => .08, 	'thickness' => .116 ),

			'munkenw-90g-1.5' 	=> array( 
				'price_per_kg' 	=> 5.6, 'label' => 'Munken bialy 80g pulchny 1.5', 	'weight' => .08, 	'thickness' => .132 ),
			'munkenc-90g-1.5' 	=> array( 
				'price_per_kg' 	=> 5.6, 'label' => 'Munken kremowy 80g pulchny 1.5', 	'weight' => .08, 	'thickness' => .132 ),

		);

		
	}

}