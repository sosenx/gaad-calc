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
	function get_paper( string $paper_slug ){	
		$paper_slug = $paper_slug === "" ? "couted-350g" : $paper_slug;
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

			'gc1-230g' 		=> array( 
				'price_per_kg' 	=> 4.6, 'label' => 'couted 90g', 	'weight' => .23, 	'thickness' => .336 ),
			'gc1-250g' 		=> array( 
				'price_per_kg' 	=> 4.6, 'label' => 'couted 90g', 	'weight' => .25, 	'thickness' => .378 ),
			'gc2-230g' 		=> array( 
				'price_per_kg' 	=> 4.6, 'label' => 'couted 90g', 	'weight' => .23, 	'thickness' => .336 ),
			'gc2-250g' 		=> array( 
				'price_per_kg' 	=> 4.6, 'label' => 'couted 90g', 	'weight' => .25, 	'thickness' => .378 ),





			'couted-90g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 90g', 	'weight' => .09, 	'thickness' => .074 ),
			'couted-115g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 115g', 	'weight' => .115, 	'thickness' => .09 ),
			'couted-130g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 135g', 	'weight' => .135, 	'thickness' => .1 ),
			'couted-135g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 135g', 	'weight' => .135, 	'thickness' => .1 ),
			'couted-150g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 150g', 	'weight' => .15, 	'thickness' => .105 ),
			'couted-170g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 170g', 	'weight' => .17, 	'thickness' => .13 ),
			'couted-200g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 200g', 	'weight' => .2, 	'thickness' => .15 ),
			'couted-250g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 250g', 	'weight' => .25, 	'thickness' => .19 ),
			'couted-300g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 300g', 	'weight' => .3, 	'thickness' => .235 ),			
			'couted-350g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'couted 350g', 	'weight' => .35, 	'thickness' => .274 ),
			
			'uncouted-70g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 70g', 	'weight' => .07, 	'thickness' => .09 ),
			'uncouted-80g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 80g', 	'weight' => .08, 	'thickness' => .1 ),
			'uncouted-90g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 90g', 	'weight' => .09, 	'thickness' => .11 ),
			'uncouted-100g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 100g', 	'weight' => .1, 	'thickness' => .12 ),
			'uncouted-120g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 120g', 	'weight' => .12, 	'thickness' => .14 ),
			'uncouted-150g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 150g', 	'weight' => .15, 	'thickness' => .17 ),
			'uncouted-170g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 170g', 	'weight' => .15, 	'thickness' => .195 ),
			'uncouted-200g' 		=> array( 
				'price_per_kg' 	=> 3.6, 'label' => 'Offset 200g', 	'weight' => .15, 	'thickness' => .23 ),
			'uncouted-250g' 		=> array( 
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