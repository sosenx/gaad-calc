<?php 
namespace gcalc;


class register_taxonomies{



	function __construct(){	
		$this->create_plugin_taxonomies();
	}

	public static function create_product_attributes(){
		\gcalc\register_taxonomies::pa_sizemm();

		

	}

	/**
	* Adds sizemm attribute
	*/
	public static function pa_sizemm(){
		$name = 'sizemm';
		$label = 'Rozmiar';
		\gcalc\register_taxonomies::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'text',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( '90x50', 	'pa_' . $name, array( 'description' => \__('Calling card 90x50mm', 'gcalc'), 'slug' => '90x50' ) );
		\wp_insert_term( '85x55', 	'pa_' . $name, array( 'description' => '', 'slug' => '85x55' ) );
		\wp_insert_term( '105x148', 'pa_' . $name, array( 'description' => '', 'slug' => '105x148' ) );
		\wp_insert_term( '148x210', 'pa_' . $name, array( 'description' => '', 'slug' => '148x210' ) );
		\wp_insert_term( '210x297', 'pa_' . $name, array( 'description' => '', 'slug' => '210x297' ) );
		\wp_insert_term( '297x420', 'pa_' . $name, array( 'description' => '', 'slug' => '297x420' ) );
		\wp_insert_term( '125x176', 'pa_' . $name, array( 'description' => '', 'slug' => '125x176' ) );
		\wp_insert_term( '176x250', 'pa_' . $name, array( 'description' => '', 'slug' => '176x250' ) );
		\wp_insert_term( '250x353', 'pa_' . $name, array( 'description' => '', 'slug' => '250x353' ) );			
		
	}

	/**
	* Sprawdza
	*
	*
	*/
	public static function term_exists( $label, $name ){
		$term = \term_exists( $label, 'pa_' . $name );
		return $term === NULL ? false: true;
	}

	public static function process_add_attribute( array $attribute ){
	    global $wpdb;	

	    if (empty($attribute['attribute_type'])) { $attribute['attribute_type'] = 'text';}
	    if (empty($attribute['attribute_orderby'])) { $attribute['attribute_orderby'] = 'menu_order';}
	    if (empty($attribute['attribute_public'])) { $attribute['attribute_public'] = 0;}

	    if ( empty( $attribute['attribute_name'] ) || empty( $attribute['attribute_label'] ) ) {
	            return new \WP_Error( 'error', __( 'Please, provide an attribute name and slug.', 'woocommerce' ) );
	    } elseif ( ( $valid_attribute_name = \gcalc\register_taxonomies::valid_attribute_name( $attribute['attribute_name'] ) ) && is_wp_error( $valid_attribute_name ) ) {
	            return $valid_attribute_name;
	    } elseif ( taxonomy_exists( wc_attribute_taxonomy_name( $attribute['attribute_name'] ) ) ) {
	            return new \WP_Error( 'error', sprintf( __( 'Slug "%s" is already in use. Change it, please.', 'woocommerce' ), sanitize_title( $attribute['attribute_name'] ) ) );
	    }

	    $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );

	    do_action( 'woocommerce_attribute_added', $wpdb->insert_id, $attribute );

	    flush_rewrite_rules();
	    delete_transient( 'wc_attribute_taxonomies' );

	    return true;
	}
	
	public static function valid_attribute_name( $attribute_name ) {
	    if ( strlen( $attribute_name ) >= 28 ) {
	            return new \WP_Error( 'error', sprintf( __( 'Slug "%s" is too long (28 characters max). Shorten it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
	    } elseif ( wc_check_if_attribute_name_is_reserved( $attribute_name ) ) {
	            return new \WP_Error( 'error', sprintf( __( 'Slug "%s" is not allowed because it is a reserved term. Change it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
	    }

	    return true;
	}




	function create_plugin_taxonomies(){

		add_action( 'woocommerce_after_register_taxonomy', '\gcalc\register_taxonomies::create_product_attributes' );


	}

}


?>