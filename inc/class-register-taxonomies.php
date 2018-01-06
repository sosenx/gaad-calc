<?php 
namespace gcalc;


class register_taxonomies{



	function __construct(){	
		$this->create_plugin_taxonomies();
	}

	public static function create_product_attributes(){
		\gcalc\register_taxonomies::pa_sizemm();
		\gcalc\register_taxonomies::pa_volume();
		\gcalc\register_taxonomies::pa_paper();
		\gcalc\register_taxonomies::pa_color_paper();
		\gcalc\register_taxonomies::pa_bw_paper();
		\gcalc\register_taxonomies::pa_finish();
		\gcalc\register_taxonomies::pa_spot_uv();
	}

	/**
	* Adds paper attribute
	*/
	public static function pa_paper(){
		$name = 'paper';
		$label = \__('Paper', 'gcalc');
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
		\wp_insert_term( 'couted-70g', 	'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 'slug' => 'coated-70g' ) );
		\wp_insert_term( 'couted-80g', 	'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 'slug' => 'coated-80g' ) );
		\wp_insert_term( 'couted-90g', 	'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 'slug' => 'coated-90g' ) );
		\wp_insert_term( 'couted-115g', 	'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 'slug' => 'coated-115g' ) );
		\wp_insert_term( 'couted-135g', 	'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 'slug' => 'coated-135g' ) );
		\wp_insert_term( 'couted-170g', 	'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 'slug' => 'coated-170g' ) );
		\wp_insert_term( 'couted-250g', 	'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 'slug' => 'coated-250g' ) );
		\wp_insert_term( 'couted-350g', 	'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 'slug' => 'coated-350g' ) );
		\wp_insert_term( 'uncouted-70g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-70g' ) );
		\wp_insert_term( 'uncouted-80g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-80g' ) );
		\wp_insert_term( 'uncouted-90g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-90g' ) );
		\wp_insert_term( 'uncouted-100g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-100g' ) );
		\wp_insert_term( 'uncouted-120g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-120g' ) );
		\wp_insert_term( 'uncouted-150g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-150g' ) );
		\wp_insert_term( 'eccobook_cream_16-60g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( 'eccobook_cream_16-70g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( 'eccobook_cream_16-80g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( 'eccobook_cream_20-60g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( 'eccobook_cream_20-70g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( 'eccobook_cream_20-80g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( 'ibook_white_16-60g', 	'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( 'ibook_white_16-70g', 	'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( 'ibook_cream_20-60g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( 'ibook_cream_20-70g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( 'ibook_cream_20-80g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( 'munken_cream_18-80g', 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( 'munken_cream_18-90g', 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( 'munken_cream_15-80g', 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( 'munken_cream_15-90g', 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( 'munken_white_18-80g', 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( 'munken_white_18-90g', 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( 'munken_white_15-80g', 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( 'munken_white_15-90g', 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 'slug' => 'munken_white_15-90g' ) );				
	}

	/**
	* Adds paper for color print attribute
	*/
	public static function pa_color_paper(){	
		$name = 'color_paper';
		$label = \__('Paper color', 'gcalc');
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
		\wp_insert_term( 'couted-70g', 	'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 'slug' => 'coated-70g' ) );
		\wp_insert_term( 'couted-80g', 	'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 'slug' => 'coated-80g' ) );
		\wp_insert_term( 'couted-90g', 	'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 'slug' => 'coated-90g' ) );
		\wp_insert_term( 'couted-115g', 	'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 'slug' => 'coated-115g' ) );
		\wp_insert_term( 'couted-135g', 	'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 'slug' => 'coated-135g' ) );
		\wp_insert_term( 'couted-170g', 	'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 'slug' => 'coated-170g' ) );
		\wp_insert_term( 'couted-250g', 	'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 'slug' => 'coated-250g' ) );
		\wp_insert_term( 'couted-350g', 	'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 'slug' => 'coated-350g' ) );
		\wp_insert_term( 'uncouted-70g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-70g' ) );
		\wp_insert_term( 'uncouted-80g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-80g' ) );
		\wp_insert_term( 'uncouted-90g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-90g' ) );
		\wp_insert_term( 'uncouted-100g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-100g' ) );
		\wp_insert_term( 'uncouted-120g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-120g' ) );
		\wp_insert_term( 'uncouted-150g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-150g' ) );
		\wp_insert_term( 'eccobook_cream_16-60g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( 'eccobook_cream_16-70g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( 'eccobook_cream_16-80g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( 'eccobook_cream_20-60g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( 'eccobook_cream_20-70g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( 'eccobook_cream_20-80g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( 'ibook_white_16-60g', 	'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( 'ibook_white_16-70g', 	'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( 'ibook_cream_20-60g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( 'ibook_cream_20-70g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( 'ibook_cream_20-80g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( 'munken_cream_18-80g', 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( 'munken_cream_18-90g', 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( 'munken_cream_15-80g', 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( 'munken_cream_15-90g', 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( 'munken_white_18-80g', 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( 'munken_white_18-90g', 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( 'munken_white_15-80g', 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( 'munken_white_15-90g', 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 'slug' => 'munken_white_15-90g' ) );				
	}

	/**
	* Adds paper for black print attribute
	*/
	public static function pa_bw_paper(){
		$name = 'bw_paper';
		$label = \__('Paper mono', 'gcalc');
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
		\wp_insert_term( 'couted-70g', 	'pa_' . $name, array( 'description' => \__('Coated 70g', 'gcalc'), 'slug' => 'coated-70g' ) );
		\wp_insert_term( 'couted-80g', 	'pa_' . $name, array( 'description' => \__('Coated 80g', 'gcalc'), 'slug' => 'coated-80g' ) );
		\wp_insert_term( 'couted-90g', 	'pa_' . $name, array( 'description' => \__('Coated 90g', 'gcalc'), 'slug' => 'coated-90g' ) );
		\wp_insert_term( 'couted-115g', 	'pa_' . $name, array( 'description' => \__('Coated 115g', 'gcalc'), 'slug' => 'coated-115g' ) );
		\wp_insert_term( 'couted-135g', 	'pa_' . $name, array( 'description' => \__('Coated 135g', 'gcalc'), 'slug' => 'coated-135g' ) );
		\wp_insert_term( 'couted-170g', 	'pa_' . $name, array( 'description' => \__('Coated 170g', 'gcalc'), 'slug' => 'coated-170g' ) );
		\wp_insert_term( 'couted-250g', 	'pa_' . $name, array( 'description' => \__('Coated 250g', 'gcalc'), 'slug' => 'coated-250g' ) );
		\wp_insert_term( 'couted-350g', 	'pa_' . $name, array( 'description' => \__('Coated 350g', 'gcalc'), 'slug' => 'coated-350g' ) );
		\wp_insert_term( 'uncouted-70g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-70g' ) );
		\wp_insert_term( 'uncouted-80g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-80g' ) );
		\wp_insert_term( 'uncouted-90g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-90g' ) );
		\wp_insert_term( 'uncouted-100g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-100g' ) );
		\wp_insert_term( 'uncouted-120g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-120g' ) );
		\wp_insert_term( 'uncouted-150g', 	'pa_' . $name, array( 'description' => \__('Uncoated 70g', 'gcalc'), 'slug' => 'uncoated-150g' ) );
		\wp_insert_term( 'eccobook_cream_16-60g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 16', 'gcalc'), 'slug' => 'eccobook16-60g' ) );
		\wp_insert_term( 'eccobook_cream_16-70g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 16', 'gcalc'), 'slug' => 'eccobook16-70g' ) );
		\wp_insert_term( 'eccobook_cream_16-80g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 16', 'gcalc'), 'slug' => 'eccobook16-80g' ) );
		\wp_insert_term( 'eccobook_cream_20-60g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 60g vol 20', 'gcalc'), 'slug' => 'eccobook20-60g' ) );
		\wp_insert_term( 'eccobook_cream_20-70g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 70g vol 20', 'gcalc'), 'slug' => 'eccobook20-70g' ) );
		\wp_insert_term( 'eccobook_cream_20-80g', 	'pa_' . $name, array( 'description' => \__('Ecco book cream 80g vol 20', 'gcalc'), 'slug' => 'eccobook20-80g' ) );
		\wp_insert_term( 'ibook_white_16-60g', 	'pa_' . $name, array( 'description' => \__('iBOOK cream 60g vol 16', 'gcalc'), 'slug' => 'ibook_white_16-60g' ) );
		\wp_insert_term( 'ibook_white_16-70g', 	'pa_' . $name, array( 'description' => \__('iBOOK cream 70g vol 16', 'gcalc'), 'slug' => 'ibook_white_16-70g' ) );
		\wp_insert_term( 'ibook_cream_20-60g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 60g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-60g' ) );
		\wp_insert_term( 'ibook_cream_20-70g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 70g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-70g' ) );
		\wp_insert_term( 'ibook_cream_20-80g', 	'pa_' . $name, array( 'description' => \__('iBOOK white 80g vol 20', 'gcalc'), 'slug' => 'ibook_cream_20-80g' ) );
		\wp_insert_term( 'munken_cream_18-80g', 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 'slug' => 'munken_cream_18-80g' ) );
		\wp_insert_term( 'munken_cream_18-90g', 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 'slug' => 'munken_cream_18-90g' ) );
		\wp_insert_term( 'munken_cream_15-80g', 	'pa_' . $name, array( 'description' => \__('Munken cream 80g vol 16', 'gcalc'), 'slug' => 'munken_cream_15-80g' ) );
		\wp_insert_term( 'munken_cream_15-90g', 	'pa_' . $name, array( 'description' => \__('Munken cream 90g vol 16', 'gcalc'), 'slug' => 'munken_cream_15-90g' ) );
		\wp_insert_term( 'munken_white_18-80g', 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 'slug' => 'munken_white_18-80g' ) );
		\wp_insert_term( 'munken_white_18-90g', 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 'slug' => 'munken_white_18-90g' ) );
		\wp_insert_term( 'munken_white_15-80g', 	'pa_' . $name, array( 'description' => \__('Munken white 80g vol 16', 'gcalc'), 'slug' => 'munken_white_15-80g' ) );
		\wp_insert_term( 'munken_white_15-90g', 	'pa_' . $name, array( 'description' => \__('Munken white 90g vol 16', 'gcalc'), 'slug' => 'munken_white_15-90g' ) );				
	}

	/**
	* Adds volume attribute
	*/
	public static function pa_volume(){
		$name = 'volume';
		$label = \__('Volume', 'gcalc');
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
		\wp_insert_term( '10', 	'pa_' . $name, array( 'description' => \__('10 pcs.', 'gcalc'), 'slug' => '10-szt.' ) );
		\wp_insert_term( '25', 	'pa_' . $name, array( 'description' => \__('25 pcs.', 'gcalc'), 'slug' => '25-szt.' ) );
		\wp_insert_term( '30', 	'pa_' . $name, array( 'description' => \__('30 pcs.', 'gcalc'), 'slug' => '30-szt.' ) );
		\wp_insert_term( '40', 	'pa_' . $name, array( 'description' => \__('40 pcs.', 'gcalc'), 'slug' => '40-szt.' ) );
		\wp_insert_term( '50', 	'pa_' . $name, array( 'description' => \__('50 pcs.', 'gcalc'), 'slug' => '50-szt.' ) );
		\wp_insert_term( '75', 	'pa_' . $name, array( 'description' => \__('75 pcs.', 'gcalc'), 'slug' => '75-szt.' ) );
		\wp_insert_term( '100', 	'pa_' . $name, array( 'description' => \__('100 pcs.', 'gcalc'), 'slug' => '100-szt.' ) );
		\wp_insert_term( '200', 	'pa_' . $name, array( 'description' => \__('200 pcs.', 'gcalc'), 'slug' => '200-szt.' ) );
		\wp_insert_term( '300', 	'pa_' . $name, array( 'description' => \__('300 pcs.', 'gcalc'), 'slug' => '300-szt.' ) );
		\wp_insert_term( '400', 'pa_' . $name, array( 'description' => \__('400 pcs.', 'gcalc'), 'slug' => '400-szt.' ) );
		\wp_insert_term( '500', 'pa_' . $name, array( 'description' => \__('500 pcs.', 'gcalc'), 'slug' => '500-szt.' ) );
		\wp_insert_term( '1000', 'pa_' . $name, array( 'description' => \__('1000 pcs.', 'gcalc'), 'slug' => '1000-szt.' ) );
		\wp_insert_term( '2500', 'pa_' . $name, array( 'description' => \__('2500 pcs.', 'gcalc'), 'slug' => '2500-szt.' ) );
	}

	/**
	* Adds sizemm attribute
	*/
	public static function pa_sizemm(){
		$name = 'sizemm';
		$label = \__('Format', 'gcalc');
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
		\wp_insert_term( '85x55', 	'pa_' . $name, array( 'description' => \__('Calling card 85x55mm', 'gcalc'), 'slug' => '85x55' ) );
		\wp_insert_term( '105x148', 'pa_' . $name, array( 'description' => '', 'slug' => '105x148' ) );
		\wp_insert_term( '148x210', 'pa_' . $name, array( 'description' => '', 'slug' => '148x210' ) );
		\wp_insert_term( '210x297', 'pa_' . $name, array( 'description' => '', 'slug' => '210x297' ) );
		\wp_insert_term( '297x420', 'pa_' . $name, array( 'description' => '', 'slug' => '297x420' ) );
		\wp_insert_term( '125x176', 'pa_' . $name, array( 'description' => '', 'slug' => '125x176' ) );
		\wp_insert_term( '176x250', 'pa_' . $name, array( 'description' => '', 'slug' => '176x250' ) );
		\wp_insert_term( '250x353', 'pa_' . $name, array( 'description' => '', 'slug' => '250x353' ) );					
	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_finish(){
		$name = 'finish';
		$label = \__('Finish', 'gcalc');
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
		\wp_insert_term( 'gloss', 	'pa_' . $name, array( 'description' => \__('Gloss finish', 'gcalc'), 'slug' => 'gloss' ) );
		\wp_insert_term( 'matt', 	'pa_' . $name, array( 'description' => \__('Matt finish', 'gcalc'), 'slug' => 'matt' ) );
		\wp_insert_term( 'soft-touch', 	'pa_' . $name, array( 'description' => \__('Soft touch finish', 'gcalc'), 'slug' => 'soft-touch' ) );
		
	}

	/**
	* Adds wrap_media attribute
	*/
	public static function pa_spot_uv(){
		$name = 'spot_uv';
		$label = \__('Spot UV', 'gcalc');
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
		\wp_insert_term( '00', 	'pa_' . $name, array( 'description' => \__('No spot UV', 'gcalc'), 'slug' => '00' ) );
		\wp_insert_term( '10', 	'pa_' . $name, array( 'description' => \__('Spot UV', 'gcalc'), 'slug' => '10' ) );
		\wp_insert_term( '11', 	'pa_' . $name, array( 'description' => \__('Soft touch finish', 'gcalc'), 'slug' => '11' ) );
		
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