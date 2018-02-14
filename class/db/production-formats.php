<?php 
namespace gcalc\db\production;


/**
*
*
*
*/
class formats{

	/**
	* Production format
	*/
	public $formats;

	/**
	* Splits sizes
	*/
	public $splits;


	/**
	* Clicks costs
	*/
	public $clicks;

	/**
	* Translation array for formats
	*/
	public $str_dim_to_format;

	/*
	* 
	*/
	public $wrap_cost;

	/*
	* 
	*/
	public $spot_uv_cost;

	/*
	* 
	*/
	public $pallet_format;

	/*
	* 
	*/
	public $pallet_format_factor;



	function __construct( ){	
		$this->aquire();
	}

	/**
	* 
	*/
	function get_formats( string $label = "" ){	
		$label = $label === "" ? "all" : $label;
		$color = $this->formats['color'];
		$bw = $this->formats['bw'];
		$lg = array();
		$all = array_merge( $color, $bw );

		return isset( $$label ) ? $$label : $all;
	}

	/**
	* Return split by given format
	*/
	function get_split( string $format = "", string $color_mode = "" ){	
		$format = $format === "" ? "a4" : $format;
		return isset( $this->splits[$color_mode][ $format ] ) ? $this->splits[$color_mode][ $format ] : $this->splits[$color_mode][ '*' ];
	}

	/**
	* Return margin by given production format
	*/
	function get_prod_for_margins( string $format = "", string $color_mode = "" ){	
		$format = $format === "" ? "487x330" : $format;
		return isset( $this->prod_for_margins[$color_mode][ $format ] ) ? $this->prod_for_margins[$color_mode][ $format ] : array( 'left'=>0, 'right'=>0, 'top'=>0, 'bottom'=>0 );
	}

	/**
	* Return click cost
	*/
	function get_click( string $format = "", string $print_color_mode ){	
		$format = $format === "" ? "a4" : $format;
		$print_color_mode = $print_color_mode === "" ? "4x" : $print_color_mode;

		return isset( $this->clicks[$print_color_mode][ $format ]['*'] ) ? $this->clicks[$print_color_mode][ $format ]['*'] : array( .18, .28 );
	}

	/**
	* Return click cost
	*/
	function get_str_dim_to_format( string $format = "" ){	
		$format = $format === "" ? "a3" : $format;
		$str_format = isset( $this->str_dim_to_format[ $format ] ) ? $this->str_dim_to_format[ $format ] : 'errorformat';
		return $str_format;
	}


	/**
	* Return wrap cost
	*/
	function get_wrap_cost( string $wrap = "" ){	
		$wrap = $wrap === "" ? "a3" : $wrap;
		return isset( $this->wrap_cost[ $wrap ] ) ? $this->wrap_cost[ $wrap ] : 'errorwrap';
	}

	/**
	* Return pallet_format
	*/
	function get_pallet_format( string $format_str, string $grain ){
		$pallet_format = 
			isset( $this->pallet_format[ strtolower( $grain ) ][ $format_str ] ) 
				? $this->pallet_format[ strtolower( $grain ) ][ $format_str ]
					: 'error_pallet_format';
		return $pallet_format;
	}

	/**
	* Return pallet_format_factor
	*/
	function get_pallet_format_factor( ){		
		return isset( $this->pallet_format_factor ) ? $this->pallet_format_factor : -1;
	}

	/**
	* Return wrap cost
	*/
	function get_total_cost_equasion( int $product_id ){	
		$product = new \WC_Product( $product_id );
		$slug = $product->get_slug();		
		return isset( $this->total_cost_equasion[ $slug ] ) ? $this->total_cost_equasion[ $slug ] : '-1';
	}


	/**
	* Return wrap cost
	*/
	function get_spot_uv_cost( ){	
		return $this->spot_uv_cost;
	}

	/**
	* This function needs to aquire formats data from db, fo dev version it just sets an array
	*/
	public function aquire( ){
		$this->formats = array(
			'color' => array (				
				'SRA3++'	=> 	array('width' => 330,'height' => 487),
				'SRA3'		=> 	array('width' => 320,'height' => 450),
				'RA3' 		=> 	array('width' => 315,'height' => 430),
				'RA3+' 		=> 	array('width' => 315,'height' => 440),
				'RA4' 		=> 	array('width' => 215,'height' => 305),
				'A3' 		=> 	array('width' => 297,'height' => 420),
				//'B3' 		=> 	array('width' => 350,'height' => 500),
				'B4' 		=> 	array('width' => 250,'height' => 350)
			),

			'bw' => array (
				'SRA3++'	=> 	array('width' => 330,'height' => 487),
				'SRA3'		=> 	array('width' => 320,'height' => 450),
				'RA3' 		=> 	array('width' => 315,'height' => 430),
				'RA3+' 		=> 	array('width' => 315,'height' => 440),
				'RA4' 		=> 	array('width' => 215,'height' => 305),
				'A3' 		=> 	array('width' => 297,'height' => 420),
				'B3' 		=> 	array('width' => 350,'height' => 500),
				'B4' 		=> 	array('width' => 250,'height' => 350)
			)	
		);


		$this->pallet_format_factor = 4;

		$this->pallet_format = array (
			'sg' => array (
				'SRA3++'	=> 	array('width' => 1000,'height' => 	700),
				'SRA3'		=> 	array('width' => 1000,'height' => 	700),
				'RA3' 		=> 	array('width' => 860,'height' => 	630),
				'RA3+' 		=> 	array('width' => 880,'height' => 	630),
				'RA4' 		=> 	array('width' => 880,'height' => 	630),
				'A3' 		=> 	array('width' => 880,'height' => 	630),
				'B3' 		=> 	array('width' => 1000,'height' => 	700),
				'B4' 		=> 	array('width' => 1000,'height' => 	700)
			),
			'lg' => array (
				'SRA3++'	=> 	array('width' => 700,'height' => 1000 ),
				'SRA3'		=> 	array('width' => 700,'height' => 1000 ),
				'RA3' 		=> 	array('width' => 630,'height' => 860 ),
				'RA3+' 		=> 	array('width' => 630,'height' => 880 ),
				'RA4' 		=> 	array('width' => 630,'height' => 880 ),
				'A3' 		=> 	array('width' => 630,'height' => 880 ),
				'B3' 		=> 	array('width' => 700,'height' => 1000 ),
				'B4' 		=> 	array('width' => 700,'height' => 1000 )
			)
		);	


		/*
		* Splits devided by formats
		*/
		$this->splits = array(
			'1x' => array(
				"*" => array( 2,2),
				"90x50" => array( 7, 4),
				"180x50" => array( 7, 4)				
			),

			'4x' => array(
				"*" => array( 7, 7),
				"90x50" => array( 7, 7),
				"180x50" => array( 7, 7 ), 				
				"105x148" => array( 7, 7 ),
				"148x210" => array( 7, 7 ),
				"210x297" => array( 7, 7 ),
				"297x420" => array( 7, 7 )
			),



			
		);

		/*
		* Margins devided by production formats
		*/
		$this->prod_for_margins = array(
			'1x' => array(
				'330x487' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'487x330' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'320x450' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),				
				'450x320' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'315x430' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'430x315' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'315x440' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'440x315' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'215x305' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'305x215' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'297x420' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'420x297' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'250x350' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'350x250' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'350x500' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3),
				'500x350' => array('left' => 3,'right' => 3, 'top' => 3,'bottom' => 3)
			),
			'4x' => array(
				'330x487' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'487x330' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'320x450' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),				
				'450x320' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'315x430' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'430x315' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'315x440' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'440x315' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'215x305' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'305x215' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'297x420' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'420x297' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'250x350' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'350x250' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5),
				'350x500' => array('left' => 5,'right' => 5, 'top' => 7,'bottom' => 7),
				'500x350' => array('left' => 7,'right' => 7, 'top' => 5,'bottom' => 5)
			)
		);


		/*
		* Clicks cost, normative
		*/
		$this->clicks = array(
			'1x' => array(
				'330x487' => array( '*' => array( .019, .028 )),
				'487x330' => array( '*' => array( .019, .028 )),
				'320x450' => array( '*' => array( .019, .028 )),
				'450x320' => array( '*' => array( .019, .028 )),
				'315x430' => array( '*' => array( .019, .028 )),
				'430x315' => array( '*' => array( .019, .028 )),
				'315x440' => array( '*' => array( .019, .028 )),
				'440x315' => array( '*' => array( .019, .028 )),
				'215x305' => array(	'*' => array( .010, .032 )),
				'305x215' => array(	'*' => array( .010, .032 )),
				'297x420' => array(	'*' => array( .019, .032 )),
				'420x297' => array(	'*' => array( .019, .032 )),				
				'250x350' => array(	'*' => array( .019, .032 )),
				'350x250' => array(	'*' => array( .019, .032 )),
				'350x500' => array(	'*' => array( .019, .032 )),
				'500x350' => array(	'*' => array( .019, .032 ))
			),
			'4x' => array(
				'330x487' => array(	'*' => array( .160, .260 )),
				'487x330' => array(	'*' => array( .160, .260 )),
				'320x450' => array(	'*' => array( .160, .260 )),
				'450x320' => array(	'*' => array( .160, .260 )),
				'315x430' => array(	'*' => array( .160, .260 )),
				'430x315' => array(	'*' => array( .160, .260 )),
				'315x440' => array(	'*' => array( .200, .350 )),
				'440x315' => array(	'*' => array( .200, .350 )),
				'215x305' => array(	'*' => array( .120, .180 )),
				'305x215' => array(	'*' => array( .120, .180 )),
				'297x420' => array(	'*' => array( .100, .150 )),
				'420x297' => array(	'*' => array( .100, .150 )),
				'250x350' => array(	'*' => array( .160, .260 )),
				'350x250' => array(	'*' => array( .160, .260 )),
				'350x500' => array(	'*' => array( .160, .260 )),
				'500x350' => array(	'*' => array( .160, .260 ))
			)
		);


		/*
		* From dimensions to string format name
		*/
		$this->str_dim_to_format = array(
			'330x487' => 'SRA3++',
			'487x330' => 'SRA3++',
			'320x450' => 'SRA3',
			'450x320' => 'SRA3',
			'315x430' => 'RA3',
			'430x315' => 'RA3',
			'315x440' => 'RA3+',
			'440x315' => 'RA3+',
			'215x305' => 'RA4',
			'305x215' => 'RA4',
			'420x297' => 'A3',	
			'297x420' => 'A3',
			'250x350' => 'B4',	
			'350x250' => 'B4',
			'350x500' => 'B3',	
			'500x350' => 'B3'			
		);

/*
		$this->pre_impose_format = array(



			'4x' => array(
				'90x50' => 'SRA3++',
				'85x55' => 'SRA3++',
			),
			'1x' => array(),



			'315x430' => 'RA3',
			'315x440' => 'RA3+',
			'215x305' => 'RA4',
			'420x297' => 'A3',	
			'487x330' => 'SRA3++',
			'430x305' => 'RA3',
			'440x315' => 'RA3+',
			'305x215' => 'RA4',
			'420x297' => 'A3'	
		);
*/

		$this->wrap_cost = array(
			'folia-brak' => 0,
			'folia-blysk-dwustronnie' => .2,
			'folia-blysk-jednostronnie' => .1,
			'folia-mat-dwustronnie' => .2,
			'folia-mat-jednostronnie' => .1,
			'folia-soft-touch-dwustronnie' => .8,
			'folia-soft-touch-jednostronnie' => .4,
		);

		$this->total_cost_equasion = array(
			'wizytowki' => array(
				'equasion' => 'podloze + zadruk + wrap + spot_uv'
			),
		);

		$this->spot_uv_cost = array(
			'cost' => 155,
			'stack' => 1000
		);


	}

}