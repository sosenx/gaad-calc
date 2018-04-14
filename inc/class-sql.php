<?php 
namespace gcalc;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class sql{


	/**
	* Tworzy tabele log
	*/
	public static function log(){
		global $wpdb;	
		$table_name = basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '_log';		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
		  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `log` text NOT NULL,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}

	/**
	* Tworzy tabele formats
	*/
	public static function formats(){
		global $wpdb;	
		$table_name = basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '_formats';		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(50) NOT NULL,
			`w` INT NOT NULL,
			`h` INT NOT NULL,
			`tm` INT NULL,
			`rm` INT NULL,
			`bm` INT NULL,
			`lm` INT NULL,
		  	`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}


	/**
	* Tworzy tabele printers
	*/
	public static function printers(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_printers';		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(50) NOT NULL ,
			`formats` TEXT NOT NULL , 
			`margins` TEXT NOT NULL , 
			`speed` TEXT NULL , 
			`cprintcost` TEXT NOT NULL , 
			`bwprintcost` TEXT NOT NULL ,
			`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}

	/**
	* Tworzy tabele markup
	*/
	public static function markup(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_markup';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(50) NOT NULL ,
			`type` SET('digital4x','digital1x','digitalS','') NOT NULL ,
			`product_id` INT NOT NULL,			
			`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}

	/**
	* Tworzy tabele printing_media
	*/
	public static function print_media(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_print_media';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(50) NOT NULL ,
			`label` INT NOT NULL ,
			`weight` INT NOT NULL , 
			`w` INT NOT NULL , 
			`h` INT NOT NULL , 
			`grain` INT NOT NULL , 
			`type` INT NOT NULL , 
			`price` INT NOT NULL , 
			`price_type` INT NOT NULL,
			`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}

	/**
	* Tworzy tabele printing_media
	*/
	public static function wrap_media(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_print_media';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(50) NOT NULL ,
			`label` INT NOT NULL ,			
			`w` INT NOT NULL , 
			`type` INT NOT NULL , 
			`price` INT NOT NULL ,			
			`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}


	/**
	* Tworzy tabele calculations
	*/
	public static function calculations(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_calculations';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` 			mediumint(9) NOT NULL AUTO_INCREMENT,	
			`cid` 			VARCHAR(32) NOT NULL,
			`parent_cid` 	VARCHAR(32) NULL DEFAULT NULL,			
			`product_slug`	VARCHAR(50) NOT NULL,			
			`total_price` 	FLOAT NOT NULL,
			`piece_price` 	FLOAT NOT NULL,
			`prod_cost` 	FLOAT NOT NULL,
			`quantity` 		INT NOT NULL,
			`mquantity` 	VARCHAR(100) NULL,			
			`av_markup` 	FLOAT NOT NULL,			
			`bvars` 		TEXT NOT NULL , 	
			`full_total` 	TEXT NOT NULL ,
			`tech` 			TEXT NULL DEFAULT NULL,
			`user` 			VARCHAR(50) NOT NULL,											
			`archives_id` 	mediumint(9) NULL,	
			`added` 		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`token` 		VARCHAR(32) NOT NULL,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		$dbDelta = dbDelta( $sql );	

		return $dbDelta;
	}


	/**
	* Tworzy tabele archives
	*/
	public static function archives(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_archives';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` 				mediumint(9) NOT NULL AUTO_INCREMENT,	
			`cid` 				VARCHAR(32) NOT NULL ,
			`parent_cid` 		VARCHAR(32) NULL DEFAULT NULL,						
			`product_slug`		VARCHAR(32) NOT NULL,			
			`total_price` 		FLOAT NOT NULL,
			`piece_price` 		FLOAT NOT NULL,
			`prod_cost` 		FLOAT NOT NULL,
			`quantity` 			INT NOT NULL,
			`mquantity` 		VARCHAR(100) NULL,			
			`av_markup` 		FLOAT NOT NULL,			
			`bvars` 			TEXT NOT NULL , 	
			`full_total` 		TEXT NOT NULL ,
			`tech` 				TEXT NULL DEFAULT NULL,
			`user` 				VARCHAR(32) NOT NULL,
			`contractor_id` 	VARCHAR(32) NULL,	
			`contractor_nip` 	VARCHAR(32) NOT NULL,	
			`contractor_email` 	VARCHAR(100) NOT NULL,
			`c-slug` 			VARCHAR(100) NOT NULL,
			`notes` 			VARCHAR(250) NULL,
			`added` 			timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,	
			`token` 			VARCHAR(32) NOT NULL,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		$dbDelta = dbDelta( $sql );
		return $dbDelta;
	}


	public static function calculations_get( ){
		global $wpdb; 
		$table_name = basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '_archives';
		$get = array(
			
		);

		//$r = $wpdb->get_results( "SELECT * FROM `$table_name` WHERE cid LIKE '$cid' AND token LIKE '$token' ", ARRAY_A );	
		$r = $wpdb->get_results( "SELECT * FROM `$table_name` ", ARRAY_A );	
		

			return  $r;		
		
	}

	public static function calculation_get( $cid, $token ){
		global $wpdb; 
		$table_name = basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '_calculations';
		$get = array(
			'cid' => $cid, 
			'token' => $token
		);


		//$r = $wpdb->get_results( "SELECT * FROM `$table_name` WHERE cid LIKE '$cid' AND token LIKE '$token' ", ARRAY_A );	//prod version
		$r = $wpdb->get_results( "SELECT * FROM `$table_name` WHERE cid LIKE '$cid'", ARRAY_A );	//dev version

		if ( isset( $r[0] ) ) {		
			
			$r[ 0 ]['av_markup']  = json_decode( $r[0]['av_markup'], true );
			$r[ 0 ]['bvars']      = json_decode( $r[0]['bvars'], true );
			$r[ 0 ]['full_total'] = json_decode( $r[0]['full_total'], true );

			return  $r[0];		
		}
	}

	public static function calculations_insert( $id_, array $bvars, array $user, array $full_total, array $tech = NULL){
		global $wpdb; 

		$cid       	= is_array( $id_ ) ? $id_[ 0 ] : $id_;
		$parent_cid	= is_array( $id_ ) ? $id_[ 1 ] : $id_;
		$tech      	= is_null( $tech ) ? array() : $tech;
		$token = \uniqid('ct-');

		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_calculations';
		$apikey = array_key_exists( 'apikey', $bvars ) ? $bvars['apikey'] : "";
		$insert = array( 
		        'cid' 			=> $cid,
		        'parent_cid' 	=> $parent_cid,
				'product_slug'	=> $bvars['product_slug'],
				'total_price' 	=> round ( $full_total['total_cost_'], 2 ),
				'piece_price' 	=> round ( $full_total['total_cost_'] / $bvars['pa_quantity'], 2),
				'prod_cost' 	=> round ( $full_total['total_pcost_'], 2 ),
				'quantity' 		=> $bvars['pa_quantity'],
				'mquantity' 	=> $bvars['pa_multi_quantity'],
				'av_markup' 	=> round ( $full_total['average_markup'], 2),
		        'bvars' 		=> json_encode( $bvars ),		        
		        'full_total' 	=> json_encode( $full_total ),		        
		        'tech' 			=> json_encode( $tech ),		        
		        'user' 			=> $user['login'],
		        'token' 		=> $token
		    );
		$wpdb->insert( $table_name, $insert );	
		
		return $token;
	}

/**
 * Saves calculation as archive
 * @param  [type]     $id_        [description]
 * @param  array      $bvars      [description]
 * @param  array      $user       [description]
 * @param  array      $full_total [description]
 * @param  array|null $tech       [description]
 * @return [type]                 [description]
 */
	public static function acalculations_insert( $cid, array $calculation, array $contractor){
		global $wpdb; 
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_archives';		
		$calculations_table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_calculations';		
		$token = \uniqid('at-');
		$insert = array(
			'cid'              => $calculation[ 'cid' ],
			'parent_cid'       => $calculation[ 'parent_cid' ],
			'product_slug'     => $calculation[ 'product_slug' ],
			'total_price'      => $calculation[ 'total_price' ],
			'piece_price'      => $calculation[ 'piece_price' ],
			'prod_cost'        => $calculation[ 'prod_cost' ],
			'quantity'         => $calculation[ 'quantity' ],
			'mquantity'        => $calculation[ 'mquantity' ],
			'av_markup'        => $calculation[ 'av_markup' ],
			'bvars'            => json_encode( $calculation[ 'bvars' ] ),
			'full_total'       => json_encode( $calculation[ 'full_total' ] ),
			'tech'             => json_encode( $calculation[ 'tech' ] ),			 
			'user'             => $calculation[ 'user' ],
			'contractor_id'    => $contractor[ 'contractor-id' ],
			'contractor_nip'   => $contractor[ 'contractor-nip' ],
			'contractor_email' => $contractor[ 'contractor-email' ],
			'c-slug'           =>  $contractor[ 'c-slug' ],
			'notes'				=> $contractor['archive-notes'],
			'token'            => $token
		);
		
		$deleted = -1;
		$record_id = $wpdb->insert( $table_name, $insert );	

		$duplicate_entry = preg_match( '/Duplicate entry/', $wpdb->last_error );
		if ( $duplicate_entry ) {
			$token = $wpdb->get_results( "SELECT `token` FROM `$table_name` WHERE `cid` LIKE '" . $calculation[ 'cid' ] . "'", ARRAY_A );
			$token = !empty($token) ? $token[ 0 ]['token'] : false;

			$r = array(
				'duplicate_entry' => $duplicate_entry,
				'last_error' => $wpdb->last_error,
				'deleted' => $deleted,
				'insert_id' => $wpdb->insert_id,
				'token' => $token
			);
			return $r; 
		}

		if ( $record_id > 0) {
			//$deleted = $wpdb->delete( $calculations_table_name, array( 'cid' => $calculation[ 'cid' ] ), array( '%s' ) );
		}

			$r = array(
				'duplicate_entry' => $duplicate_entry,
				'last_error' => $wpdb->last_error,
				'deleted' => $deleted,
				'insert_id' => $wpdb->insert_id,
				'token' => $token
			);

		return $r;
	}


	/** 
	* Do the actual sql tables creation process
	*/
	public static function create_sql_tables(){
		sql::log();
		sql::formats();
		sql::printers();
		sql::markup();
		sql::print_media();
		sql::wrap_media();
		sql::calculations();
		sql::archives();  

		$option_slug = basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '_sql_tables_created';
		update_option( $option_slug, 'true', '', 'yes' );   
	}

	/**
	* Check if sql tables are created already and creates it if needed.
	*/
	public static function app_sql_tables_check(){
		
		$option_slug = basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '_sql_tables_created';
		$sql_tables_created = filter_var( get_option( $option_slug, 'false' ), FILTER_VALIDATE_BOOLEAN);
    	
    	if( !$sql_tables_created || GAAD_PLUGIN_TEMPLATE_FORCE_CREATE_SQL_TABLES ){
	    	sql::create_sql_tables();
	    }  	
	}


}
?>