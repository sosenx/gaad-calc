<?php

namespace gcalc\db;


class calc_order{

	/**
	*	
	*/
	private $order;

	/**
	* Reference to assosiated with calculation shop product object
	*/
	private $product_id;

	/**
	*
	*/
	public function __construct( int $product_id ){
		$this->product_id = $product_id;
		$this->aquire();
	}

	/**
	*
	*/
	public function get_product_slug( ){
		$product = new \WC_Product( $this->get_PID() );
		return $product->get_slug();
	}

	/**
	*
	*/
	public function aquire( ){
		$this->order = array(
			'plain' => array ( 
				'master' => array('pa_master_format', 'pa_master_paper', 'pa_master_print', 'pa_master_spot_uv', '*') 
			),

			'wizytowki' => array ( 
				'master' => array('pa_master_format', 'pa_master_paper', 'pa_master_print', 'pa_master_spot_uv', '*') 
			),


			'plano' => array ( 
				'master' =>array('pa_master_format', '*'),				
			    "bw" => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*'),
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', '*' ),
			),
			'plano_bw' => array ( 
				'master' =>array('pa_master_format', '*'),				
			    "bw" => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*')			    
			),
			'plano_color' => array ( 
				'master' =>array('pa_master_format', '*'),							    
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', '*' )
			),
			'letterhead' => array ( 				
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*' )
			),
			'letterhead_color' => array ( 				
			    "color" => array( 'pa_color_format', 'pa_color_pages', 'pa_color_paper', 'pa_color_print', '*' )
			),
			'letterhead_bw' => array ( 				
			    "color" => array( 'pa_bw_format', 'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print', '*' )
			),


			'writing-pad' => array ( 
				'master' =>array('pa_master_format', '*'),
				"cover" => array( 'pa_cover_format','pa_cover_paper', /* 'pa_cover_print', */'*' ),
			    "bw" => array( 'pa_bw_format', /*'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print' */ '*'),
			    "color" => array( 'pa_color_format', /*'pa_color_pages', 'pa_color_paper', 'pa_color_print',*/ '*' ),
			),


			'book' => array ( 
				'master' =>array('pa_master_format', '*'),
				"cover" => array( 'pa_cover_format','pa_cover_paper', /* 'pa_cover_print', */'*' ),
			    "bw" => array( 'pa_bw_format', /*'pa_bw_pages', 'pa_bw_paper', 'pa_bw_print' */ '*'),
			    "color" => array( 'pa_color_format', /*'pa_color_pages', 'pa_color_paper', 'pa_color_print',*/ '*' ),
			),
			'catalog' => array ( 
				'master' =>array('pa_master_format', '*'),
				"cover" => array( 'pa_cover_format','pa_cover_paper', /* 'pa_cover_print', */'*' ),			  
			    "color" => array( 'pa_color_format', /*'pa_color_pages', 'pa_color_paper', 'pa_color_print',*/ '*' ),
			),
		);

	}


	/**
	*
	*/
	public function get_order( ){
		if ( array_key_exists( $this->get_product_slug(), $this->order )) {
			$order = $this->order[ $this->get_product_slug() ];
		} else {
			$order = $this->order[ 'plain' ];
		}
		return $order;
	}
	
	/**
	* getter for PID
	*/
	function get_PID(){
		return $this->product_id;
	}

}	