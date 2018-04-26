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
	function __construct( $base = NULL, $attr = NULL )	{
		$this->set_base( $base );
		$this->set_attr( $attr );
	}

	/**
	 * Gets product constructor attributes filter array using product slug
	 * @param  $product_slug Product slug
	 * @return array               products attributes returned by get_attr_filter method
	 */
		public static function product_constructor_method( $product_slug, $method_name ){
			$get_attr_filter_method = \gcalc\calc_product::get_product_constructor_method( $method_name, $product_slug );

			$get_attr_filter_data = $get_attr_filter_method['exists'] 
			? $get_attr_filter_method['product_constructor_name'].'::'.$get_attr_filter_method['method_name']
			: false;
			
			var_dump( call_user_method($get_attr_filter_method['method_name'], $get_attr_filter_method['product_constructor_name']) );
		$product_attr_filter_data = $get_attr_filter_data ? $get_attr_filter_data() : false;
			return $get_attr_filter_data ? $get_attr_filter_data() : false;
		}

	/**
	 * Array that will be returned with rest data under model object	
	 * 
	 * @param  [type] $product_slug [description]
	 * @return [type]               [description]
	 */
	public static function rest_data( $product_slug ) {
		$r = array( );
		$get_rest_data_method = \gcalc\calc_product::get_product_constructor_method( 'get_rest_data', $product_slug );		
		$get_rest_data = $get_rest_data_method['exists'] 
			? $get_rest_data_method['product_constructor_name'].'::'.$get_rest_data_method['method_name']
			: false;		

		//$product_rest_data = $get_rest_data ? $get_rest_data() : false;

		$r['rest_data'] = array(

			'markups_changes' => \gcalc\db\product\product::product_constructor_method( $product_slug, 'get_markups_changes' ),
			'calc_data' => \gcalc\db\product\product::product_constructor_method( $product_slug, 'get_calc_data' ),
			'composer_validation_data' => \gcalc\db\product\product::product_constructor_method( $product_slug, 'get_composer_validation_data' ),
			'attr_bw_lists' => \gcalc\db\product\product::product_constructor_method( $product_slug, 'get_attr_bw_lists' ),
			'attr_filter' => \gcalc\db\product\product::product_constructor_method( $product_slug, 'get_attr_filter' ),
			'form_validation' => \gcalc\db\product\product::product_constructor_method( $product_slug, 'get_form_validations' ),
			'attr_values' => \gcalc\db\product\product::parse_product_attr_defaults(	\gcalc\db\product\product::product_constructor_method( $product_slug, 'get_attr_defaults' ) ),
			//'attr_values_names' =>	\gcalc\db\product\product::product_constructor_method( $product_slug, 'get_attr_values_names' )
		);

		$r['rest_data']['attr_values_names'] = \gcalc\db\product\product::get_product_attr_values_names( $r['rest_data']['attr_values'] );
		//$r['product_rest_data'] = $product_rest_data;

		return $r;
	}


	/**
	 * [get_product_attr_values_names description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public static function get_product_attr_values_names( $data ){
		$r = array();	
		foreach ($data as $pa_name => $values ) {
			if ( method_exists( '\gcalc\register_woo_elements', 'pa_' . $pa_name) ) {
				$attr_constructor_method = '\gcalc\register_woo_elements::pa_' . $pa_name;
				$labels = $attr_constructor_method( true );

				if( $labels ){
					'pa_' . $r[ $pa_name ] = $labels;
				}
			}
		}
		return $r;
	}

	/**
	 * Parses rare attributes defaults from product constructor to more frontend frendly form
	 * @param  array  $attributes [description]
	 * @return [type]             [description]
	 */
		public static function parse_product_attr_defaults( $attributes ){
			if (!$attributes) {
				return array();
			}
			$r = array();
			$max = count( $attributes );
			for ( $i=0; $i < $max ; $i++ ) { 
				$attribute = $attributes[ $i ];
				$r[ $attribute[0] ] = $attribute[ 1 ];
			}
			
			return $r;
		}

	/**
	 * Filters attributes to nessesary set only
	 * Needed set of attributes origin should be a method of product constructor class in namespace \gcalc\db\product
	 * 
	 * @return array filtered set of nessesary product attributes
	 */
	public static function filter_attributes( $input, $product_slug ) {
		/*
		 * Checking if product have filtering matrix array
		 */
		if ( 
			class_exists( $product_constructor = '\\' . __NAMESPACE__ .'\\' . str_replace( '-', '_', $product_slug ) )
			&& method_exists( $product_constructor, 'get_attr_filter' )
		) {
			$matrix = $product_constructor::get_attr_filter()['matrix'];
			$groups = $product_constructor::get_attr_filter()['groups'];
			$tmp = $input;
			foreach ($tmp as $key => $value) {
				
				/*
					checking attributes pa_
				*/
				if ( preg_match('/^pa_/', $key) ) {

					if ( !array_key_exists( $key, $matrix ) ) {
						unset( $tmp[ $key ] );
					} else {
						/*
						u can do something more with value of a attribute
						work on that is not even in progress but some day ....
						*/
					}
				}

				/*
					filtering groups
				*/
				if ( preg_match('/^group_/', $key) && !in_array( str_replace( 'group_', '', $key), $groups ) ) {
					unset( $tmp[ $key ] );
				}

			}
			
			//tmp is a filtered input array
			return $tmp;	
		}

		//nothing changed
		return $input;
	}

	/**
	 * Validates and changes attributes values before calculation
	 * @param  string           $process_name [description]
	 * @param  array            $cargs        [description]
	 * @param  \gcalc\calculate $parent       [description]
	 * @return [type]                         [description]
	 */
	public static function validate_cargs( $process, $cargs, \gcalc\calculate $parent, $product_constructor ){
		$process_name = $process->name;
		$group = $process->group[0];
		$full_process_name = $process->group[1];
		$tmp  = str_replace( '_' . $group, '', $full_process_name );
		$tmp2 = $tmp === $process_name;
		$valid = true;
		
		
		if ( method_exists( $product_constructor, 'validate__' . $full_process_name ) ) {
			$validate_method_name = 'validate__' . $full_process_name;
			$valid = $product_constructor::$validate_method_name( $cargs, $parent, $process );
			
			$r=1; 
			//$valid = call_user_func( $product_constructor . '::validate__' . $full_process_name, $cargs, $parent, $process );
					
		} elseif ( method_exists( $product_constructor, 'validate__' . $process_name ) ) {
			$validate_method_name = 'validate__' . $process_name;
			$valid = $product_constructor::$validate_method_name( $cargs, $parent, $process );
			//$valid = call_user_func( $product_constructor . '::validate__' . $process_name, $cargs, $parent, $process );
			$r=1; 
		}

		return $valid;
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
		if ( !$this->get_exists() || \gcalc\GCALC_FORCE_CREATE_WOO_ELEMENTS) {
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
	public function product_exists( $return_bool = NULL ){
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
	 * @param $base array of primary product parameters
	 */
	function set_base( $base = NULL ){
		$this->base = is_array( $base ) ? $base : 
			( method_exists( $this, 'set_base_defaults' ) ? $this->set_base_defaults( ) : array() )
		;
		
	}


	/**
	 * setter for product attributes array
	 * @param $attr peoduct attributes array
	 */
	function set_attr( $attr = NULL ){
		$this->attr = is_array( $attr ) ? $attr :
			( method_exists( $this, 'set_attr_defaults' ) ? $this->set_attr_defaults( ) : array() )
		;
	}
	

	/**
	 * Setter for product title
	 * @param $title product title
	 */
	function set_title( $title = NULL ){
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
	 * Setter for attr filter
	 * @param $attr_filter [description]
	 */
	function set_attr_filter( $attr_filter ){	
		$this->attr_filter = $attr_filter;
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