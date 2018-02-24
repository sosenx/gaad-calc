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
		),
		4002 => array( 'type' => 'fatal',
			'label' => 'Missing products attributes',
			'err' => 'Unknownk format',
			'solution' => 'Send pa_format header with request'
		),
		4003 => array( 'type' => 'fatal',
			'label' => 'Missing products attributes',
			'err' => 'Unknownk print',
			'solution' => 'Send pa_print header with request'
		),
		4004 => array( 'type' => 'fatal',
			'label' => 'Missing products attributes',
			'err' => 'Unknownk paper',
			'solution' => 'Send pa_paper header with request'
		),
		4005 => array( 'type' => 'fatal',
			'label' => 'Missing groups',
			'err' => 'Missing groups: ',
			'solution' => 'Check headers sent with request'
		),
		


		10001 => array( 'type' => 'attr_change',
			'label' => 'Quantity set to 1',
			'err' => 'No quantity, set to 1',
			'solution' => 'Send pa_quantity header with request'
		),
		10002 => array( 'type' => 'attr_change',
			'label' => 'BW pages set to 1',
			'err' => 'No BW pages, set to 1',
			'solution' => 'Send pa_bw_pages header with request'
		),
		10003 => array( 'type' => 'attr_change',
			'label' => 'Color pages set to 1',
			'err' => 'No color pages, set to 1',
			'solution' => 'Send pa_color_pages header with request'
		),
		10004 => array( 'type' => 'attr_change',
			'label' => 'Color stack set to shuffled',
			'err' => 'No color pages stack, set to 1',
			'solution' => 'Send pa_color_stack header with request'
		),
		10006 => array( 'type' => 'attr_change',
			'label' => 'Cover type set to perfect_binding',
			'err' => 'No cover type stack, set to perfect_binding',
			'solution' => 'Send pa_cover_type header with request'
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