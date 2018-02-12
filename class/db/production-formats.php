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
	function get_split( string $format = "" ){	
		$format = $format === "" ? "a4" : $format;
		return isset( $this->splits[ $format ] ) ? $this->splits[ $format ] : array( 5, 5 );
	}

	/**
	* Return margin by given production format
	*/
	function get_prod_for_margins( string $format = "" ){	
		$format = $format === "" ? "487x330" : $format;
		return isset( $this->prod_for_margins[ $format ] ) ? $this->prod_for_margins[ $format ] : array( 'left'=>5, 'right'=>5, 'top'=>5, 'bottom'=>5 );
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
		return isset( $this->str_dim_to_format[ $format ] ) ? $this->str_dim_to_format[ $format ] : 'errorformat';
	}


	/**
	* Return wrap cost
	*/
	function get_wrap_cost( string $wrap = "" ){	
		$wrap = $wrap === "" ? "a3" : $wrap;
		return isset( $this->wrap_cost[ $wrap ] ) ? $this->wrap_cost[ $wrap ] : 'errorwrap';
	}



	/**
	* This function needs to aquire formats data from db, fo dev version it just sets an array
	*/
	public function aquire( ){
		$this->formats = array(
			'color' => array ( 
				'SRA3++' => array(
					'width' => 330, 
					'height' => 487 
				),
				'RA3' => array(
					'width' => 305, 
					'height' => 430 
				),
				'RA4' => array(
					'width' => 215, 
					'height' => 305 
				),
				'A3' => array(
					'width' => 297, 
					'height' => 420 
				)
			),

			'bw' => array ( 
				'SRA3++' => array(
					'width' => 330, 
					'height' => 487 
				),
				'RA3' => array(
					'width' => 305, 
					'height' => 430 
				),
				'RA3+' => array(
					'width' => 315, 
					'height' => 440 
				),
				'RA4' => array(
					'width' => 215, 
					'height' => 305 
				),
				'A3' => array(
					'width' => 297, 
					'height' => 420 
				)
			)	
		);

		/*
		* Splits devided by formats
		*/
		$this->splits = array(
			"90x50" => array( 7, 4) 
		);

		/*
		* Margins devided by production formats
		*/
		$this->prod_for_margins = array(
			'330x487' => array(
				'left' => 7, 
				'right' => 7,
				'top' => 5, 
				'bottom' => 5 
			),
			'305x430' => array(
				'left' => 7, 
				'right' => 7,
				'top' => 5, 
				'bottom' => 5 
			),
			'315x440' => array(
				'left' => 7, 
				'right' => 7,
				'top' => 5, 
				'bottom' => 5 
			),
			'215x305' => array(
				'left' => 7, 
				'right' => 7,
				'top' => 5, 
				'bottom' => 5 
			),
			'297x420' => array(
				'left' => 7, 
				'right' => 7,
				'top' => 5, 
				'bottom' => 5 
			)

		);

		/*
		* Clicks cost, normative
		*/
		$this->clicks = array(

			'1x' => array(
				'330x487' => array(
					'*' => array( .018, .028 ), 
				),
				'305x430' => array(
					'*' => array( .018, .028 ), 
				),
				'315x440' => array(
					'*' => array( .018, .028 ), 
				),
				'215x305' => array(
					'*' => array( .018, .028 ), 
				),
				'297x420' => array(
					'*' => array( .018, .028 ), 
				)
			),
			'4x' => array(
				'330x487' => array(
					'*' => array( .18, .28 ), 
				),
				'305x430' => array(
					'*' => array( .18, .28 ), 
				),
				'315x440' => array(
					'*' => array( .18, .28 ), 
				),
				'215x305' => array(
					'*' => array( .18, .28 ), 
				),
				'297x420' => array(
					'*' => array( .18, .28 ), 
				)
			)

				
		);

		$this->str_dim_to_format = array(
			'330x487' => 'SRA3++',
			'305x430' => 'RA3',
			'315x440' => 'RA3+',
			'215x305' => 'RA4',
			'420x297' => 'A3',	
			'487x330' => 'SRA3++',
			'430X305' => 'RA3',
			'440x315' => 'RA3+',
			'305x215' => 'RA4',
			'420x297' => 'A3'	
		);


		$this->wrap_cost = array(
			'folia-blysk-dwustronnie' => .2,
			'folia-blysk-jednostronnie' => .1,
			'folia-mat-dwustronnie' => .2,
			'folia-mat-jednostronnie' => .1,
			'folia-soft-touch-dwustronnie' => .8,
			'folia-soft-touch-jednostronnie' => .4,
		);


	}

}