<?php 
namespace gcalc;
/*
 * Plugin Name: Gaad Api Calc
 * Text Domain: gcalc
 * Version: 0.1
 * Plugin URI: 
 * Description: Kalkulator produktów dla WooCommerce z możliwością kalkulowania przez REST API. 
 * Author: GAAD 
 * Requires at least: 4.5
 * Tested up to: 4.9
 *
 * @package WordPress
 * @author Bartek Sosnowski
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
ini_set('max_execution_time', 60*10); //10 minutes

define( 'gcalc\GCALC_NAMESPACE', 'gcalc\\' );


if ( !defined( GCALC_NAMESPACE . 'GCALC_CORE_SCRIPTS_CDN_USE'))
	define( 
		GCALC_NAMESPACE . 'GCALC_CORE_SCRIPTS_CDN_USE', true );

if ( !defined( 'WPLANG'))
	define( 'WPLANG', 'pl_PL' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_ENV'))
	define( GCALC_NAMESPACE . 'GCALC_ENV', 'DEV' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_SHORTCODE'))
	/*
	* Application lauching shorcode name
	* @default namespace name
	*/
	define( GCALC_NAMESPACE . 'GCALC_SHORTCODE', 'gcalc' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_NAME'))            
	define( GCALC_NAMESPACE . 'GCALC_NAME', trim(dirname(plugin_basename(__FILE__)), '/') );

if ( !defined( GCALC_NAMESPACE . 'GCALC_COMPONENTS_CSS_DIR'))            
	define( GCALC_NAMESPACE . 'GCALC_COMPONENTS_CSS_DIR', 'css/components' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_DIR' ) )
	define( GCALC_NAMESPACE . 'GCALC_DIR', plugin_dir_path( __FILE__) );

if ( !defined( GCALC_NAMESPACE . 'GCALC_CALCULATIONS_CSS_DIR'))            
	define( GCALC_NAMESPACE . 'GCALC_CALCULATIONS_CSS_DIR', GCALC_DIR . '/css/calculations' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_VENDOR_DIR' ) )
	define( GCALC_NAMESPACE . 'GCALC_VENDOR_DIR', GCALC_DIR .'/vendor' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_AUTOLOAD' ) )
	define( GCALC_NAMESPACE . 'GCALC_AUTOLOAD', GCALC_VENDOR_DIR . '/autoload.php');

if ( !defined( GCALC_NAMESPACE . 'GCALC_THEME_FILES_DIR' ) ) 
	define( GCALC_NAMESPACE . 'GCALC_THEME_FILES_DIR', GCALC_DIR . 'theme_files' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_APP_TEMPLATES_DIR' ) )
	define( GCALC_NAMESPACE . 'GCALC_APP_TEMPLATES_DIR', GCALC_DIR . 'templates' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_APP_COMPONENTS_DIR' ) )
	define( GCALC_NAMESPACE . 'GCALC_APP_COMPONENTS_DIR', GCALC_DIR . 'js/components' );

if ( !defined( GCALC_NAMESPACE . 'GCALC_DIR') ) 
	define( GCALC_NAMESPACE . 'GCALC_DIR', GCALC_DIR . '/' . GCALC_NAME );

if ( !defined( GCALC_NAMESPACE . 'GCALC_URL') )
	define( GCALC_NAMESPACE . 'GCALC_URL', WP_PLUGIN_URL . '/' . GCALC_NAME );


if ( !defined( GCALC_NAMESPACE . 'GCALC_CALCULATIONS_CSS_URL'))            
	define( GCALC_NAMESPACE . 'GCALC_CALCULATIONS_CSS_URL', GCALC_URL . '/css/calculations' );



if ( !defined( GCALC_NAMESPACE . 'GCALC_FORCE_CREATE_SQL_TABLES') )
	/*
	* Forces to create sql tables even in there are some in the database. Created mostly for developmnet reasons
	*/
	define( GCALC_NAMESPACE . 'GCALC_FORCE_CREATE_SQL_TABLES', true ); 


if ( !defined( GCALC_NAMESPACE . 'GCALC_FORCE_CREATE_WOO_ELEMENTS') )
	/*
	* Forces to create all WP or WOO related objects and elements (posts, products, taxonomies, terms etc.)
	* Created mostly for developmnet reasons.
	*/
	define( GCALC_NAMESPACE . 'GCALC_FORCE_CREATE_WOO_ELEMENTS', false ); //



if ( !defined( GCALC_NAMESPACE . 'GCALC_DISABLE_CREATE_PRODUCTS') )
	/*
	* Disables predefined product creation
	* Created mostly for developmnet reasons.
	*/
	define( GCALC_NAMESPACE . 'GCALC_DISABLE_CREATE_PRODUCTS', true );



if ( !defined( GCALC_NAMESPACE . 'GCALC_DISABLE_CREATE_USERS') )
	/*
	* Disables predefined users creation
	* Created mostly for developmnet reasons.
	*/
	define( GCALC_NAMESPACE . 'GCALC_DISABLE_CREATE_USERS', false );


if ( !defined( GCALC_NAMESPACE . 'GCALC_DISABLE_CREATE_ATTRIBUTES') )
	/*
	* Disables predefined attributes creation
	* Created mostly for developmnet reasons.
	*/
	define( GCALC_NAMESPACE . 'GCALC_DISABLE_CREATE_ATTRIBUTES', true );



if ( !defined( GCALC_NAMESPACE . 'GCALC_CREATE_VARIATIONS') )
	/*
	* Disables predefined attributes creation
	* Created mostly for developmnet reasons.
	*/
	define( GCALC_NAMESPACE . 'GCALC_CREATE_VARIATIONS', false );



if ( !defined( GCALC_NAMESPACE . 'GCALC_SQL_TABLE_PREFIX') )
	/*
	* String will be used as prefix for plugins sql tables names
	*/
	define( GCALC_NAMESPACE . 'GCALC_SQL_TABLE_PREFIX', GCALC_NAMESPACE . '_' );



if ( !defined( GCALC_NAMESPACE . 'GCALC_FORCE_FILES_UPDATED') )
	/**	
	* Forces to upload template filesize(filename)
	*/
	define( GCALC_NAMESPACE . 'GCALC_FORCE_FILES_UPDATED', true );


if ( !defined( GCALC_NAMESPACE . 'GCALC_AUTOSAVE_CALCULATIONS_TYPES') )
	/**	
	* Forces to upload template files
	*/
	define( GCALC_NAMESPACE . 'GCALC_AUTOSAVE_CALCULATIONS_TYPES', '5,10' );




if ( !defined( GCALC_NAMESPACE . 'GCALC_AUTOSEND_CALCULATION_TO_CONTRACTOR_ON_SAVE') )
	/**	
	* Forces to upload template files
	*/
	define( GCALC_NAMESPACE . 'GCALC_AUTOSEND_CALCULATION_TO_CONTRACTOR_ON_SAVE', false );



	//composer autoload
	is_file( \gcalc\GCALC_AUTOLOAD ) ?  require_once( \gcalc\GCALC_AUTOLOAD ) : false;
	
	require_once( 'class/db/class-api-user.php' );
	require_once( 'class/class-data-permissions-filter.php' );
	require_once( 'class/class-error.php' );
	require_once( 'class/class-errors.php' );
	require_once( 'class/db/class-error-codes.php' );
	require_once( 'class/db/production-paper.php' );
	require_once( 'class/db/class-calc-order.php' );
	require_once( 'class/db/production-formats.php' );	
	require_once( 'class/db/class-product-markup.php' );

	require_once( 'class/class-ptotal.php' );

	require_once( 'class/class-cprocess-calculation.php' );
		require_once( 'class/calc-process-class/class-calc-pa_format.php' );
		require_once( 'class/calc-process-class/class-calc-pa_folding.php' );
		require_once( 'class/calc-process-class/class-calc-pa_cover_type.php' );
		require_once( 'class/calc-process-class/class-calc-pa_cover_format.php' );
		require_once( 'class/calc-process-class/class-calc-pa_quantity.php' );
		require_once( 'class/calc-process-class/class-calc-pa_multi_quantity.php' );
		require_once( 'class/calc-process-class/class-calc-pa_paper.php' );
		require_once( 'class/calc-process-class/class-calc-pa_color_paper.php' );
		require_once( 'class/calc-process-class/class-calc-pa_bw_paper.php' );
		require_once( 'class/calc-process-class/class-calc-pa_print.php' );
		require_once( 'class/calc-process-class/class-calc-pa_cover_print.php' );


		require_once( 'class/calc-process-class/class-calc-pa_finish.php' );
		require_once( 'class/calc-process-class/class-calc-pa_spot_uv.php' );
		require_once( 'class/calc-process-class/class-calc-pa_sewing.php' );
		require_once( 'class/calc-process-class/class-calc-pa_pages.php' );

	require_once( 'class/class-cprocess.php' );
		require_once( 'class/calc-process/pa_format.php' );
		require_once( 'class/calc-process/pa_folding.php' );
		require_once( 'class/calc-process/pa_cover_type.php' );
		require_once( 'class/calc-process/pa_cover_format.php' );
		require_once( 'class/calc-process/pa_quantity.php' );
		require_once( 'class/calc-process/pa_multi_quantity.php' );
		require_once( 'class/calc-process/pa_paper.php' );
		require_once( 'class/calc-process/pa_color_paper.php' );
		require_once( 'class/calc-process/pa_bw_paper.php' );
		require_once( 'class/calc-process/pa_print.php' );
		require_once( 'class/calc-process/pa_cover_print.php' );




		require_once( 'class/calc-process/pa_finish.php' );
		require_once( 'class/calc-process/pa_spot_uv.php' );
		require_once( 'class/calc-process/pa_sewing.php' );
		require_once( 'class/calc-process/pa_pages.php' );



	require_once( 'inc/abstract-email-notifications.php' );	
	require_once( 'inc/class-email-notifications.php' );	
	require_once( 'inc/class-pdf.php' );	
	require_once( 'inc/class-sql.php' );	



	require_once( 'class/products/class-product.php' );
	require_once( 'class/products/class-plano.php' );
		require_once( 'class/products/class-plano-color.php' );
		require_once( 'class/products/class-plano-bw.php' );
		require_once( 'class/products/class-letterhead.php' );
		require_once( 'class/products/class-letterhead-color.php' );
		require_once( 'class/products/class-letterhead-bw.php' );

	require_once( 'class/products/class-business-card.php' );
	require_once( 'class/products/class-folded-business-card.php' );
	require_once( 'class/products/class-flyer.php' );
	
	require_once( 'class/products/class-brochure.php' );
	
	require_once( 'class/products/class-writing-pad.php' );
	
	//require_once( 'class/products/class-ticket.php' );
	//require_once( 'class/products/class-poster.php' );
	//require_once( 'class/products/class-poster-xxl.php' );
	
	
	

	require_once( 'class/products/class-book.php' );
	require_once( 'class/products/class-catalog.php' );
	require_once( 'class/products/class-perfect-catalog.php' );
	require_once( 'class/products/class-saddle-catalog.php' );
	require_once( 'class/products/class-spiral-catalog.php' );


	require_once( 'inc/class-register-woo-elements.php' );
	require_once( 'inc/class-json-data.php' );
	require_once( 'inc/class-rest.php' );	
	require_once( 'inc/register-routers.php' );
	require_once( 'class/class-hooks-mng.php' );
	require_once( 'class/class-shortcodes.php' );
	require_once( 'inc/class-filters.php' );
	require_once( 'inc/class-actions.php' );
	require_once( 'inc/class-admin-actions.php' );
	require_once( 'inc/plugin-hooks.php' );
	
	require_once( 'class/abstract-class-calc-product.php' );
	require_once( 'class/class-calculate.php' );


	require_once( 'class/class-call-stack.php' );
	require_once( 'class/class-todo-list.php' );
	
	require_once( 'class/class-product-tax.php' );
	require_once( 'class/class-product-shipment.php' );
	
	
	
	/**
	 * Use * for origin
	 */
	add_action( 'rest_api_init', function() {
	    
	  remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
	  add_filter( 'rest_pre_serve_request', function( $value ) {
	    header( 'Access-Control-Allow-Origin: http://localhost:3000' );
	    header('Access-Control-Allow-Credentials: true');
	    header( 'Access-Control-Allow-Methods: GET' );
	    header( 'Access-Control-Allow-Headers: apikey,apisecret,authorization,group_bw,group_color,group_cover,pa_bw_format,pa_bw_pages,pa_bw_paper,pa_bw_print,pa_color_format,pa_color_pages,pa_color_paper,pa_color_print,pa_color_stack,pa_cover_cloth_covering_paper,pa_cover_cloth_covering_print,pa_cover_cloth_covering_spot_uv,pa_cover_cloth_covering_finish,pa_cover_dust_jacket_paper,pa_cover_dust_jacket_print,pa_cover_dust_jacket_spot_uv,pa_cover_dust_jacket_finish,pa_cover_flaps,pa_cover_format,pa_cover_left_flap_width,pa_cover_paper,pa_cover_print,pa_cover_ribbon,pa_cover_right_flap_width,pa_cover_spot_uv,pa_cover_type,pa_cover_finish,pa_format,pa_multi_quantity,multi_quantity,pa_paper,pa_print,pa_quantity,pa_spot_uv,pa_finish,product_slug, pa_cover_board_thickness, pa_folding ' );

	   // \gcalc\rest::cors();
	    return $value;
	    
	  });
	}, 15 );



	new register_woo_elements();

?>