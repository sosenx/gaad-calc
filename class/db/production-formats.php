<?php 
namespace gcalc\db\production;


/**
*
*
*
*/
class formats{

	public $masteradmin;

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

	/**
	* Groups neede for product calculations
	*/
	public $product_groups;

	function __construct( ){	
		$this->aquire();
	}

	/**
	* 
	*/
	function get_formats( $label = NULL){	
		$label = $label === "" || is_null( $label ) ? "all" : $label;
		$color = $this->formats['color'];
		$bw = $this->formats['bw'];		
		$all = array_merge( $color, $bw );

		return isset( $$label ) ? $$label : $all;
	}

	/**
	* Return split by given format
	*/
	function get_split( $format, $color_mode){	
		$format = $format === "" ? "a4" : $format;
		return isset( $this->splits[$color_mode][ $format ] ) ? $this->splits[$color_mode][ $format ] : $this->splits[$color_mode][ '*' ];
	}

	/**
	* Return margin by given production format
	*/
	function get_prod_for_margins( $format, $color_mode ){	
		$format = $format === "" ? "487x330" : $format;
		return isset( $this->prod_for_margins[$color_mode][ $format ] ) ? $this->prod_for_margins[$color_mode][ $format ] : array( 'left'=>0, 'right'=>0, 'top'=>0, 'bottom'=>0 );
	}

	/**
	* Return click cost
	*/
	function get_click( $format, $print_color_mode ){	
		if ( $print_color_mode == '0x0' ) { // no print
			return 0;
		}
		$format = $format === "" ? "a4" : $format;
		$print_color_mode = substr( $print_color_mode === "" ? "4x" : $print_color_mode, 0, 2);
		$click_cost = isset( $this->clicks[$print_color_mode][ $format ]['*'] ) ? $this->clicks[$print_color_mode][ $format ]['*'] : array( .18, .28 );
		return $click_cost;
	}

	/**
	* Return click cost
	*/
	function get_str_dim_to_format( $format ){	
		$format = $format === "" ? "a3" : $format;
		$str_format = isset( $this->str_dim_to_format[ $format ] ) ? $this->str_dim_to_format[ $format ] : 'errorformat';
		return $str_format;
	}


	/**
	* Return wrap cost
	*/
	function get_wrap_cost( $wrap ){			
		return isset( $this->wrap_cost[ $wrap ] ) ? $this->wrap_cost[ $wrap ] : 'errorwrap';
	}


	/**
	* Return wrap cost
	*/
	function get_masteradmin( $field_name ){			
		return array_key_exists( $field_name, $this->masteradmin ) ? $this->masteradmin[ $field_name ] : false;
	}


	/**
	* Return common_format
	*/
	function get_common_format( ){			
		return $this->common_format;
	}


	/**
	* Return common_format
	*/
	function get_product_groups( $product_slug ){	
		if ( array_key_exists( $product_slug, $this->product_groups) ) {
			return $this->product_groups[ $product_slug ];
		}		
		return array();		
	}



	/**
	* Return pallet_format
	*/
	function get_pallet_format( $format_str, $grain ){
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
	function get_total_cost_equasion( $product_id ){	
		$product = new \WC_Product( $product_id );
		$slug = $product->get_slug();	
		if ( array_key_exists( $slug, $this->total_cost_equasion ) ) {
			$equasion = $this->total_cost_equasion[ $slug ];			
		} else {
			$equasion = $this->total_cost_equasion[ 'plain' ];
		}
		
		return $equasion;
	}


	/**
	* Return production_format
	*/
	function get_production_format( $common_format, $print_color_mode, $name ){		
	
		$print_color_mode_translate = array( '4x' => 'color', '1x' => 'bw', '0x' => 'noprint');
		$production_format = $this->production_formats[ $print_color_mode ][ $common_format['name'] ];		
		$format_data = $this->get_formats( $print_color_mode_translate[$print_color_mode]) [ $production_format['format'] ];





		$production_format = array_merge( $production_format, $format_data);
		//$production_format['grain'] = $common_format['grain'];
		$production_format['common_format'] = $common_format;		
		
		return isset( $production_format ) ? $production_format : '-1';
	}


	/**
	* Return wrap cost
	*/
	function get_spot_uv_cost( ){	
		return $this->spot_uv_cost;
	}

	/**
	* Return binding_type
	*/
	function get_binding_type( $binding_type ){	
		return $this->binding_types[ $binding_type ];
	}



	/**
	* Return limit from limits
	*/
	function get_limit( $limit_type ){	
		return $this->limits[ $limit_type ];
	}

	/**
	* This function needs to aquire formats data from db, fo dev version it just sets an array
	*/
	public function aquire( ){

		$this->masteradmin = array(
			'notifications' => array(
				'master_email' => 'master@localhost'	
			)

		);


		$this->limits = array(
			
			'quantity' => array(
				
			)
		);



		/**
		 *	deprecated, its being kept in product constructor
		 *
		 * 
		 * [$this->product_groups description]
		 * @var array
		 */
		$this->product_groups = array(
			'book' => array( 'cover', 'color', 'bw' ),
			'business-card' => array( 'master' )
		);

		/**
		 * All binding types
		 * @var array
		 */
		$this->binding_types = array(
			'perfect_binding' => array(
				'cost' => array(
					'pa_attr' => 'pa_master_quantity',
					'compare' => 'min',
					'scale' => array(
						array( 'price' => .5, 'v' => 0 )
					)
				)
			),

			'saddle_stitch' => array(
				'cost' => array(
					'pa_attr' => 'pa_master_quantity',
					'compare' => 'min',

					'scale' => array(
						array( 'price' => .5, 'v' => 100 ),
						array( 'price' => 2, 'v' => 50 ),
						array( 'price' => 3, 'v' => 0 )
					)
				)
			),

			'spiral_binding' => array(
				'cost' => array(
					'pa_attr' => 'pa_master_quantity',
					'compare' => 'min',
					'scale' => array(
						array( 'price' => 3, 'v' => 0 )
					)
				)
			),

			'section_sewn' => array(
				'extended' => array(
					'signature_cost' => .07,
					'min_signature_cost' => 150
				),
				'cost' => array(
					'pa_attr' => 'pa_master_quantity',
					'compare' => 'min',
					'scale' => array(
						array( 'price' => 3, 'v' => 0 )
					)
				)
			),

			'hard' => array(
				'extended' => array(
					'signature_cost' => .07,
					'min_signature_cost' => 150,
					'ribbon_cost' => .2
				),
				'minimal_cost' => array(
					'pa_attr' => 'pa_master_quantity',
					'compare' => 'min',
					'scale' => array(
						array( 'price' => 250, 	'v' => 0 ),
						array( 'price' => 300, 	'v' => 49 ),										
						array( 'price' => -1, 'v' => 98 )						
					)
				),
				'cost' => array(
					'pa_attr' => 'pa_master_quantity',
					'compare' => 'min',
					'scale' => array(
						array( 'price' => 3.65, 'v' => 99 ),
						array( 'price' => 3.55, 'v' => 201 ),
						array( 'price' => 3.45, 'v' => 301 ),
						array( 'price' => 3.35, 'v' => 401 ),
						array( 'price' => 3.25, 'v' => 501 ),
						array( 'price' => 3.25, 'v' => 601 ),
						array( 'price' => 3.2, 	'v' => 701 ),
						array( 'price' => 3.2, 	'v' => 801 ),
						array( 'price' => 3.1, 	'v' => 901 )						
					)
				),
				'board_20mm_cost' => array(
					'pa_attr' => 'pa_cover_format',
					'compare' => 'exact',
					'scale' => array(
						array( 'price' => .3, 'v' => 'A5' ),
						array( 'price' => .4, 'v' => 'B5' ),
						array( 'price' => .55, 'v' => 'A4' )						
					)
				),
				'board_25mm_cost' => array(
					'pa_attr' => 'pa_cover_format',
					'compare' => 'exact',
					'scale' => array(
						array( 'price' => .35, 'v' => 'A5' ),
						array( 'price' => .45, 'v' => 'B5' ),
						array( 'price' => .65, 'v' => 'A4' )						
					)
				)
			)
		);

		$this->formats = array(
			'noprint' => array (				
				'SRA3++'	=> 	array('width' => 330,'height' => 487),
				'SRA3'		=> 	array('width' => 320,'height' => 450),
				'RA3' 		=> 	array('width' => 315,'height' => 430),
				'RA3+' 		=> 	array('width' => 315,'height' => 440),
				'RA4' 		=> 	array('width' => 215,'height' => 305),
				'A3' 		=> 	array('width' => 297,'height' => 420),
				'B3' 		=> 	array('width' => 350,'height' => 500), 
				'B4' 		=> 	array('width' => 250,'height' => 350),
				'BN6' 		=> 	array('width' => 600,'height' => 330),
				'BN7' 		=> 	array('width' => 700,'height' => 330)
			),

			'color' => array (				
				'SRA3++'	=> 	array('width' => 330,'height' => 487),
				'SRA3'		=> 	array('width' => 320,'height' => 450),
				'RA3' 		=> 	array('width' => 315,'height' => 430),
				'RA3+' 		=> 	array('width' => 315,'height' => 440),
				'RA4' 		=> 	array('width' => 215,'height' => 305),
				'A3' 		=> 	array('width' => 297,'height' => 420),				
				'B4' 		=> 	array('width' => 250,'height' => 350),
				'BN6' 		=> 	array('width' => 600,'height' => 330),
				'BN7' 		=> 	array('width' => 700,'height' => 330)
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

		$this->production_formats = array(
			'0x' => array (		
				'wizA'		=> array( 'format' => 'SRA3++', 'pieces' => 24,	'grain' => 'LG'),
				'wizB'		=> array( 'format' => 'SRA3++', 'pieces' => 24,	'grain' => 'LG'),
				'wizAFH'	=> array( 'format' => 'SRA3++', 'pieces' => 12,	'grain' => 'LG'),
				'wizBFH'	=> array( 'format' => 'SRA3++', 'pieces' => 12,	'grain' => 'LG'),
				'wizAFV'	=> array( 'format' => 'SRA3++', 'pieces' => 8,	'grain' => 'LG'),
				'wizBFV'	=> array( 'format' => 'SRA3++', 'pieces' => 8,	'grain' => 'LG'),
				'A6'		=> array( 'format' => 'RA3', 	'pieces' => 8, 	'grain' => 'SG'),
				'B6'		=> array( 'format' => 'SRA3++', 'pieces' => 8, 	'grain' => 'SG'),
				'DL'		=> array( 'format' => 'SRA3++', 'pieces' => 6, 	'grain' => 'SG'),
				'A5'		=> array( 'format' => 'RA3', 	'pieces' => 4, 	'grain' => 'LG'),
				'B5'		=> array( 'format' => 'SRA3++', 'pieces' => 4, 	'grain' => 'LG'),
				'A4'		=> array( 'format' => 'RA3', 	'pieces' => 2, 	'grain' => 'SG'),
				'2DLFV'		=> array( 'format' => 'RA3', 	'pieces' => 2, 	'grain' => 'SG'),
				'2DLFH'		=> array( 'format' => 'RA3', 	'pieces' => 3, 	'grain' => 'SG'),
				'B4'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'SG'),
				'A3'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'LG'),
				'B3'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'LG'),
				'SRA3'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'SG'),
				'BN6'		=> array( 'format' => 'BN6', 	'pieces' => 1, 	'grain' => 'SG'),
				'BN7'		=> array( 'format' => 'BN7', 	'pieces' => 1, 	'grain' => 'SG')
			),

			'4x' => array (						
				'wizA'		=> array( 'format' => 'SRA3++', 'pieces' => 24,	'grain' => 'LG'),
				'wizB'		=> array( 'format' => 'SRA3++', 'pieces' => 24,	'grain' => 'LG'),
				'wizAFH'	=> array( 'format' => 'SRA3++', 'pieces' => 12,	'grain' => 'LG'),
				'wizBFH'	=> array( 'format' => 'SRA3++', 'pieces' => 12,	'grain' => 'LG'),
				'wizAFV'	=> array( 'format' => 'SRA3++', 'pieces' => 8,	'grain' => 'LG'),
				'wizBFV'	=> array( 'format' => 'SRA3++', 'pieces' => 8,	'grain' => 'LG'),
				'A6'		=> array( 'format' => 'RA3', 	'pieces' => 8, 	'grain' => 'SG'),
				'B6'		=> array( 'format' => 'SRA3++', 'pieces' => 8, 	'grain' => 'SG'),
				'DL'		=> array( 'format' => 'SRA3++', 'pieces' => 6, 	'grain' => 'SG'),
				'A5'		=> array( 'format' => 'RA3', 	'pieces' => 4, 	'grain' => 'LG'),
				'B5'		=> array( 'format' => 'SRA3++', 'pieces' => 4, 	'grain' => 'LG'),
				'A4'		=> array( 'format' => 'RA3', 	'pieces' => 2, 	'grain' => 'SG'),
				'2DLFV'		=> array( 'format' => 'RA3', 	'pieces' => 2, 	'grain' => 'SG'),
				'2DLFH'		=> array( 'format' => 'RA3', 	'pieces' => 3, 	'grain' => 'SG'),
				'B4'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'SG'),
				'A3'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'LG'),
				'B3'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'LG'),
				'SRA3'		=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'SG'),
				'BN6'		=> array( 'format' => 'BN6', 	'pieces' => 1, 	'grain' => 'SG'),
				'BN7'		=> array( 'format' => 'BN7', 	'pieces' => 1, 	'grain' => 'SG')
			),

			'1x' => array (				
				'DL'	=> array( 'format' => 'SRA3++', 'pieces' => 6, 	'grain' => 'SG'),
				'A6'	=> array( 'format' => 'RA3',	'pieces' => 8, 	'grain' => 'SG'),
				'B6'	=> array( 'format' => 'B3', 	'pieces' => 8, 	'grain' => 'SG'),
				'A5'	=> array( 'format' => 'RA3', 	'pieces' => 4, 	'grain' => 'LG'),
				'B5'	=> array( 'format' => 'B3', 	'pieces' => 4, 	'grain' => 'LG'),
				'A4'	=> array( 'format' => 'RA3', 	'pieces' => 2, 	'grain' => 'SG'),
				'2DLFV'	=> array( 'format' => 'RA3', 	'pieces' => 2, 	'grain' => 'SG'),
				'2DLFH'	=> array( 'format' => 'RA3', 	'pieces' => 3, 	'grain' => 'SG'),
				'B4'	=> array( 'format' => 'B3', 	'pieces' => 2, 	'grain' => 'SG'),
				'A3'	=> array( 'format' => 'RA3', 	'pieces' => 1, 	'grain' => 'LG'),
				'B3'	=> array( 'format' => 'B3', 	'pieces' => 1, 	'grain' => 'LG'),
				'SRA3'	=> array( 'format' => 'SRA3++', 'pieces' => 1, 	'grain' => 'SG'),
				'BN6'	=> array( 'format' => 'BN6', 	'pieces' => 1, 	'grain' => 'SG'),
				'BN7'	=> array( 'format' => 'BN7', 	'pieces' => 1, 	'grain' => 'SG')
			)	
		);

		/**
		 * Common used formats (no production formats)
		 * @var array
		 */
		$this->common_format = array (			

			'wizA'	=> 	array('width' => 85,	'height' => 55, 	'grain' => 'LG' ),								
			'wizB'	=> 	array('width' => 90,	'height' => 50, 	'grain' => 'LG' ),				
			'wizAFV'=> 	array('width' => 170,	'height' => 55, 	'grain' => 'LG' ),	
			'wizBFV'=> 	array('width' => 180,	'height' => 50, 	'grain' => 'LG' ),
			'wizAFH'=> 	array('width' => 85,	'height' => 170, 	'grain' => 'LG' ),	
			'wizBFH'=> 	array('width' => 90,	'height' => 180, 	'grain' => 'LG' ),
			'DL'	=> 	array('width' => 99,	'height' => 210, 	'grain' => 'LG' ),				
			'2DLFH'	=> 	array('width' => 99,	'height' => 420, 	'grain' => 'LG' ),				
			'A6'	=> 	array('width' => 105,	'height' => 148, 	'grain' => 'LG' ),				
			'B6'	=> 	array('width' => 125,	'height' => 176, 	'grain' => 'LG' ),				
			'A5'	=> 	array('width' => 148,	'height' => 210, 	'grain' => 'LG' ),				
			'B5'	=> 	array('width' => 176,	'height' => 250, 	'grain' => 'LG' ),				
			'2DLFV'	=> 	array('width' => 198,	'height' => 210, 	'grain' => 'LG' ),				
			'A4'	=> 	array('width' => 210,	'height' => 297, 	'grain' => 'LG' ),
			'B4'	=> 	array('width' => 250,	'height' => 350, 	'grain' => 'LG' ),				
			'A3'	=> 	array('width' => 297,	'height' => 420, 	'grain' => 'LG' ),				
			'SRA3'=> 	array('width' => 450,	'height' => 320, 	'grain' => 'SG' ),				
			//'B3'	=> 	array('width' => 350,	'height' => 500, 	'grain' => 'LG' ),		
			'BN6'	=> 	array('width' => 600,	'height' => 330, 	'grain' => 'SG' ),
			'BN7'	=> 	array('width' => 700,	'height' => 330, 	'grain' => 'SG' )
		);

		$this->pallet_format_factor = 4;

		$this->pallet_format = array (
			'sg' => array (
				'BN6'		=> 	array('width' => 860,	'height' =>	610),
				'BN7'		=> 	array('width' => 1000,	'height' =>	700),
				'SRA3++'	=> 	array('width' => 1000,	'height' =>	700),
				'SRA3'		=> 	array('width' => 1000,	'height' =>	700),
				'RA3' 		=> 	array('width' => 860,	'height' =>	630),
				'RA3+' 		=> 	array('width' => 880,	'height' =>	630),
				'RA4' 		=> 	array('width' => 880,	'height' =>	630),
				'A3' 		=> 	array('width' => 880,	'height' =>	630),
				'B3' 		=> 	array('width' => 1000,	'height' =>	700),
				'B4' 		=> 	array('width' => 1000,	'height' =>	700)
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
		
		$this->splits = array(
			'0x' => array(
				"*" => array( 0,0)
			),

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
*/
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
				'330x487' => array( '*' => array( .0155, .031 )), //SRA3++ LG
				'487x330' => array( '*' => array( .0155, .031 )), //SRA3++ SG
				'320x450' => array( '*' => array( .0155, .031 )), //SRA3 LG
				'450x320' => array( '*' => array( .0155, .031 )), //SRA3 SG
				'315x430' => array( '*' => array( .0155, .031 )), //RA3 LG
				'430x315' => array( '*' => array( .0155, .031 )), //RA3 SG
				'315x440' => array( '*' => array( .0155, .031 )), //RA3 LG
				'440x315' => array( '*' => array( .0155, .031 )), //RA3 SG
				'215x305' => array(	'*' => array( .0093, .031 )), //RA4 LG
				'305x215' => array(	'*' => array( .0093, .031 )), //RA4 SG
				'297x420' => array(	'*' => array( .0155, .031 )), //A3 LG
				'420x297' => array(	'*' => array( .0155, .031 )), //A3 SG				
				'250x350' => array(	'*' => array( .0093, .019 )), //B4 LG
				'350x250' => array(	'*' => array( .0093, .019 )), //B4 SG
				'350x500' => array(	'*' => array( .0155, .031 )), //B3 LG
				'500x350' => array(	'*' => array( .0155, .031 ))  //B3 SG
				
			),

			'4x' => array(
				'330x487' => array(	'*' => array( .14, .26 )), //SRA3++ LG
				'487x330' => array(	'*' => array( .14, .26 )), //SRA3++ SG
				'320x450' => array(	'*' => array( .14, .26 )), //SRA3 LG
				'450x320' => array(	'*' => array( .14, .26 )), //SRA3 SG
				'315x430' => array(	'*' => array( .14, .26 )), //RA3 LG
				'430x315' => array(	'*' => array( .14, .26 )), //RA3 SG
				'315x440' => array(	'*' => array( .14, .26 )), //RA3 LG
				'440x315' => array(	'*' => array( .14, .26 )), //RA3 SG
				'215x305' => array(	'*' => array( .07, .18 )), //RA4 LG
				'305x215' => array(	'*' => array( .07, .18 )), //RA4 SG
				'297x420' => array(	'*' => array( .07, .18 )), //A3 LG
				'420x297' => array(	'*' => array( .07, .18 )), //A3 SG				
				'250x350' => array(	'*' => array( .07, .18 )), //B4 LG
				'350x250' => array(	'*' => array( .07, .26 )), //B4 SG
				'350x500' => array(	'*' => array( .14, .26 )), //B3 LG
				'500x350' => array(	'*' => array( .14, .26 )),  //B3 SG
				'600x330' => array(	'*' => array( .39, .78 ))  //B3 SG
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

		$this->wrap_cost = array(
			'0x0' => 0,
			'gloss-1x1' => .2,
			'gloss-1x0' => .1,
			'matt-1x1' => .2,
			'matt-1x0' => .1,
			'soft-touch-1x1' => .8,
			'soft-touch-1x0' => .4,
		);

		$this->total_cost_equasion = array(
			//universal
			'plain' => array(
				'equasion' => 'pa_master_paper + pa_master_print + pa_master_wrap + pa_master_folding + pa_master_spot_uv'
			),



			'plano' => array(
				'equasion' => 'pa_bw_paper + pa_bw_print + pa_color_paper + pa_color_print'
			),

			'plano_color' => array(
				'equasion' => 'pa_color_paper + pa_color_print'
			),

			'plano_bw' => array(
				'equasion' => 'pa_bw_paper + pa_bw_print'
			),

			'letterhead' => array(
				'equasion' => 'pa_color_paper + pa_color_print + pa_bw_paper + pa_bw_print'
			),

			'letterhead_color' => array(
				'equasion' => 'pa_color_paper + pa_color_print'
			),

			'letterhead_bw' => array(
				'equasion' => 'pa_bw_paper + pa_bw_print'
			),


			'writing-pad' => array(
				'equasion' => 'pa_cover_type + pa_cover_paper + pa_cover_print + pa_cover_finish + pa_cover_spot_uv + pa_color_paper + pa_color_print + pa_bw_paper + pa_bw_print'
			),



			'book' => array(
				'equasion' => 'pa_cover_type + pa_cover_paper + pa_cover_print + pa_cover_finish + pa_cover_spot_uv + pa_bw_paper + pa_bw_print + pa_color_paper + pa_color_print + pa_bw_sewing + pa_color_sewing'
			),

			'catalog' => array(
				'equasion' => 'pa_cover_type + pa_cover_paper + pa_cover_print + pa_cover_finish + pa_cover_spot_uv + pa_color_paper + pa_color_print' 
			),
		);

		$this->spot_uv_cost = array(
			'cost' => 155,
			'stack' => 1000
		);


	}

}