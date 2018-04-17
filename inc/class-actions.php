<?php 
namespace gcalc;
   
class actions {
    



/**
 * generate basic info about calculation owner account manager
 * @return [type] [description]
 */
  public static function calculation_owner_short_info( $calculation ){

    $user = \get_user_by( 'login', $calculation[ 'user' ] ); 
    $description = str_replace("\n", "<br>", $user->description );
    $first_name = $user->first_name;
    $last_name = $user->last_name;
    $email = $user->user_email;
    
    return $first_name . ' ' . $last_name . '<br>' . $description. '<br>' 
            . '<a href="mailto:' . $email .'">' . $email . '</a>';
  }


/**
 * generate basic calculation post type content  
 * @return [type] [description]
 */
  public static function calculation_footer_content( \WP_User $user ){

    $css_file = GAAD_PLUGIN_TEMPLATE_CALCULATIONS_CSS_DIR . '/calculation_footer_gravatar.css';
    $css_ = is_readable( $css_file ) ? file_get_contents( $css_file ) : '';
    $template_file = GAAD_PLUGIN_TEMPLATE_APP_TEMPLATES_DIR. '/calculations/calculation_footer_gravatar.php';
   
    $avatar_filename = GAAD_PLUGIN_TEMPLATE_DIR . '/gravatars/avatar-'.$user->ID.'.jpg';
    $size = getimagesize( $avatar_filename );
    $avatar_base64 = chunk_split( base64_encode( file_get_contents( $avatar_filename ) ) );


    ob_start( ); 
      include( $template_file );
      $content = ob_get_contents();
    ob_end_clean();
    
    $emogrifier = new \Pelago\Emogrifier();
    $emogrifier->setHtml( $content );
    $emogrifier->setCss( $css_ );
    $emogrified_content = $emogrifier->emogrify();

    $r = array(
      'css' => $css_,
      'raw_content' => $content,
      'post_content' => $emogrified_content
    );

    return $r;
  }




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
      $pdf_calc_basic_file_path = GAAD_PLUGIN_TEMPLATE_DIR . 'languages/' .$pdf_namespace . '-' . $locale . '.mo';
           
      if ( is_file( $pdf_calc_basic_file_path )  ) {
        $pdf_calc_basic_tranlations_status = \load_textdomain( $pdf_namespace, $pdf_calc_basic_file_path );        
        $pdf_calc_client_tranlations_status = \load_textdomain( $pdf_namespace, $pdf_calc_basic_file_path );        
      }

   }

/**
 * generate basic calculation post type content  
 * @return [type] [description]
 */
  public static function calculation_post_content( string $cid, $calculation, array $headers, string $template_filename, string $template_css_filename = NULL ){
    $css_file = !is_null( $template_css_filename ) ? $template_css_filename :
      GAAD_PLUGIN_TEMPLATE_CALCULATIONS_CSS_DIR . '/' . $template_filename . '.css';
    $css_ = is_readable( $css_file ) ? file_get_contents( $css_file ) : '';
    $template_file = GAAD_PLUGIN_TEMPLATE_APP_TEMPLATES_DIR. '/calculations/' . $template_filename . '.php';
   
    ob_start( ); 
      include( $template_file );
      $content = ob_get_contents();
    ob_end_clean();
    
    $emogrifier = new \Pelago\Emogrifier();
    $emogrifier->setHtml( $content );
    $emogrifier->setCss( $css_ );
    $emogrified_content = $emogrifier->emogrify();

    $r = array(
      'css' => $css_,
      'raw_content' => $content,
      'post_content' => $emogrified_content
    );

    return $r;
  }

  /**
   * Gets calculation post type
   * @return [type] [description]
   */
    public static function get_calculation_post_by_cid( string $title ){
      global $wpdb;
      $results = $wpdb->get_results( 
        $q = "SELECT * FROM `wp_posts` WHERE `post_title` LIKE '" .$title. "' AND `post_type` LIKE 'calculation' ORDER BY `ID` DESC",
        \ARRAY_A );
      
      $r = array( 'posts' => $results );
      $r[ 'exists' ] = !empty( $results );
     
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
          'post_content' => $post_content['post_content'],
          'post_status' => 'publish',
          'comment_status' => 'closed',
          'ping_status' => 'closed',   
      );
     
      if ( !$exists[ 'exists' ] ) {
        $post_id = \wp_insert_post( $attr );
        
      } else {
        $post_id = $attr[ 'ID' ] = $exists[ 'posts' ][0]['ID']; 
        $action = 'update';
        \wp_update_post( $attr );
      }

      $r['post_id'] = $post_id;
      $r['action'] = $action;
      $r['post_content'] = $post_content['post_content'];
      $r['raw_content'] = $post_content['raw_content'];
      $r['css'] = $post_content['css'];
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
    
  
/**
 * Footer text in calculation raports, company name, adress etc
 * @return [type] [description]
 */
  public static function calculation_pdf_Footer(  ){
    $r = array();
$r[] = '<table class="footer-info">';
$r[] = '<tbody>';
$r[] = '<tr><td colspan="2" class="top-margin">.<td></tr>';
$r[] = '<tr>';
$r[] = '<td class="logo">';
$r[] = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALEAAAA9CAYAAADiW4hmAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCREUzMTM1MTQxNTYxMUU4QUU1NzlBOTM2NUZDOUY5MSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCREUzMTM1MjQxNTYxMUU4QUU1NzlBOTM2NUZDOUY5MSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkJERTMxMzRGNDE1NjExRThBRTU3OUE5MzY1RkM5RjkxIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkJERTMxMzUwNDE1NjExRThBRTU3OUE5MzY1RkM5RjkxIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+C4VavQAABfZJREFUeNrsXY1tqzAQhqgL8EZIpXYAMgIZIR0hHYGMEEZoRmhGKCOUAVKpjFBG6PNVR0XTEjA+22dyn4Ra9T2wsT9//nz+If78/IwEgpCxkCIQCIkFAs+4MX1AHMdSigO4u7tL1I9t50/7EbftOr8f3t7emjmWDYWdjf96yP39/bv6sSTO70pVRGVAgg8LZXir8lRbIu4WyzAnfGyhrkrl+Uic1xf1I/PA4RKv6HQ6Fd6UWANQSJXBvSEp7t5SEjmmU6M6F1HYyNq6VcK5R34cdQnt0hOnnu51ReAce4u9g+RA4fcqzXd1ZdF8APW8Byegrg1HEmee7rVN3lRdr47I+xeZX1T6+2hegPd6RnVmReIEKnxiF50yJTCoxSuD/OUqL88zHPflisjPnEg8VVEzpgQG+8CJOJuZEnkzpMiuSZw6uscFgTl24ZsZWotWkTNRYloLwZkoOeZxbnjiQuJEZzTNzQ+r/CwvFSanCseym9VgT6nxlgOJdZWVmx8GBQ6BHAnz3mKyXQqRxJxUOOsrRKbYYs8xJ2RKjRMOJE41ujpOSkypbDDjBmsjYCo+7l749wOVP56hGv/iBOW0c6PR1UJGjoR+WCftqSpM1Ss8KrL2krSdSlZpFui/TRoyqHFha31IB2uVRnlhHLGJOlPMpiJ4zh1KJS6JbUJmKe1JZCBS39UlAp+RuVbXmkCVvVogfI8C3+WBYoBn007oLO7JiIg+JW1dFU4IiAA9xcOUVXzqnsehXstBA6Qi9DH6ucSUHYm1lHiEL95aStvmQLQPxdRlqIgdNoSxaMkC1uWWk6FFu2SyNjqx7YkrDQXt9cW4xmKsx22AIOoeawNRUxthumQSumT1foeegVrdsRyhLJ4vKW0O9Xrio0alpxe6SU5+2FSJD4RlCyRulazqG0wFANKGdmOhhVGQg5MfTjmQGO3IXPaCkUaSSOPEWNBjW9klX8xFiU0nC+q57o3z2Ls1VklMocZT/DBjElfC11/1azp1X7sgsU7Fpcz9sLESC21/EDiPzGcRa9ueWJdYEEbbGfhh7gObRoj7tSx0iXVNsZajsk5iDHeNnQb+2rJ0Zgl0lPhouQ4SIfEovFgMcQ4K18JVQmN8saYfrhwMmpJIwAnV6XRqXJF4qi/m5IcF/PBnuJKVEkdM4sMClqiVCrsjsWa8uLuVn5sSS3SBD3qn7m0uitdSY4Z+WDw1Hxz7VNg2iXV9MUc/3AiJ/dsIdT1e+g82DxSE8NfYLT2ZxQbik8Ske9xwtmuJ73+4giltIPD6r4iEEyXGLTFjyaa78NyVElecSIyNvT334gMPFMynHA8WAKCOV4rAg+OShYOMkBPLlQJhQzRJK6U6/6FnRd0SCf2q/v0TlBrPRQ4ZUN6PiryDCuzCTtjq9l3Hh+vIbDnm4KbYkRhDzvb84idMswroDONyaADni8RlIA1j6B1CIXEXYDvas9l2DMn8vU3J5JR46ySGbl8VYhXRHoLiWonbHRWTyWe6bb7z6QSuZbaeusuE4psdLg5PoSxA5/FhnLgxnfTYGxB4GZkd3GJ7zbV3uCBxxbRB6MD47AdcSztlMAdnDice8y4kplZiT+VE4WkhcvA8NlqBYbMXAit2FBIT+GJC8nlRYvSzFIoGg62PvlAYEBzjvqC+FJ9RKOduJVxEJ6hG+F+K4nmGqkASUsR9u6Ew23mePVydilkxeYapGodEijLgcylYkrhk8gxTIhcBecxddCVYOKp8U1/MKUwEK6q4rzMursELu1Zi01Eym24RG+QD4zoFG3E1KuyaxCZEZKUqqHJrhvVZMW9gYZNYc8sSWyXuvE+JRG4YEXh9jcdmuf5mxxQysp02RSKvGPQUEH5cXeu5bwsPahG8Cp8RGQ4NXHmMBsBB2g/RFSMEJQ5ilI3hNziV3VUsGdL5N/YbIHPGjeOK1jniKgglPldlVOQdLviBWUrKD79UaB2KSPCN2HQ9ZxzHUooD6HwGq0U+oiF312s0c1VcivXEMcVDBIJr8sQCgZBYIBASC4TEAgE3/BdgAMH0V3lyOMywAAAAAElFTkSuQmCC
">';
$r[] = '</td>';
$r[] = '<td class="text">';
$r[] = '<p class="footer-p">Mazowieckie Centrum Poligrafii Wojciech Hunkiewicz, 05-270 Marki, ul. Ciurlionisa 4. Dane kontaktowe podane w podsumowaniu wyceny. Zapraszamy do współpracy.</p>';
$r[] = '</td>';
$r[] = '</tr>';
$r[] = '</tbody>';
$r[] = '</table>';

    $r[] = '';

    $css_ =  <<<EOD
table.footer-info {
  border-top: 1px dashed #CCCCCC;
}

table.footer-info .top-margin{
  height:1mm;
}

table.footer-info .logo {
  width: 13mm;
  height: 17mm;
}
table.footer-info .logo img {
  width: 10mm;
}
table.footer-info .text {
  width: 180mm;
}
table.footer-info .text p{
  line-height:140%;
}
EOD;
    $content = implode( '', $r );

    $emogrifier = new \Pelago\Emogrifier();
    $emogrifier->setHtml( $content );
    $emogrifier->setCss( $css_ );
    $content = $emogrifier->emogrify();

    return $content;
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