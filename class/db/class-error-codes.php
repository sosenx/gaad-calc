<?php

namespace gcalc\db\error;


class codes{

	private $codes = array( 

		0 => array( 'type' => 'fatal',
			'err' => 'Unknown error',
			'solution' => 'Call 0048 503 356 559'
		),

		1 => array( 'type' => 'info',
			'err' => 'Missing error code',
			'solution' => ''
		),


		4001 => array( 'type' => 'fatal',
			'label' => 'No product ID or slug',
			'err' => 'Missing product ID or/and product slug in input data',
			'solution' => 'Add `product_slug` to request headers, use `plain` if you don\'t know product type'
		)
	);


	/**
	*
	*/
	public function __construct(){				
	}

	/**
	*
	*/
	public function get( int $code ){		
		if ( array_key_exists( $code, $this->codes) ) {
			return $this->codes[ $code ];	
		}
		
		return $this->codes[ 0 ];
	}


}	