<?php 
namespace gcalc;
   
class actions {
    
/**
 * setd locale filter function
 * @param [type] $locale [description]
 */
  public static function set_locale( $locale ){    
    return $locale;
  }

    public static function load_textdomains( ) {

      $pdf_namespace = 'gcalc-report-pdf';
      $locale = \apply_filters( 'plugin_locale', \is_admin() ? \get_user_locale() : \get_locale(), $pdf_namespace );
      $pdf_calc_basic_file_path = GAAD_PLUGIN_TEMPLATE_DIR . 'languages/' .$pdf_calc_basic_namespace . '-' . $locale . '.mo';
           
      if ( is_file( $pdf_calc_basic_file_path )  ) {
        $pdf_calc_basic_tranlations_status = \load_textdomain( $pdf_namespace, $pdf_calc_basic_file_path );        
        $pdf_calc_client_tranlations_status = \load_textdomain( $pdf_namespace, $pdf_calc_basic_file_path );        
      }

   }

/**
 * generate basic calculation post type content  
 * @return [type] [description]
 */
  public static function calculation_post_content( string $cid, $calculation, array $headers, string $template_filename ){
    $css_file = GAAD_PLUGIN_TEMPLATE_CALCULATIONS_CSS_DIR . '/' . $template_filename . '.css';
    $css_ = is_readable( $css_file ) ? file_get_contents( $css_file ) : '';
    $template_file = GAAD_PLUGIN_TEMPLATE_APP_TEMPLATES_DIR. '/calculations/' . $template_filename . '.php';
   
    ob_start( ); 
      include( $template_file );
      $content = ob_get_contents();
    ob_end_clean();
    
    $emogrifier = new \Pelago\Emogrifier();
    $emogrifier->setHtml( $content );
    $emogrifier->setCss( $css_ );
    $content = $emogrifier->emogrify();

    return $content;
  }

  /**
   * Gets calculation post type
   * @return [type] [description]
   */
    public static function get_calculation_post_by_cid( string $cid ){
      $attr = array (
          'post_type' => 'calculation',
          'post_title' => $cid
        );
      $q = new \WP_Query( $attr );
      $r = array( 'posts' => $q->posts[ 0 ] );
      $r[ 'exists' ] = $q->have_posts();
      return $r;
    }

  




     /**
   * Adds calculation custom post for further use.
   * @param  string $cid         [description]
   * @param  [type] $calculation [description]
   * @param  array  $headers     [description]
   * @return [type]              [description]
   */
    public static function acalculations_insert_wp_post( string $cid, $calculation, array $headers, string $token = NULL ){
      $r = array();
      $action = 'add';
      $post_title = $cid. '-' . $token;
      $exists = actions::get_calculation_post_by_cid( $post_title );
      $post_content = actions::calculation_post_content( $cid, $calculation, $headers, $token .'-pdf' );

      $attr = array (
          'post_type' => 'calculation',
          'post_title' => $post_title,
          'post_content' => $post_content,
          'post_status' => 'publish',
          'comment_status' => 'closed',
          'ping_status' => 'closed',   
      );
     
      if ( !$exists[ 'exists' ] ) {
        $post_id = \wp_insert_post( $attr );
        
      } else {
        $post_id = $attr[ 'ID' ] = $exists[ 'posts' ]->ID; 
        $action = 'update';
        \wp_update_post( $attr );
      }

      $r['post_id'] = $post_id;
      $r['action'] = $action;
      $r['post_content'] = $post_content;
      return $r;
    }
  




  /**
   * Create type to store calculations for viewing
   * @return [type] [description]
   */
    public static function create_calclaton_post_type(  ){
      
      //labels array added inside the function and precedes args array

       $labels = array(
        'name'               => \_x( 'Kalkulacje', 'post type general name' ),
        'singular_name'      => \_x( 'Kalkulacja', 'post type singular name' ),
        'add_new'            => \_x( 'Add New', 'Calculation' ),
        'add_new_item'       => \__( 'Add New Calculation' ),
        'edit_item'          => \__( 'Edit Calculation' ),
        'new_item'           => \__( 'New Calculation' ),
        'all_items'          => \__( 'All Calculations' ),
        'view_item'          => \__( 'View Calculation' ),
        'search_items'       => \__( 'Search calculations' ),
        'not_found'          => \__( 'No calculations found' ),
        'not_found_in_trash' => \__( 'No calculations found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Calculations'
      );

      // args array

       $args = array(
        'labels'        => $labels,
        'description'   => 'Displays product calculations',
        'public'        => true,
        'menu_position' => 4,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive'   => true,
      );

      \register_post_type( 'calculation', $args );

      return $r;
    }

  public static function calculate_product_variation_before_save( $obj, $data_store ){
    $calc = new calculate( $obj->get_attributes(), $obj->get_parent_id() );
    $calc->calc();    
    $obj->set_price( $calc->get_price() );
    $obj->set_regular_price( $calc->get_price() );
    return $obj;
  }

  public static function localisation(){
    $languages_dir = dirname( dirname( plugin_basename(__FILE__))) .'/languages/';
    load_plugin_textdomain('gaad-mailer', false, $languages_dir );    
    return true;
  }
  
  /**
  * Copy a file, or recursively copy a folder and its contents
  * @author      Aidan Lister <aidan@php.net>
  * @version     1.0.1
  * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
  * @param       string   $source    Source path
  * @param       string   $dest      Destination path
  * @param       int      $permissions New folder creation permissions
  * @return      bool     Returns true on success, false on failure
  */
  public static function xcopy($source, $dest, $permissions = 0755) {
      // Check for symlinks
      if (is_link($source)) {
          return symlink(readlink($source), $dest);
      }

      // Simple copy for a file
      if (is_file($source)) {
          return copy($source, $dest);
      }

      // Make destination directory
      if (!is_dir($dest)) {
          mkdir($dest, $permissions);
      }

      if ( is_dir( $source ) ) {
            // Loop through the folder
            $dir = dir($source);
            while (false !== $entry = $dir->read()) {
                // Skip pointers
                if ($entry == '.' || $entry == '..') {
                    continue;
                }

                // Deep copy directories
                actions::xcopy("$source/$entry", "$dest/$entry", $permissions);
            }

            // Clean up
            $dir->close();
      } else return false;
      
      return true;
  }

  
  /*
  * Tworzy niezbędne pluginowi pliki i katalogi w bieżącym szablonie
  * Trzeba dopisac akcje zmiany parametru files_updated kiedy zmienia sie szablon z panelu!
  */
  public static function update_theme_files( ){
   
    $files_updated = filter_var( get_option( 'files_updated', 'false' ), FILTER_VALIDATE_BOOLEAN);
    if( !$files_updated || GAAD_PLUGIN_TEMPLATE_FORCE_FILES_UPDATED ){
      if( actions::xcopy( GAAD_PLUGIN_TEMPLATE_THEME_FILES_DIR, get_template_directory() ) ){
        update_option( 'files_updated', 'true', '', 'yes' );
        
        return true;
      }
      
    }
    update_option( 'files_updated', 'false', '', 'yes' );  
    return false;
    
  }
    
  public static function login_user( $username = NULL, $userpwd = NULL ){
    if( $_POST ){
   
      $username = trim($_POST[ 'username' ]);
      $userpwd = trim($_POST[ 'userpwd' ]);
      $check = wp_authenticate_username_password( NULL, $username, $userpwd );

     if( $check instanceof WP_User ){
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $userpwd;
        $creds['remember'] = true;
        $user = wp_signon( $creds, false );
        wp_set_current_user($user->ID);
      }      
    }    
  }

  /*
  * Puts app templates as a html at the top
  */
  public static function put_templates( $dir ){ 
    global $post;
    $tpl_dir = opendir( $dir = str_replace( '\\', '/', $dir ) );
    $post_slug = $post->post_name; 

    while ( $f = readdir($tpl_dir) ){
      $id = array();
      preg_match('/(.*)[\.]{1}.*$/', $f, $id);
      $id = basename( $dir ) . '-' . empty( $id ) ? $f : $id[ 1 ];
     
      $template = $dir . '/'.$f;      
      if( is_file( $template ) && $f !== 'router.html' ){
        $template_id = 'template-' . basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '-' . str_replace( '-php', '', sanitize_title( $id ) );
        ?><script type="template/javascript" id="<?php echo $template_id; ?>"><?php require_once( $template ); ?></script><?php
      }      
    }
  }

  /*
  * Puts app components as scripts at the top
  */
  public static function put_components( $dir ){ 
    global $post;
    $tpl_dir = opendir( $dir = str_replace( '\\', '/', $dir ) );
    $post_slug = $post->post_name; 

    while ( $f = readdir($tpl_dir) ){
      $id = array();
      preg_match('/(.*)[\.]{1}.*$/', $f, $id);
      $id = basename( $dir ) . '-' . empty( $id ) ? $f : $id[ 1 ];
     
      $component = $dir . '/'.$f;      
      if( is_file( $component ) ){
        $component = filters::dir_to_url( $component );
        $template_id = $post_slug . '-' . str_replace( '-php', '', sanitize_title( $id ) );
        ?><script type="application/javascript" src="<?php echo $component; ?>" id="<?php echo $template_id; ?>"></script><?php
      }      
    }
  }
  //


  /**
  * Generates javascript/template for common components
  */
  public static function app_components(){
   global $post; 
   if ( is_object( $post ) ) {
      $post_slug = $post->post_name; 
   
      //common components templates
      actions::put_components( GAAD_PLUGIN_TEMPLATE_APP_COMPONENTS_DIR );

      if ( is_dir( GAAD_PLUGIN_TEMPLATE_APP_COMPONENTS_DIR . '/' . $post_slug ) ) {
        //app templates
        actions::put_components( GAAD_PLUGIN_TEMPLATE_APP_COMPONENTS_DIR . '/' . $post_slug );
      }
   }      
 }


  /**
  * Generates javascript/template for common components
  */
  public static function app_templates(){
   global $post;    
   
      if ( is_object( $post)) {
       $post_slug = $post->post_name; 
        //common components templates
         actions::put_templates(  GAAD_PLUGIN_TEMPLATE_APP_TEMPLATES_DIR );
         
         if ( is_dir( GAAD_PLUGIN_TEMPLATE_APP_TEMPLATES_DIR . '/' . $post_slug ) ) {
           actions::put_templates( GAAD_PLUGIN_TEMPLATE_APP_TEMPLATES_DIR . '/' . $post_slug );
         }
      }
  }
  

  public static function app_data_src(){
    $json_data = new json_data();
    ?><script id="<?php echo basename(constant( 'gcalc\GAAD_PLUGIN_TEMPLATE_NAMESPACE' )); ?>-json-data" type="application/javascript"><?php $json_data->draw(); ?></script>


    <?php    
  }
  
  public static function common_styles(){
    global $post;
    $post_slug = is_object( $post) ? $post->post_name : false ;

    if(  GAAD_PLUGIN_TEMPLATE_ENV === 'DEV' ){      
      //wp_enqueue_style( basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '-app-css', GAAD_PLUGIN_TEMPLATE_URL . '/css/app.css', false, false);
    }
    
    if(  GAAD_PLUGIN_TEMPLATE_ENV === 'DIST' ){
      //wp_enqueue_style( basename(GAAD_PLUGIN_TEMPLATE_NAMESPACE) . '-app-css', GAAD_PLUGIN_TEMPLATE_URL . '/dist/css/app.min.css', false, false);
    }        
  }
  
  public static function app_shortcodes(){
    $namespace = basename( constant( 'gcalc\GAAD_PLUGIN_TEMPLATE_NAMESPACE' ) );
    $shortcode = basename( constant( 'gcalc\GAAD_PLUGIN_TEMPLATE_SHORTCODE' ) );
    if ( method_exists( $namespace . '\shortcodes', $shortcode ) ) {
      add_shortcode( $shortcode, $namespace . '\shortcodes::' . $shortcode );
    } 
    else {      
      add_shortcode( $shortcode, $namespace . '\shortcodes::no_main_shortcode_error' );
    }      
  }

//method_exists( $namespace . '\shortcodes', 'no_main_shortcode_error' )

  public static function app_scripts(){
    global $post;
    $post_slug = is_object( $post) ? $post->post_name : false ;
    

    wp_enqueue_script( 'font-awesome-js', 'https://use.fontawesome.com/c93a35a2e5.js', array( ), false, true );    
     // wp_enqueue_script( 'jquery', GAAD_PLUGIN_TEMPLATE_URL . '/dist/js/app.min.js', array( 'jquery' ), false, true );  

    if(  GAAD_PLUGIN_TEMPLATE_ENV === 'DEV' ){
      add_action('wp_head', '\\' . GAAD_PLUGIN_TEMPLATE_NAMESPACE . 'actions::app_components', 9 );
      wp_enqueue_script( __NAMESPACE__ . '-app-dev-js', GAAD_PLUGIN_TEMPLATE_URL . '/js/app.js', 
        array( 'vue-js', 'vue-router-js', 'bootstrap-vue-js' ),
         false, true );
      }
    
    if(  GAAD_PLUGIN_TEMPLATE_ENV === 'DIST' ){
      
      wp_enqueue_script( __NAMESPACE__ . '-app-dist-js', GAAD_PLUGIN_TEMPLATE_URL . '/dist/js/app.min.js', array( 'jquery', 'vue-js' ), false, true );    

    } 
    
    //add_action('wp_head', '\\' . __NAMESPACE__ . '\actions::app_templates', 9 );
    //add_action('wp_head', '\\' . __NAMESPACE__ . '\actions::app_data_src', 8 );
  }
  
  public static function common_scripts(){
     
  //   wp_enqueue_script( 'gkredytslider-app-js', GAAD_PLUGIN_TEMPLATE_URL . '/js/gkredytslider-app.js', array( 'vue-js' ), false, true );
  }
  
  public static function test(){
    echo "test ok";
    die();
  }
  
  /*
  * Skrypty główne wczytywane na każdej posdtronie
  */
  public static function core_scripts(){

    if ( GAAD_PLUGIN_TEMPLATE_ENV === 'DIST') {
      $core = array(
        'modules-js' => array( GAAD_PLUGIN_TEMPLATE_URL . '/dist/js/modules.min.js', array( 'vue-js' ), false, null ),
        //'vue-js' => array( 'https://unpkg.com/vue@2.4.2/dist/vue.js', false, false, null  ),        
        //'vue-router-js' => array( 'https://unpkg.com/vue-router/dist/vue-router.js', array( 'vue-js' ), false, null ),
        //'vue-x-js' => array( 'https://unpkg.com/vuex', array( 'vue-js' ), false, null ),       
        //'bootstrap-js' => array( 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', array( 'modules-js', 'jquery' ), false, null )
      );
    }

    if ( GAAD_PLUGIN_TEMPLATE_ENV === 'DEV') {
      /*
      * Add core scripts to equeue to core table
      * Table index is a slug. Order of args is the same as in wp_enqueue_script function.
      */
      $core = array(
       //'tether-js' => array( GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/tether/dist/js/tether.min.js', false, false, null ),
       //'vue-js' => array( 'https://unpkg.com/vue@2.4.2/dist/vue.js', false, false, null  ),        
       //'vue-router-js' => array( 'https://unpkg.com/vue-router/dist/vue-router.js', array( 'vue-js' ), false, null ),
       //'vue-x-js' => array( 'https://unpkg.com/vuex', array( 'vue-js' ), false, null ),       
       //'bootstrap-js' => array( 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js', array( 'tether-js', 'jquery' ), false, null ),
       //'bootstrap-vue-js' => array( GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/bootstrap-vue/dist/bootstrap-vue.min.js', array( 'vue-js' ), false, null )
       );

      /*
      * Force load core scripts from own serwer
      */
      if ( GAAD_PLUGIN_TEMPLATE_CORE_SCRIPTS_CDN_USE ) {
        //$core[ 'vue-js' ][0] = GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/vue/dist/vue.min.js';
        //$core[ 'vue-router-js' ][0] = GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/vue-router/dist/vue-router.min.js';
        //$core[ 'vue-x-js' ][0] = GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/vuex/dist/vuex.min.js';
        //$core[ 'bootstrap-js' ][0] = GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/bootstrap/dist/js/bootstrap.min.js';
      }       
    }  

    foreach ($core as $lib => $data) {
      //if ( !wp_script_is( $lib ) ) {
        wp_enqueue_script( $lib, $data[0], $data[1], $data[2], $data[3] );
     // }      
    }      
  }
    
  
  /*
  * Style główne wczytywane na każdej posdtronie
  */
  public static function core_styles(){

    if ( GAAD_PLUGIN_TEMPLATE_ENV === 'DEV' ) {

       $core = array(
         basename( GAAD_PLUGIN_TEMPLATE_NAMESPACE ) . '-modules-min-css' => array( GAAD_PLUGIN_TEMPLATE_URL . '/css/modules.min.css', false, false ),
         'app-css' => array( GAAD_PLUGIN_TEMPLATE_URL . '/css/app.css', false, false )
       );

       $components = glob( GAAD_PLUGIN_TEMPLATE_DIR . '/css/components/*.css' );
       if ( !empty( $components ) ) {
         foreach ( $components as $file ) {
           $core[ str_replace( '.', '-', basename( $file ) ) ] = array(filters::dir_to_url( $file ), false, false );
         }
       }
       
    }

    if ( GAAD_PLUGIN_TEMPLATE_ENV === 'DIST' ) {
      /*
      * Add styles to equeue to core table
      * Table index is a slug. Order of args is the same as in wp_enqueue_style function.
      */
       $core = array(
         //'tether-css' => array( GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/tether/dist/css/tether.min.css', false, false ),
         //'bootstrap-css' => array( 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css', false, false ),      
         //'bootstrap-vue-css' => array( '//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css', false, false )
       );

      /*
      * Force load core scripts from own serwer
      */
      if ( !GAAD_PLUGIN_TEMPLATE_CORE_SCRIPTS_CDN_USE ) {
         //$core[ 'bootstrap-css' ][0] = GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/bootstrap/dist/css/bootstrap.min.css';
         //$core[ 'bootstrap-vue-css' ][0] = GAAD_PLUGIN_TEMPLATE_URL . '/node_modules/bootstrap-vue/dist/bootstrap-vue.min.css';

      }      

    }

  

    foreach ($core as $lib => $data) {
      //if ( !wp_style_is( $lib ) ) {
        wp_enqueue_style( $lib, $data[0], $data[1], $data[2] );
      //}      
    }    
    
  }
  
  
  
  public function __construct(){
    
    return $this;
  }
  
  
}



?>