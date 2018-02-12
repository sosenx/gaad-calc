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
			'wizytowki' => array ( 'pa_format', 'pa_podloze', 'pa_zadruk', 'pa_spot_uv', '*' )
		);

	}


	/**
	*
	*/
	public function get_order( ){
		return $this->order[ $this->get_product_slug() ];

	}
	
	/**
	* getter for PID
	*/
	function get_PID(){
		return $this->product_id;
	}

}	