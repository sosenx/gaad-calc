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
	function get_click( string $format = "" ){	
		$format = $format === "" ? "a4" : $format;
		return isset( $this->clicks[ $format ]['*'] ) ? $this->clicks[ $format ]['*'] : array( .18, .28 );
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
		);


	}

}