<?php 
namespace gcalc;


class register_woo_elements{ 

	function __construct(){	
		$this->create_plugin_elements();
	}


	

	/**
	* Creates predefined products base.
	*	
	*/
	public static function create_users(){

		if ( !\gcalc\GAAD_PLUGIN_TEMPLATE_DISABLE_CREATE_USERS ) {
			\gcalc\register_woo_elements::create_user( 'gaad', 'koot123', 'bsoqsnowski@c-p.com.pl', 'editor',
				array(
					'apikey' => 'g1a2a3d',
					'apipassword' => 'k1o2o3t'
				)
			 );
			\gcalc\register_woo_elements::create_user( 'gaad-12921', 'koot123', 'b.sosnowski@c-p.com.pl', 'editor',
				array(
					'apikey' => '8a7c8b67fe8bde8bb31f62db5896a1cd8c7bfa29ff7b86554a1ad2958c166e92',
					'apipassword' => '62c582a63ce60ee9b5e046abcc7625261532bee74df467927586d5ea384fff27'
				) );
			\gcalc\register_woo_elements::create_user( 'wojtek-12921', 'wojtek123', 'wojtek@c-p.com.pl', 'editor',
				array(
					'apikey' => '8a7c8b67fe8bde8bb31f62db5896a1cd8c7bfa29ff7b86554a1ad2958c166e92',
					'apipassword' => '62c582a63ce60ee9b5e046abcc7625261532bee74df467927586d5ea384fff27'
				) );			
		}
	}


	/**
	* Creates predefined products base.
	*	
	*/
	public static function create_user( string $nickname, string $password, string $email_address, string $role, array $meta = NULL ){		
		
		$username_exists = \username_exists( $email_address );
		if( is_null( $username_exists) || !$username_exists ) {

		  $user_id = \wp_create_user( $nickname, $password, $email_address );
			if ( $user_id instanceof WP_Error ) {
				return false;
			}
		  // Set the nickname
		  \wp_update_user(
		    array(
		      'ID'          =>    $user_id,
		      'nickname'    =>    $nickname
		    )
		  );

		  $role = !isset( $role ) ? $role : 'contributor';
		  // Set the role
		  $user = new \WP_User( $user_id );
		  $user->set_role( $role );

		  if ( isset( $meta ) ) {
		  	foreach ( $meta as $meta_key => $meta_value ) {
		  		add_user_meta( $user_id, $meta_key, $meta_value, true );
		  	}
		  }

		} // end if

	}



	/**
	* Creates predefined products base.
	*	
	*/
	public static function create_products(){
		if ( !\gcalc\GAAD_PLUGIN_TEMPLATE_DISABLE_CREATE_PRODUCTS ) {
			/*
			new \gcalc\db\product\business_card();	
			new \gcalc\db\product\flyer();	
			new \gcalc\db\product\book();	
			new \gcalc\db\product\catalog();	
			new \gcalc\db\product\perfect_bound_catalog();	
			new \gcalc\db\product\saddle_stitched_catalog();	
			new \gcalc\db\product\spiral_bound_catalog();	
			
			new \gcalc\db\product\folded_business_card();	
			new \gcalc\db\product\plano();	
			new \gcalc\db\product\plano_color();	
			new \gcalc\db\product\plano_bw();	
			new \gcalc\db\product\brochure();	
			new \gcalc\db\product\letterhead();	
			new \gcalc\db\product\letterhead_color();	
			new \gcalc\db\product\letterhead_bw();	
			
		
			new \gcalc\db\product\writing_pad();	*/
		}
	}

	/**
	* Creates predefined attributes.
	*	
	*/
	public static function create_product_attributes(){

		if ( !\gcalc\GAAD_PLUGIN_TEMPLATE_DISABLE_CREATE_ATTRIBUTES ) {
			

			\gcalc\register_woo_elements::pa_quantity();
			\gcalc\register_woo_elements::pa_bw_pages();
			\gcalc\register_woo_elements::pa_color_pages();
			\gcalc\register_woo_elements::pa_color_stack();
			\gcalc\register_woo_elements::pa_cover_ribbon();
			\gcalc\register_woo_elements::pa_cover_ribbon_width();
			\gcalc\register_woo_elements::pa_orientation();
			\gcalc\register_woo_elements::pa_groupwrap();
			\gcalc\register_woo_elements::pa_color_pages_numbers();
			\gcalc\register_woo_elements::pa_drilling_holes();
			\gcalc\register_woo_elements::pa_holes_dia();
			\gcalc\register_woo_elements::pa_holes_pos();
			\gcalc\register_woo_elements::pa_pieces_per_carton();
			\gcalc\register_woo_elements::pa_title();
			\gcalc\register_woo_elements::pa_book_number();
			\gcalc\register_woo_elements::pa_comments();




			/*
			 * Cover
			 */
			\gcalc\register_woo_elements::pa_cover_type();				
			\gcalc\register_woo_elements::pa_cover_flaps();
			\gcalc\register_woo_elements::pa_cover_left_flap_width();
			\gcalc\register_woo_elements::pa_cover_right_flap_width();
			\gcalc\register_woo_elements::pa_cover_board_thickness();

			/*
			 * Paper: default, cover, cloth covering, dust jacket, color block, bw block
			 */
			\gcalc\register_woo_elements::pa_print();				
				\gcalc\register_woo_elements::pa_cover_print();
				\gcalc\register_woo_elements::pa_cover_cloth_covering_print();
				\gcalc\register_woo_elements::pa_cover_dust_jacket_print();
				\gcalc\register_woo_elements::pa_cover_endpaper_print();
				\gcalc\register_woo_elements::pa_color_print();
				\gcalc\register_woo_elements::pa_bw_print();

			/*
			 * Paper: default, cover, color block, bw block
			 */
			\gcalc\register_woo_elements::pa_format();
				\gcalc\register_woo_elements::pa_cover_format();
				\gcalc\register_woo_elements::pa_color_format();
				\gcalc\register_woo_elements::pa_bw_format();

			/*
			 * Paper: default, cover, board, cloth covering, dust jacket, color block, bw block
			 */
			\gcalc\register_woo_elements::pa_paper();
				\gcalc\register_woo_elements::pa_cover_paper();
				\gcalc\register_woo_elements::pa_cover_endpaper_paper();
				\gcalc\register_woo_elements::pa_cover_cloth_covering_paper();
				\gcalc\register_woo_elements::pa_cover_dust_jacket_paper();
				\gcalc\register_woo_elements::pa_color_paper();
				\gcalc\register_woo_elements::pa_bw_paper();			

			/*
			 * Finish: default, cover, cloth covering, dust jacket
			 */
			\gcalc\register_woo_elements::pa_finish();
				\gcalc\register_woo_elements::pa_cover_finish();
				\gcalc\register_woo_elements::pa_cover_cloth_covering_finish();
				\gcalc\register_woo_elements::pa_cover_dust_jacket_finish();

			/*
			 * Spot UV: default, cover, cloth covering, dust jacket 
			 */
			\gcalc\register_woo_elements::pa_spot_uv();	
				\gcalc\register_woo_elements::pa_cover_spot_uv();
				\gcalc\register_woo_elements::pa_cover_cloth_covering_spot_uv();
				\gcalc\register_woo_elements::pa_cover_dust_jacket_spot_uv();

			
			\gcalc\register_woo_elements::pa_folding();	
			\gcalc\register_woo_elements::pa_folding_dir();	




				
		}		
	}

	/**
	* Adds Business cards to product base
	*
	* @param string $product_title Tytul produktu
	*/
	public static function product_exists( $product_title ){
		$posts = new \WP_Query( array( 'post_title' => $product_title, 'post_type' => 'product', 'post_status' => 'publish'  ));
		return count( $posts->posts ) > 0;
	}

	/**
	* Returns product by title name
	*
	* @param string $product_title Tytul produktu
	*/
	public static function get_product_by_title( $product_title ){
		$posts = new \WP_Query( array( 'post_title' => $product_title, 'post_type' => 'product', 'post_status' => 'publish'  ));
		return $posts->posts;
	}

	

	/**
	* Adds attribute to product
	*
	* @param int $post_id,
	* @param string $attribute_name
	* @param array 	$attribute_value
	* @param string $attribute_sett
	*/
	public static function add_product_attribute( int $post_id, string $attribute_name, array $attribute_value, string $attribute_sett ) {
		$attribute_name = preg_match('/^pa_.*/', $attribute_name ) ? $attribute_name : 'pa_' . $attribute_name;
		wp_set_object_terms($post_id, $attribute_value, $attribute_name, true);
	    $data = array(
	        $attribute_name => array(
	            'name' => $attribute_name,
	            'value' => '',
	            'is_visible' => $attribute_sett[0],
	            'is_variation' => $attribute_sett[1],
	            'is_taxonomy' => $attribute_sett[2]
	        )
	    );
	    //First getting the Post Meta
	    $_product_attributes = get_post_meta($post_id, '_product_attributes', TRUE);
	    //Updating the Post Meta
	    $_post_meta = update_post_meta($post_id, '_product_attributes', array_merge( is_array( $_product_attributes ) ? $_product_attributes : array(), $data));		
		return $_post_meta;
	}

	/**
	* Adds paper attribute
	*/
	public static function pa_paper(){
		$name = 'paper';
		$label = \__('Paper', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('couted-70g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 						'slug' => 'coated-70g' ) );
		\wp_insert_term( \__('couted-80g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 						'slug' => 'coated-80g' ) );
		\wp_insert_term( \__('couted-90g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 						'slug' => 'coated-90g' ) );
		\wp_insert_term( \__('couted-115g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 					'slug' => 'coated-115g' ) );
		\wp_insert_term( \__('couted-135g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 					'slug' => 'coated-135g' ) );
		\wp_insert_term( \__('couted-170g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 					'slug' => 'coated-170g' ) );
		\wp_insert_term( \__('couted-250g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 					'slug' => 'coated-250g' ) );
		\wp_insert_term( \__('couted-300g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 300g', 'gcalc'), 					'slug' => 'coated-300g' ) );
		\wp_insert_term( \__('couted-350g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 					'slug' => 'coated-350g' ) );
		\wp_insert_term( \__('uncouted-70g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-70g' ) );
		\wp_insert_term( \__('uncouted-80g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-80g' ) );
		\wp_insert_term( \__('uncouted-90g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-90g' ) );
		\wp_insert_term( \__('uncouted-100g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-100g' ) );
		\wp_insert_term( \__('uncouted-120g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-120g' ) );
		\wp_insert_term( \__('uncouted-150g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-150g' ) );
		\wp_insert_term( \__('eccobook_cream_16-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 		'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( \__('eccobook_cream_16-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 		'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( \__('eccobook_cream_16-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 		'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( \__('eccobook_cream_20-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 		'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( \__('eccobook_cream_20-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 		'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( \__('eccobook_cream_20-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 		'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( \__('ibook_white_16-60g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 			'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( \__('ibook_white_16-70g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 			'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-60g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 			'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( \__('ibook_cream_20-70g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 			'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 			'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( \__('munken_cream_18-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 		'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( \__('munken_cream_18-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 		'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( \__('munken_cream_15-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 		'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( \__('munken_cream_15-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 		'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( \__('munken_white_18-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 		'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( \__('munken_white_18-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 		'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( \__('munken_white_15-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 		'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( \__('munken_white_15-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 		'slug' => 'munken_white_15-90g' ) );				
					
	}

	/**
	* Adds paper attribute
	*/
	public static function pa_cover_endpaper_paper(){
		$name = 'cover_endpaper';
		$label = \__('Endpaper', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('couted-70g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 						'slug' => 'coated-70g' ) );
		\wp_insert_term( \__('couted-80g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 						'slug' => 'coated-80g' ) );
		\wp_insert_term( \__('couted-90g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 						'slug' => 'coated-90g' ) );
		\wp_insert_term( \__('couted-115g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 					'slug' => 'coated-115g' ) );
		\wp_insert_term( \__('couted-135g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 					'slug' => 'coated-135g' ) );
		\wp_insert_term( \__('couted-170g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 					'slug' => 'coated-170g' ) );
		\wp_insert_term( \__('couted-250g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 					'slug' => 'coated-250g' ) );
		\wp_insert_term( \__('couted-300g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 300g', 'gcalc'), 					'slug' => 'coated-300g' ) );
		\wp_insert_term( \__('couted-350g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 					'slug' => 'coated-350g' ) );
		\wp_insert_term( \__('uncouted-70g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-70g' ) );
		\wp_insert_term( \__('uncouted-80g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-80g' ) );
		\wp_insert_term( \__('uncouted-90g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-90g' ) );
		\wp_insert_term( \__('uncouted-100g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-100g' ) );
		\wp_insert_term( \__('uncouted-120g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-120g' ) );
		\wp_insert_term( \__('uncouted-150g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 					'slug' => 'uncoated-150g' ) );
		\wp_insert_term( \__('eccobook_cream_16-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 		'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( \__('eccobook_cream_16-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 		'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( \__('eccobook_cream_16-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 		'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( \__('eccobook_cream_20-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 		'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( \__('eccobook_cream_20-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 		'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( \__('eccobook_cream_20-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 		'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( \__('ibook_white_16-60g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 			'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( \__('ibook_white_16-70g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 			'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-60g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 			'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( \__('ibook_cream_20-70g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 			'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 			'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( \__('munken_cream_18-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 		'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( \__('munken_cream_18-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 		'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( \__('munken_cream_15-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 		'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( \__('munken_cream_15-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 		'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( \__('munken_white_18-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 		'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( \__('munken_white_18-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 		'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( \__('munken_white_15-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 		'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( \__('munken_white_15-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 		'slug' => 'munken_white_15-90g' ) );				
					
	}

	/**pa_cover_board_thickness
	* Adds paper attribute
	*/
	public static function pa_cover_paper(){
		$name = 'cover_paper';
		$label = \__('Cover paper', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('gc1-230g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Arktika 230g', 'gcalc'), 				'slug' => 'gc1-230g' ) );
		\wp_insert_term( \__('gc1-250g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Arktika 230g', 'gcalc'), 				'slug' => 'gc1-250g' ) );
		\wp_insert_term( \__('gc2-230g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Alaska 230g', 'gcalc'), 				'slug' => 'gc2-230g' ) );
		\wp_insert_term( \__('gc2-250g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Alaska 230g', 'gcalc'), 				'slug' => 'gc2-250g' ) );

		\wp_insert_term( \__('couted-115g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 'slug' => 'coated-115g' ) );
		\wp_insert_term( \__('couted-135g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 'slug' => 'coated-135g' ) );
		\wp_insert_term( \__('couted-170g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 'slug' => 'coated-170g' ) );
		\wp_insert_term( \__('couted-250g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 'slug' => 'coated-250g' ) );
		\wp_insert_term( \__('couted-300g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 300g', 'gcalc'), 'slug' => 'coated-300g' ) );
		\wp_insert_term( \__('couted-350g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 'slug' => 'coated-350g' ) );
						
	}

	/**pa_cover_board_thickness
	* Adds paper attribute
	*/
	public static function pa_groupwrap(){
		$name = 'orientation';
		$label = \__('Orientation', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No wrap', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Album', 'gcalc'), 'slug' => 'album' ) );
						
		\wp_insert_term( \__('Single wrap', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Doublet wrap', 'gcalc'), 'slug' => '1' ) );
		\wp_insert_term( \__('Doublet wrap', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Doublet wrap', 'gcalc'), 'slug' => '2' ) );
		\wp_insert_term( \__('Triplet wrap', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Triplet wrap', 'gcalc'), 'slug' => '3' ) );
		\wp_insert_term( \__('4 pieces wrap', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('4 pieces wrap', 'gcalc'), 'slug' => '4' ) );
		\wp_insert_term( \__('5 pieces wrap', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('5 pieces wrap', 'gcalc'), 'slug' => '5' ) );
		
	}


	/**pa_cover_board_thickness
	* Adds paper attribute
	*/
	public static function pa_orientation(){
		$name = 'orientation';
		$label = \__('Orientation', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Album', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Album', 'gcalc'), 'slug' => 'album' ) );
		\wp_insert_term( \__('Portrait', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Portrait', 'gcalc'), 'slug' => 'portrait' ) );
						
	}

	/**
	* Adds paper attribute
	*/
	public static function pa_cover_board_thickness(){
		$name = 'cover_board_thickness';
		$label = \__('Cover board thickness', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		
		\wp_insert_term( \__('Board 2.0mm', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Board 2.0mm', 'gcalc'), 'slug' => 'board-20' ) );
		\wp_insert_term( \__('Board 2.5mm', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Board 2.5mm', 'gcalc'), 'slug' => 'board-25' ) );		
						
	}

	/**
	* Adds paper attribute
	*/
	public static function pa_folding(){
		$name = 'folding';
		$label = \__('Folding', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/		
		\wp_insert_term( \__('No fold', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('No folding', 'gcalc'), 	'slug' => 'no-fold' ) );
		\wp_insert_term( \__('Half fold', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Half fold', 'gcalc'), 	'slug' => 'half-fold' ) );
		\wp_insert_term( \__('Tri fold', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Tri fold', 'gcalc'), 	'slug' => 'tri-fold' ) );						
		\wp_insert_term( \__('Z fold', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Z fold', 'gcalc'), 		'slug' => 'z-fold' ) );						
	}


/**
	* Adds paper attribute
	*/
	public static function pa_folding_dir(){
		$name = 'folding_dir';
		$label = \__('Folding direction', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/		
		\wp_insert_term( \__('Horizontal', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Horizontal', 'gcalc'), 	'slug' => 'folding-dir-h' ) );
		\wp_insert_term( \__('Vertical', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Vertical', 'gcalc'), 	'slug' => 'folding-dir-v' ) );						
		
	}


		/**
	* Adds paper attribute
	*/
	public static function pa_cover_cloth_covering_paper(){
		$name = 'cover_cloth_covering_paper';
		$label = \__('Cover cloth covering paper', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/		
		\wp_insert_term( \__('couted-170g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 'slug' => 'coated-170g' ) );						
	}


	/**
	* Adds paper attribute
	*/
	public static function pa_cover_dust_jacket_paper(){
		$name = 'cover_dust_jacket_paper';
		$label = \__('Dust jacket paper', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		
		\wp_insert_term( \__('couted-170g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 'slug' => 'coated-170g' ) );						
	}

	/**
	* Adds paper for color print attribute
	*/
	public static function pa_color_paper(){
		$name = 'color_paper';
		$label = \__('Paper color', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/



		\wp_insert_term( \__('couted-70g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 					'slug' => 'coated-70g' ) );
		\wp_insert_term( \__('couted-80g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 					'slug' => 'coated-80g' ) );
		\wp_insert_term( \__('couted-90g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 					'slug' => 'coated-90g' ) );
		\wp_insert_term( \__('couted-115g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 				'slug' => 'coated-115g' ) );
		\wp_insert_term( \__('couted-135g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 				'slug' => 'coated-135g' ) );
		\wp_insert_term( \__('couted-170g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 				'slug' => 'coated-170g' ) );
		\wp_insert_term( \__('couted-250g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 				'slug' => 'coated-250g' ) );
		\wp_insert_term( \__('couted-350g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 				'slug' => 'coated-350g' ) );
		\wp_insert_term( \__('uncouted-70g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-70g' ) );
		\wp_insert_term( \__('uncouted-80g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-80g' ) );
		\wp_insert_term( \__('uncouted-90g', 'gcalc'), 				'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-90g' ) );
		\wp_insert_term( \__('uncouted-100g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-100g' ) );
		\wp_insert_term( \__('uncouted-120g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-120g' ) );
		\wp_insert_term( \__('uncouted-150g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-150g' ) );
		\wp_insert_term( \__('eccobook_cream_16-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 	'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( \__('eccobook_cream_16-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 	'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( \__('eccobook_cream_16-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 	'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( \__('eccobook_cream_20-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 	'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( \__('eccobook_cream_20-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 	'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( \__('eccobook_cream_20-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 	'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( \__('ibook_white_16-60g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 		'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( \__('ibook_white_16-70g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 		'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-60g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 		'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( \__('ibook_cream_20-70g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 		'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 		'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( \__('munken_cream_18-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 	'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( \__('munken_cream_18-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 	'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( \__('munken_cream_15-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 	'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( \__('munken_cream_15-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 	'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( \__('munken_white_18-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 	'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( \__('munken_white_18-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 	'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( \__('munken_white_15-80g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 	'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( \__('munken_white_15-90g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 	'slug' => 'munken_white_15-90g' ) );				
	}

	/**
	* Adds paper for black print attribute
	*/
	public static function pa_bw_paper(){
		$name = 'bw_paper';
		$label = \__('Paper mono', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('couted-70g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 					'slug' => 'coated-70g' ) );
		\wp_insert_term( \__('couted-80g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 					'slug' => 'coated-80g' ) );
		\wp_insert_term( \__('couted-90g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 					'slug' => 'coated-90g' ) );
		\wp_insert_term( \__('couted-115g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 				'slug' => 'coated-115g' ) );
		\wp_insert_term( \__('couted-135g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 				'slug' => 'coated-135g' ) );
		\wp_insert_term( \__('couted-170g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 				'slug' => 'coated-170g' ) );
		\wp_insert_term( \__('couted-250g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 				'slug' => 'coated-250g' ) );
		\wp_insert_term( \__('couted-350g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 				'slug' => 'coated-350g' ) );
		\wp_insert_term( \__('uncouted-70g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-70g' ) );
		\wp_insert_term( \__('uncouted-80g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-80g' ) );
		\wp_insert_term( \__('uncouted-90g', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-90g' ) );
		\wp_insert_term( \__('uncouted-100g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-100g' ) );
		\wp_insert_term( \__('uncouted-120g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-120g' ) );
		\wp_insert_term( \__('uncouted-150g', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 				'slug' => 'uncoated-150g' ) );
		\wp_insert_term( \__('eccobook_cream_16-60g', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 	'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( \__('eccobook_cream_16-70g', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 	'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( \__('eccobook_cream_16-80g', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 	'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( \__('eccobook_cream_20-60g', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 	'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( \__('eccobook_cream_20-70g', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 	'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( \__('eccobook_cream_20-80g', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 	'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( \__('ibook_white_16-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 		'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( \__('ibook_white_16-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 		'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-60g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 		'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( \__('ibook_cream_20-70g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 		'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( \__('ibook_cream_20-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 		'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( \__('munken_cream_18-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 	'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( \__('munken_cream_18-90g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 	'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( \__('munken_cream_15-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 	'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( \__('munken_cream_15-90g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 	'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( \__('munken_white_18-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 	'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( \__('munken_white_18-90g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 	'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( \__('munken_white_15-80g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 	'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( \__('munken_white_15-90g', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 	'slug' => 'munken_white_15-90g' ) );				
	}

	/**
	* Adds volume attribute
	*/
	public static function pa_quantity(){
		$name = 'quantity';
		$label = \__('Quantity', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Custom', 'gcalc'),	'pa_' . $name, array( 'description' => \__('Custom volume', 'gcalc'), 	'slug' => 'custom-value' ) );
		\wp_insert_term( \__('1 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('1 pcs.', 'gcalc'), 			'slug' => '1' ) );
		\wp_insert_term( \__('2 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('2 pcs.', 'gcalc'), 			'slug' => '2' ) );
		\wp_insert_term( \__('3 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('3 pcs.', 'gcalc'), 			'slug' => '3' ) );
		\wp_insert_term( \__('4 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('4 pcs.', 'gcalc'), 			'slug' => '4' ) );
		\wp_insert_term( \__('5 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('5 pcs.', 'gcalc'), 			'slug' => '5' ) );
		\wp_insert_term( \__('6 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('6 pcs.', 'gcalc'), 			'slug' => '6' ) );
		\wp_insert_term( \__('7 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('7 pcs.', 'gcalc'), 			'slug' => '7' ) );
		\wp_insert_term( \__('8 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('8 pcs.', 'gcalc'), 			'slug' => '8' ) );
		\wp_insert_term( \__('9 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('9 pcs.', 'gcalc'), 			'slug' => '9' ) );
		\wp_insert_term( \__('10 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('10 pcs.', 'gcalc'), 		'slug' => '10' ) );
		\wp_insert_term( \__('20 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('20 pcs.', 'gcalc'), 		'slug' => '20' ) );
		\wp_insert_term( \__('25 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('25 pcs.', 'gcalc'), 		'slug' => '25' ) );
		\wp_insert_term( \__('30 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('30 pcs.', 'gcalc'), 		'slug' => '30' ) );
		\wp_insert_term( \__('40 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('40 pcs.', 'gcalc'), 		'slug' => '40' ) );
		\wp_insert_term( \__('50 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('50 pcs.', 'gcalc'), 		'slug' => '50' ) );
		\wp_insert_term( \__('60 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('60 pcs.', 'gcalc'), 		'slug' => '60' ) );
		\wp_insert_term( \__('70 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('70 pcs.', 'gcalc'), 		'slug' => '70' ) );
		\wp_insert_term( \__('75 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('75 pcs.', 'gcalc'), 		'slug' => '75' ) );
		\wp_insert_term( \__('80 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('80 pcs.', 'gcalc'), 		'slug' => '80' ) );
		\wp_insert_term( \__('90 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('90 pcs.', 'gcalc'), 		'slug' => '90' ) );
		\wp_insert_term( \__('100 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('100 pcs.', 'gcalc'), 		'slug' => '100' ) );
		\wp_insert_term( \__('200 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('200 pcs.', 'gcalc'), 		'slug' => '200' ) );
		\wp_insert_term( \__('250 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('250 pcs.', 'gcalc'), 		'slug' => '250' ) );
		\wp_insert_term( \__('300 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('300 pcs.', 'gcalc'), 		'slug' => '300' ) );
		\wp_insert_term( \__('400 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('400 pcs.', 'gcalc'), 		'slug' => '400' ) );
		\wp_insert_term( \__('500 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('500 pcs.', 'gcalc'), 		'slug' => '500' ) );
		\wp_insert_term( \__('600 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('600 pcs.', 'gcalc'), 		'slug' => '600' ) );
		\wp_insert_term( \__('700 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('700 pcs.', 'gcalc'), 		'slug' => '700' ) );
		\wp_insert_term( \__('800 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('800 pcs.', 'gcalc'), 		'slug' => '800' ) );
		\wp_insert_term( \__('900 pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('900 pcs.', 'gcalc'), 		'slug' => '900' ) );
		\wp_insert_term( \__('1000 pcs.', 'gcalc'), 'pa_' . $name, array( 'description' => \__('1000 pcs.', 'gcalc'), 		'slug' => '1000' ) );
		\wp_insert_term( \__('1500 pcs.', 'gcalc'), 'pa_' . $name, array( 'description' => \__('1500 pcs.', 'gcalc'), 		'slug' => '1500' ) );
		\wp_insert_term( \__('2000 pcs.', 'gcalc'), 'pa_' . $name, array( 'description' => \__('2000 pcs.', 'gcalc'), 		'slug' => '2000' ) );
		\wp_insert_term( \__('2500 pcs.', 'gcalc'), 'pa_' . $name, array( 'description' => \__('2500 pcs.', 'gcalc'), 		'slug' => '2500' ) );

	}

	/**
	* Adds color_pages_numbers attribute
	*/
	public static function pa_color_pages_numbers(){
		$name = 'color_pages_numbers';
		$label = \__('Color pages nymbers', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom value', 'gcalc'), 'slug' => 'custom-value' ) );
		
	}

	/**
	* Adds title attribute
	*/
	public static function pa_title(){
		$name = 'title';
		$label = \__('Color pages nymbers', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom value', 'gcalc'), 'slug' => 'custom-value' ) );
		
	}

	/**
	* Adds title attribute
	*/
	public static function pa_book_number(){
		$name = 'book_number';
		$label = \__('Color pages nymbers', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('No book number', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom value', 'gcalc'), 'slug' => 'no-number' ) );
		\wp_insert_term( \__('ISBN', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('ISBN', 'gcalc'), 'slug' => 'isbn' ) );
		\wp_insert_term( \__('ISSN', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('ISSN', 'gcalc'), 'slug' => 'issn' ) );
		
	}

	/**
	* Adds title attribute
	*/
	public static function pa_comments(){
		$name = 'comments';
		$label = \__('Comments', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom value', 'gcalc'), 'slug' => 'custom-value' ) );
		
	}


















	/**
	* Adds color_pages_numbers attribute
	*/
	public static function pa_pieces_per_carton(){
		$name = 'pieces_per_carton';
		$label = \__('Pieces per carton', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		
		$_array = array( 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 36, 40, 44, 48 );
		foreach ($_array as $value) {
			\wp_insert_term( \__($value . ' pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__($value . ' pcs.', 'gcalc'), 'slug' => ''.$value ) );
		}
		
	}

	/**
	* Adds color_pages_numbers attribute
	*/
	public static function pa_drilling_holes(){
		$name = 'drilling_holes';
		$label = \__('Holes number', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('No holes', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('No holes', 'gcalc'), 'slug' => '0' ) );
		\wp_insert_term( \__('2 holes', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('No holes', 'gcalc'), 'slug' => '2' ) );
		\wp_insert_term( \__('4 holes', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('No holes', 'gcalc'), 'slug' => '4' ) );
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('No holes', 'gcalc'), 'slug' => 'custom-value' ) );
		
	}

	/**
	* Adds color_pages_numbers attribute
	*/
	public static function pa_holes_dia(){
		$name = 'holes_dia';
		$label = \__('Holes diameter', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('4mm', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('4mm', 'gcalc'), 'slug' => '4' ) );
		\wp_insert_term( \__('5mm', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('5mm', 'gcalc'), 'slug' => '5' ) );
		\wp_insert_term( \__('6mm', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('6mm', 'gcalc'), 'slug' => '6' ) );
		\wp_insert_term( \__('8mm', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('8mm', 'gcalc'), 'slug' => '8' ) );
		
	}

	/**
	* Adds color_pages_numbers attribute
	*/
	public static function pa_holes_pos(){
		$name = 'holes_pos';
		$label = \__('Holes position', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Long side center', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('No holes', 'gcalc'), 'slug' => 'long-center' ) );
		\wp_insert_term( \__('Short side center', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('No holes', 'gcalc'), 'slug' => 'short-center' ) );
		
	}


	/**
	* Adds volume attribute
	*/
	public static function pa_bw_pages(){
		$name = 'bw_pages';
		$label = \__('BW block pages', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom value', 'gcalc'), 'slug' => 'custom-value' ) );
		\wp_insert_term( \__('Ream', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ream (500 sheets)', 'gcalc'), 'slug' => '500' ) );
		$pages_array = array( 25, 50, 75, 100, 150, 200 );
		foreach ($pages_array as $value) {
			\wp_insert_term( \__($value . ' pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__($value . ' pcs.', 'gcalc'), 'slug' => ''.$value ) );
		}
	}

	/**
	* Adds volume attribute
	*/
	public static function pa_color_pages(){
		$name = 'color_pages';
		$label = \__('Color block pages', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		

		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom value', 'gcalc'), 'slug' => 'custom-value' ) );
		\wp_insert_term( \__('Ream', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Ream (500 sheets)', 'gcalc'), 'slug' => '500' ) );
		$pages_array = array( 25, 50, 75, 100, 150, 200 );
		foreach ($pages_array as $value) {
			\wp_insert_term( \__($value . ' pcs.', 'gcalc'), 	'pa_' . $name, array( 'description' => \__($value . ' pcs.', 'gcalc'), 'slug' => ''.$value ) );
		}
	}

	/**
	* Adds volume attribute
	*/
	public static function pa_color_stack(){
		$name = 'color_stack';
		$label = \__('Color stacking', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding volumes
		*/
		\wp_insert_term( \__('Stack', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Stacked in one single block', 'gcalc'), 'slug' => 'stack' ) );
		\wp_insert_term( \__('Shuffled', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Shuffled between bw block', 'gcalc'), 	'slug' => 'shuffled' ) );
		
	}

	/**
	* Adds format attribute
	*/
	public static function pa_format(){
		$name = 'format';
		$label = \__('Format', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( 'Custom', 	'pa_' . $name, array( 'description' => \__('Custom format', 'gcalc'), 'slug' => 'custom-value' ) );
		\wp_insert_term( '85x55', 	'pa_' . $name, array( 'description' => \__('Business card 85x55mm', 'gcalc'), 'slug' => '85x55' ) );
		\wp_insert_term( '170x55', 	'pa_' . $name, array( 'description' => \__('Business card folded to 85x55mm', 'gcalc'), 'slug' => '170x55' ) );
		\wp_insert_term( '90x50', 	'pa_' . $name, array( 'description' => \__('Business card 90x50mm', 'gcalc'), 'slug' => '90x50' ) );
		\wp_insert_term( '180x50', 	'pa_' . $name, array( 'description' => \__('Business card folded to 90x50mm', 'gcalc'), 'slug' => '180x50' ) );
		\wp_insert_term( '105x148', 'pa_' . $name, array( 'description' => \__('A6 (105x148 mm)', 'gcalc'), 'slug' => '105x148' ) );
		\wp_insert_term( '148x210', 'pa_' . $name, array( 'description' => \__('A5 (148x210 mm)', 'gcalc'), 'slug' => '148x210' ) );
		\wp_insert_term( '210x297', 'pa_' . $name, array( 'description' => \__('A4 (210x297 mm)', 'gcalc'), 'slug' => '210x297' ) );
		\wp_insert_term( '297x420', 'pa_' . $name, array( 'description' => \__('A3 (297x420 mm)', 'gcalc'), 'slug' => '297x420' ) );
		\wp_insert_term( '125x176', 'pa_' . $name, array( 'description' => \__('B6 (125x176 mm)', 'gcalc'), 'slug' => '125x176' ) );
		\wp_insert_term( '176x250', 'pa_' . $name, array( 'description' => \__('B5 (176x250 mm)', 'gcalc'), 'slug' => '176x250' ) );
		\wp_insert_term( '250x350', 'pa_' . $name, array( 'description' => \__('B4 (250x350 mm)', 'gcalc'), 'slug' => '250x350' ) );

		\wp_insert_term( '420x594', 'pa_' . $name, array( 'description' => \__('A2 (420x594 mm)', 'gcalc'), 'slug' => '420x594' ) );
		\wp_insert_term( '594x841', 'pa_' . $name, array( 'description' => \__('A1 (594x841 mm)', 'gcalc'), 'slug' => '594x841' ) );
		\wp_insert_term( '841x1189','pa_' . $name, array( 'description' => \__('A0 (841x1189 mm)', 'gcalc'), 'slug' => '841x1189' ) );

		\wp_insert_term( '350x500', 'pa_' . $name, array( 'description' => \__('B3 (350x500 mm)', 'gcalc'), 'slug' => '350x500' ) );
		\wp_insert_term( '500x700', 'pa_' . $name, array( 'description' => \__('B2 (500x700 mm)', 'gcalc'), 'slug' => '500x700' ) );
		\wp_insert_term( '700x1000','pa_' . $name, array( 'description' => \__('B1 (700x1000 mm)', 'gcalc'), 'slug' => '700x1000' ) );
		\wp_insert_term( '1000x1400','pa_' . $name, array( 'description' => \__('B0 (1000x1400 mm)', 'gcalc'), 'slug' => '1000x1400' ) );

	}


	/**
	* Adds cover format attribute
	*/
	public static function pa_cover_format(){
		$name = 'cover_format';
		$label = \__('Cover format', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( 'Custom', 	'pa_' . $name, array( 'description' => \__('Custom cover format', 'gcalc'), 'slug' => 'custom-value' ) );					
	}

	/**
	* Adds cover format attribute
	*/
	public static function pa_bw_format(){
		$name = 'bw_format';
		$label = \__('BW block format', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( 'Custom', 	'pa_' . $name, array( 'description' => \__('Custom BW block format', 'gcalc'), 'slug' => 'custom-value' ) );					
	}

	/**
	* Adds color block format attribute
	*/
	public static function pa_color_format(){
		$name = 'color_format';
		$label = \__('Color block format', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( 'Custom', 	'pa_' . $name, array( 'description' => \__('Custom color block format', 'gcalc'), 'slug' => 'custom-value' ) );					
	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_finish(){
		$name = 'finish';
		$label = \__('Finish', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No finish', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'no-finish' ) );
		\wp_insert_term( \__('Gloss 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'gloss-1x0' ) );
		\wp_insert_term( \__('Gloss 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Gloss finish 2 sides  ', 'gcalc'), 		'slug' => 'gloss-1x1' ) );
		\wp_insert_term( \__('matt 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 1 side', 'gcalc'), 			'slug' => 'matt-1x0' ) );
		\wp_insert_term( \__('matt 2 sides', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 2 sides', 'gcalc'), 		'slug' => 'matt-1x1' ) );
		\wp_insert_term( \__('Soft touch 1 side', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Soft touch finish 1 side', 'gcalc'), 	'slug' => 'soft-touch-1x0' ) );
		\wp_insert_term( \__('Soft touch 2 sides', 'gcalc'),'pa_' . $name, array( 'description' => \__('Soft touch finish 2 sides', 'gcalc'), 	'slug' => 'soft-touch-1x1' ) );
	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_cover_cloth_covering_finish(){
		$name = 'cover_cloth_covering_finish';
		$label = \__('Cover cloth covering finish', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No finish', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'no-finish' ) );
		\wp_insert_term( \__('Gloss 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'gloss-1x0' ) );
		\wp_insert_term( \__('Gloss 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Gloss finish 2 sides  ', 'gcalc'), 		'slug' => 'gloss-1x1' ) );
		\wp_insert_term( \__('matt 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 1 side', 'gcalc'), 			'slug' => 'matt-1x0' ) );
		\wp_insert_term( \__('matt 2 sides', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 2 sides', 'gcalc'), 		'slug' => 'matt-1x1' ) );
		\wp_insert_term( \__('Soft touch 1 side', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Soft touch finish 1 side', 'gcalc'), 	'slug' => 'soft-touch-1x0' ) );
		\wp_insert_term( \__('Soft touch 2 sides', 'gcalc'),'pa_' . $name, array( 'description' => \__('Soft touch finish 2 sides', 'gcalc'), 	'slug' => 'soft-touch-1x1' ) );
	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_cover_dust_jacket_finish(){
		$name = 'pa_cover_dust_jacket_finish';
		$label = \__('Cover dust jacket finish', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No finish', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => '0x0' ) );
		\wp_insert_term( \__('Gloss 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'gloss-1x0' ) );
		\wp_insert_term( \__('Gloss 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Gloss finish 2 sides  ', 'gcalc'), 		'slug' => 'gloss-1x1' ) );
		\wp_insert_term( \__('matt 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 1 side', 'gcalc'), 			'slug' => 'matt-1x0' ) );
		\wp_insert_term( \__('matt 2 sides', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 2 sides', 'gcalc'), 		'slug' => 'matt-1x1' ) );
		\wp_insert_term( \__('Soft touch 1 side', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Soft touch finish 1 side', 'gcalc'), 	'slug' => 'soft-touch-1x0' ) );
		\wp_insert_term( \__('Soft touch 2 sides', 'gcalc'),'pa_' . $name, array( 'description' => \__('Soft touch finish 2 sides', 'gcalc'), 	'slug' => 'soft-touch-1x1' ) );
	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_spot_uv(){
		$name = 'spot_uv';
		$label = \__('Spot UV', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No spot UV', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('No spot UV', 'gcalc'), 		'slug' => '0x0' ) );
		\wp_insert_term( \__('Spot UV 1 side', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 1 side', 'gcalc'), 	'slug' => '1x0' ) );
		\wp_insert_term( \__('Spot UV 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 2 sides', 'gcalc'), 'slug' => '1x1' ) );

	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_print(){
		$name = 'print';
		$label = \__('Print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Color 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color both sides', 'gcalc'), 	'slug' => '4x4' ) );
		\wp_insert_term( \__('Color 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 	'slug' => '4x0' ) );
		\wp_insert_term( \__('Black 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Black both sides', 'gcalc'), 	'slug' => '1x1' ) );
		\wp_insert_term( \__('Black 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Black single side', 'gcalc'), 	'slug' => '1x1' ) );
	}

	/**
	* Adds cover_type attribute
	*/
	public static function pa_cover_type(){
		$name = 'cover_type';
		$label = \__('Cover binding type', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding binding types
		*/
		\wp_insert_term( \__('Perfect binding', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Perfect binding', 'gcalc'), 'slug' => 'perfect_binding' ) );
		\wp_insert_term( \__('Saddle stitch', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Saddle stitch', 'gcalc'), 	'slug' => 'saddle_stitch' ) );
		\wp_insert_term( \__('Spiral binding', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spiral binding', 'gcalc'), 	'slug' => 'spiral_binding' ) );
		\wp_insert_term( \__('Section sewn', 'gcalc'),	 	'pa_' . $name, array( 'description' => \__('Section sewn', 'gcalc'), 	'slug' => 'section_sewn' ) );
		\wp_insert_term( \__('Hard cover', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Hard cover', 'gcalc'), 		'slug' => 'hard' ) );

	}

	/**
	* Adds cover finish attribute
	*/
	public static function pa_cover_finish(){
		$name = 'cover_finish';
		$label = \__('Cover finish', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No finish', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'no-finish' ) );
		\wp_insert_term( \__('Gloss 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Gloss finish 1 side', 'gcalc'), 		'slug' => 'gloss-1x0' ) );
		\wp_insert_term( \__('Gloss 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Gloss finish 2 sides  ', 'gcalc'), 		'slug' => 'gloss-1x1' ) );
		\wp_insert_term( \__('matt 1 side', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 1 side', 'gcalc'), 			'slug' => 'matt-1x0' ) );
		\wp_insert_term( \__('matt 2 sides', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('Matt finish 2 sides', 'gcalc'), 		'slug' => 'matt-1x1' ) );
		\wp_insert_term( \__('Soft touch 1 side', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Soft touch finish 1 side', 'gcalc'), 	'slug' => 'soft-touch-1x0' ) );
		\wp_insert_term( \__('Soft touch 2 sides', 'gcalc'),'pa_' . $name, array( 'description' => \__('Soft touch finish 2 sides', 'gcalc'), 	'slug' => 'soft-touch-1x1' ) );

	}

	/**
	* Adds cover spot uv attribute
	*/
	public static function pa_cover_spot_uv(){
		$name = 'cover_spot_uv';
		$label = \__('Cover spot UV', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No spot UV', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('No spot UV', 'gcalc'), 		'slug' => '0x0' ) );
		\wp_insert_term( \__('Spot UV 1 side', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 1 side', 'gcalc'), 	'slug' => '1x0' ) );
		\wp_insert_term( \__('Spot UV 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 2 sides', 'gcalc'), 'slug' => '1x1' ) );
		
	}

	/**
	* Adds cover cloth covering spot uv attribute
	*/
	public static function pa_cover_cloth_covering_spot_uv(){
		$name = 'cover_cloth_covering_spot_uv';
		$label = \__('Cover cloth covering spot UV', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No spot UV', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('No spot UV', 'gcalc'), 		'slug' => '0x0' ) );
		\wp_insert_term( \__('Spot UV 1 side', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 1 side', 'gcalc'), 	'slug' => '1x0' ) );
		\wp_insert_term( \__('Spot UV 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 2 sides', 'gcalc'), 'slug' => '1x1' ) );
		
	}

	/**
	* Adds cover dust jacket spot uv attribute
	*/
	public static function pa_cover_dust_jacket_spot_uv(){
		$name = 'cover_dust_jacket_spot_uv';
		$label = \__('Cover dust jacket spot UV', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No spot UV', 'gcalc'), 		'pa_' . $name, array( 'description' => \__('No spot UV', 'gcalc'), 		'slug' => '0x0' ) );
		\wp_insert_term( \__('Spot UV 1 side', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 1 side', 'gcalc'), 	'slug' => '1x0' ) );
		\wp_insert_term( \__('Spot UV 2 sides', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Spot UV 2 sides', 'gcalc'), 'slug' => '1x1' ) );
		
	}

	/**
	* Adds cover flaps attribute
	*/
	public static function pa_cover_flaps(){
		$name = 'cover_flaps';
		$label = \__('Cover flaps', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No flaps', 'gcalc'), 			'pa_' . $name, array( 'description' => \__('No flaps', 'gcalc'), 			'slug' => 'false' ) );
		\wp_insert_term( \__('Cover with flaps', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Cover with flaps', 'gcalc'), 	'slug' => 'true' ) );
		
	}

	/**
	* Adds cover flaps attribute
	*/
	public static function pa_cover_ribbon(){
		$name = 'cover_ribbon';
		$label = \__('Cover ribbon', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('No ribbon', 'gcalc'), 'pa_' . $name, array( 'description' => \__('No ribbon', 'gcalc'), 			'slug' => 'ribbon-0' ) );
		\wp_insert_term( \__('Red', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Red ribbon', 'gcalc'), 			'slug' => 'ribbon-red' ) );
		\wp_insert_term( \__('Green', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Green ribbon', 'gcalc'), 	'slug' => 'ribbon-green' ) );
		\wp_insert_term( \__('Orange', 'gcalc'), 'pa_' . $name, array( 'description' => \__('Orange ribbon', 'gcalc'), 		'slug' => 'ribbon-orange' ) );
		\wp_insert_term( \__('Yellow', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Yellow ribbon', 'gcalc'), 	'slug' => 'ribbon-yellow' ) );
		
	}


	/**
	* Adds cover ribbon width attribute
	*/
	public static function pa_cover_ribbon_width(){
		$name = 'cover_ribbon_width';
		$label = \__('Cover ribbon width', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Ribbon width n/a', 'gcalc'), 'pa_' . $name, array( 'description' => \__('No ribbon', 'gcalc'), 		'slug' => 'ribbon-0' ) );
		\wp_insert_term( \__('3mm', 'gcalc'), 'pa_' . $name, array( 'description' => \__('3mm', 'gcalc'), 		'slug' => 'ribbon-3' ) );
		\wp_insert_term( \__('6mm', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('6mm', 'gcalc'), 	'slug' => 'ribbon-6' ) );
		
	}




	/**
	* Adds format attribute
	*/
	public static function pa_cover_left_flap_width(){
		$name = 'cover_left_flap_width';
		$label = \__('Cover left flap width', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding values
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom flap width', 'gcalc'), 'slug' => 'custom-value' ) );
		
	}

	/**
	* Adds format attribute
	*/
	public static function pa_cover_right_flap_width(){
		$name = 'cover_right_flap_width';
		$label = \__('Cover right flap width', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding values
		*/
		\wp_insert_term( \__('Custom', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Custom flap width', 'gcalc'), 'slug' => 'custom-value' ) );
		
	}

	/**
	* Adds cover print attribute
	*/
	public static function pa_cover_print(){
		$name = 'cover_print';
		$label = \__('Cover print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Color 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color both sides', 'gcalc'), 'slug' => '4x4' ) );
		\wp_insert_term( \__('Color 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 'slug' => '4x0' ) );
		\wp_insert_term( \__('Black 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Black both sides', 'gcalc'), 'slug' => '1x1' ) );
		\wp_insert_term( \__('Black 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Black single side', 'gcalc'), 'slug' => '1x1' ) );
	}

	/**
	* Adds cover_cloth_covering_print print attribute
	*/
	public static function pa_cover_cloth_covering_print(){
		$name = 'cover_cloth_covering_print';
		$label = \__('Cover cloth covering print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		
		\wp_insert_term( \__('Color 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 'slug' => '4x0' ) );		
	}


	/**
	* Adds cover dust jacket print attribute
	*/
	public static function pa_cover_dust_jacket_print(){
		$name = 'cover_dust_jacket_print';
		$label = \__('Dust jacket print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Color 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color both sides', 'gcalc'), 'slug' => '4x4' ) );
		\wp_insert_term( \__('Color 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 'slug' => '4x0' ) );		
	}

		/**
	* Adds cover dust jacket print attribute
	*/
	public static function pa_cover_endpaper_print(){
		$name = 'cover_endpaper_print';
		$label = \__('Endpaper print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		
		\wp_insert_term( \__('Blank', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Blank', 'gcalc'), 'slug' => '0x0' ) );		
		\wp_insert_term( \__('Black & White 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 'slug' => '1x0' ) );		
		\wp_insert_term( \__('Color 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 'slug' => '4x0' ) );		
	}

	/**
	* Adds color print attribute
	*/
	public static function pa_color_print(){
		$name = 'color_print';
		$label = \__('Color block print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Color 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color both sides', 'gcalc'), 'slug' => '4x4' ) );
		\wp_insert_term( \__('Color 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Color single side', 'gcalc'), 'slug' => '4x0' ) );
	}

	/**
	* Adds bw print attribute
	*/
	public static function pa_bw_print(){
		$name = 'bw_print';
		$label = \__('BW block print', 'gcalc');
		\gcalc\register_woo_elements::process_add_attribute( array(
			'attribute_name' => $name,
			'attribute_label' => $label,
			'attribute_type' => 'select',
			'attribute_orderby' => 'menu_order',
			'attribute_public' => false
		) );
		
		/*
		* Adding print sizes
		*/
		\wp_insert_term( \__('Black 2-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Black both sides', 'gcalc'), 'slug' => '1x1' ) );
		\wp_insert_term( \__('Black 1-sided', 'gcalc'), 	'pa_' . $name, array( 'description' => \__('Black single side', 'gcalc'), 'slug' => '1x1' ) );
	}




	/**
	* Sprawdza czy term istnieje
	*
	* @param $label
	* @param $name
	*/
	public static function term_exists( $label, $name ){
		$term = \term_exists( $label, 'pa_' . $name );
		return $term === NULL ? false: true;
	}

	/**
	* Sprawdza
	*
	* @param array $attribute	
	*/
	public static function process_add_attribute( array $attribute ){
	    global $wpdb;

	    if ( empty($attribute['attribute_type']) ) { $attribute['attribute_type'] = 'text'; }
	    if ( empty($attribute['attribute_orderby']) ) { $attribute['attribute_orderby'] = 'menu_order'; }
	    if ( empty($attribute['attribute_public']) ) { $attribute['attribute_public'] = 0; }

	    if ( empty( $attribute['attribute_name'] ) || empty( $attribute['attribute_label'] ) ) {
	            return new \WP_Error( 'error', __( 'Please, provide an attribute name and slug.', 'woocommerce' ) );
	    } elseif ( ( $valid_attribute_name = \gcalc\register_woo_elements::valid_attribute_name( $attribute['attribute_name'] ) ) && is_wp_error( $valid_attribute_name ) ) {
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

	/**
	* Check if given name is a valid attribute name.
	*
	* @param array $attribute_name
	*/
	public static function valid_attribute_name( $attribute_name ) {
	    if ( strlen( $attribute_name ) >= 28 ) {
	            return new \WP_Error( 'error', sprintf( __( 'Slug "%s" is too long (28 characters max). Shorten it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
	    } elseif ( wc_check_if_attribute_name_is_reserved( $attribute_name ) ) {
	            return new \WP_Error( 'error', sprintf( __( 'Slug "%s" is not allowed because it is a reserved term. Change it, please.', 'woocommerce' ), sanitize_title( $attribute_name ) ) );
	    }
	    return true;
	}

	/** 
	* Adds actions to create various predefines WP and WOO elements
	*/
	function create_plugin_elements(){
		add_action( 'woocommerce_after_register_taxonomy', '\gcalc\register_woo_elements::create_product_attributes' );
		add_action( 'wp_loaded', '\gcalc\register_woo_elements::create_users' );
		add_action( 'wp_loaded', '\gcalc\register_woo_elements::create_products' );
		
	}

}


?>