<?php 
namespace gcalc;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

class sql{


	/**
	* Tworzy tabele log
	*/
	public static function log(){
		global $wpdb;	
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_log';		
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
		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_formats';		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(50) NOT NULL ,
			`w` INT NOT NULL ,
			`h` INT NOT NULL ,
			`tm` INT NULL ,
			`rm` INT NULL ,
			`bm` INT NULL ,
			`lm` INT NULL ,
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
			`id` mediumint(9) NOT NULL AUTO_INCREMENT,	
			`cid` VARCHAR(32) NOT NULL,			
			`total_price` 	FLOAT NOT NULL,
			`p_cost` 	FLOAT NOT NULL,
			`quantity` 		INT NOT NULL,
			`mquantity` 	VARCHAR(100) NULL,			
			`av_markup` FLOAT NOT NULL,			
			`input` TEXT NOT NULL , 	
			`foutput` TEXT NOT NULL , 
			`apikey` VARCHAR(100) NULL,			
			`user` VARCHAR(50) NOT NULL,
			`access_level` mediumint(9) NOT NULL,
			`label` VARCHAR(250) NULL ,								
			`added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,		  
		  PRIMARY KEY  (id)
		) $charset_collate;";
		
		return dbDelta( $sql );
	}


	public static function calculations_insert( string $cid, array $bvars, array $user, array $full_total){
		global $wpdb; 

		$table_name = basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '_calculations';
		$apikey = array_key_exists( 'apikey', $bvars ) ? $bvars['apikey'] : "";
		$insert = array( 
				'total_price' 	=> $full_total['total_cost_'],
				'p_cost' 	=> $full_total['total_pcost_'],
				'quantity' 		=> $bvars['pa_quantity'],
				'mquantity' 	=> $bvars['pa_multi_quantity'],
				'av_markup' 	=> $full_total['average_markup'],
		        'input' => json_encode($bvars),		        
		        'foutput' => json_encode($full_total),
		        'apikey' => $apikey,
		        'user' => $user['login'],
		        'access_level' => $user['access_level'],
		        'label' => '',
		        'cid' => $cid,
		    );
		$re = $wpdb->insert( $table_name, $insert );
		
		var_dump($re, $wpdb);
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