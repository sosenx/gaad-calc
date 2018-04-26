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

		
		

		500 => array( 'type' => 'fatal',
			'err' => 'Authentication failed',
			'solution' => 'Check used credentials or send no credentials for anonymous service'
		),
		
		535 => array( 'type' => 'fatal',
			'err' => 'Missing credentials filter function: ',
			'solution' => 'call administrator'
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
		4012 => array( 'type' => 'fatal',
			'label' => 'Products attributes out of range (format)',
			'err' => 'Format out of range',
			'solution' => 'Select smaller format or change cover type.'
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
		


		10100 => array( 'type' => 'attr_change',
			'label' => 'Apikey set to anonymous',
			'err' => 'Apikey set to anonymous',
			'solution' => 'set apikey'
		),
		10101 => array( 'type' => 'attr_change',
			'label' => 'Api secret  set to anonymous',
			'err' => 'Apikey secret set to anonymous',
			'solution' => 'set apikey secret'
		),
		10102 => array( 'type' => 'attr_change',
			'label' => 'Auth set to anonymous',
			'err' => 'Auth set to anonymous',
			'solution' => 'set Authorization header'
		),
		10103 => array( 'type' => 'info',
			'label' => 'Skipping autosave',
			'err' => 'Skipping calculation autosave due to acces_level',
			'solution' => 'Only specific calculations are set to be saved, call administrator for frther informations'
		),


		10000 => array( 'type' => 'attr_change',
			'label' => 'Attribute changed by product constructor',
			'err' => 'Attribute changed by product constructor',
			'solution' => ''
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
		),
		10007 => array( 'type' => 'attr_change',
			'label' => 'Dust jacket print mode set to 4x0',
			'err' => 'No Dust jacket print mode, set to 4x0',
			'solution' => 'Send pa_cover_dust_jacket_print header with request'
		),
		10008 => array( 'type' => 'attr_change',
			'label' => 'Dust jacket wrap set to 0x0',
			'err' => 'No Dust jacket wrap, setting to 0x0',
			'solution' => 'Send pa_cover_dust_jacket_wrap header with request'
		),
		10009 => array( 'type' => 'attr_change',
			'label' => 'Cloth covering paper set to default',
			'err' => 'No Cloth covering paper , setting to ',
			'solution' => 'Send pa_cover_cloth_covering_paper header with request'
		),
		10010 => array( 'type' => 'attr_change',
			'label' => 'Cloth covering print set to default',
			'err' => 'No Cloth covering print , setting to ',
			'solution' => 'Send pa_cover_cloth_covering_print header with request'
		),
		10011 => array( 'type' => 'attr_change',
			'label' => 'Cloth covering wrap set to default',
			'err' => 'No Cloth covering wrap , setting to ',
			'solution' => 'Send pa_cover_cloth_covering_wrap header with request'
		),
		10012 => array( 'type' => 'attr_change',
			'label' => 'Master wrap changed by spot_uv',
			'err' => 'Spot uv needs wrap, setting wrap to ',
			'solution' => 'Send pa_wrap header with request'
		),
		10013 => array( 'type' => 'attr_change',
			'label' => 'Wrap changed by spot_uv',
			'err' => 'Cannot use gloss wrap and gloss spot uv, set wrap to mat',
			'solution' => 'Use mat wrap when using spot uv'
		),
		10014 => array( 'type' => 'attr_change',
			'label' => 'Cover wrap changed by cover_type',
			'err' => 'Cover wrap changed to 0x0 because cloth covering wrap is set and cover_type is hard',
			'solution' => 'Do not send pa_wrap with cloth_covering_wrap and hard cover type'
		),
		10015 => array( 'type' => 'attr_change',
			'label' => 'Cover spot uv changed by cover_type',
			'err' => 'Cover spot uv changed to 0x0 because cloth covering spot uv is set and cover_type is hard',
			'solution' => 'Do not send pa_spot_uv with cloth_covering_spot_uv and hard cover type'
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
	public function get( $code ){		
		if ( array_key_exists( $code, $this->codes) ) {
			return $this->codes[ $code ];	
		}
		
		return $this->codes[ 0 ];
	}


}	