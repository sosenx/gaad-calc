<?php
namespace gcalc\db\product;

/**
 * 
 */
class product {
	
	/**
	 * base data array
	 * -tile, author, content etc
	 * 
	 * @var [type]
	 */
	public $base;

	/**
	 * Product attributes with all posible values
	 * @var [type]
	 */
	public $attr;

	/**
	 * Product title, shortcut for base['post_title']
	 * @var [type]
	 */
	private $title;

	/**
	 * True if product already 
	 * @var [type]
	 */
	private $exists;

	/**
	 * Product ID, aquaired from title or given by create
	 * @var [type]
	 */
	private $ID;



	/**
	 * 
	 * @param array|null $base array of primary product parameters
	 * @param array|null $attr [description]
	 */
	function __construct( array $base = NULL, array $attr = NULL )	{
		$this->set_base( $base );
		$this->set_attr( $attr );
	}

	/**
	 * Adds attributes and values to product
	 */
	public function add_product_attributes( ) {
		$attr = $this->get_attr();
		$ID = $this->get_ID();
		$max = count( $attr );		
		for ( $i=0; $i < $max ; $i++ ) { 
			$set = $attr[ $i ];			
			 \gcalc\register_woo_elements::add_product_attribute( $ID, $set[0], $set[1], $set[2] );
		}
	}


	/**
	 * add product post using base as data source
	 * @return [type] [description]
	 */
	public function create_product( ){
		$base = $this->get_base();
		if ( !$this->get_exists() || \gcalc\GAAD_PLUGIN_TEMPLATE_FORCE_CREATE_WOO_ELEMENTS) {
			//creating product
			$post_id = wp_insert_post( array(
		        'post_author' => $base['author'],
		        'post_title' => $this->get_title(),
		        'post_content' => '',
		        'post_status' => 'publish',
		        'post_type' => "product",
		    ) );
		    wp_set_object_terms( $post_id, 'variable', 'product_type' );			
		    
		}

		if ( $this->get_exists() ) {
			$post_id = $this->get_product_ID();
		}

		$this->set_ID( $post_id );
	}


	public function get_product_ID( ) {
		$product = $this->product_exists( );		
		return $product->ID;				
	}

	/**
	 * Checks if product of given title exists in database
	 * @param  boolean|null $return_bool [description]
	 * @return [type]                    [description]
	 */
	public function product_exists( boolean $return_bool = NULL ){
		$title = $this->get_title();
		$q = new \WP_Query( array(
			'post_type' 	=> 'product',	
			'post_status'   => 'publish',
			'title' 		=> $title
		) );
		$posts = $q->posts;

		if ( !$posts ) { // no posts escaping
			return false;
		}

		$max = count( $posts );
		for ( $i=0; $i < $max ; $i++ ) { 
			$post = $posts[ $i ];	
			if ( preg_match('/^'. $title .'$/', $post->post_title ) ) {				
				return $return_bool ? true : $post;
			}			
		}
		return false;
	}



	/**
	 * setter for base
	 * @param array $base array of primary product parameters
	 */
	function set_base( array $base = NULL ){
		$this->base = is_array( $base ) ? $base : 
			( method_exists( $this, 'set_base_defaults' ) ? $this->set_base_defaults( ) : array() )
		;
		
	}


	/**
	 * setter for product attributes array
	 * @param array $attr peoduct attributes array
	 */
	function set_attr( array $attr = NULL ){
		$this->attr = is_array( $attr ) ? $attr :
			( method_exists( $this, 'set_attr_defaults' ) ? $this->set_attr_defaults( ) : array() )
		;
	}
	

	/**
	 * Setter for product title
	 * @param string $title product title
	 */
	function set_title( string $title = NULL ){
		if ( is_null( $title ) && array_key_exists( 'post_title', $this->base ) ) {
			$title = $this->base['post_title'];			
		} 
		$this->title = $title;
	}
	
	/**
	 * Setter for exists	 
	 */
	function set_exists( ){
		$exists = false;
		if ( !empty( $this->base ) ) {
			$exists = $this->product_exists();
		} 
		$this->exists = $exists;
	}

	/**
	 * Setter for ID
	 * @param mixed $ID product post id
	 */
	function set_ID( $ID ){
		$this->ID = $ID;
	}
	

	

	/**
	 * Getter for product ID
	 * @return [type] [description]
	 */
	function get_ID( ){
		return $this->ID;
	}

	/**
	 * Getter for exists
	 * @return boolean True if product exists as post in database
	 */
	function get_exists( ){
		return $this->exists;
	}
			
	/**
	 * Getter for base
	 * @return array base set of product data, title etc.
	 */
	function get_base( ){
		return $this->base;
	}


	/**
	 * Getter for attr
	 * @return array Set of product attributes and its values
	 */
	function get_attr( ){
		return $this->attr;
	}


	/**
	 * Getter for title
	 * @return string Product title
	 */
	function get_title( ){
		return $this->title;
	}

}