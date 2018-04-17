<?php 
namespace gcalc;

/*
* 
*/
   
class json_data {
  
  private $json = '{}';
  private $tojson = array();
  
  public function __construct(){
    $this->tojson = $this->get();
    $this->getJson();
    return $this;
  }
  
  function update_json(){
    return $this->json = json_encode( $this->tojson);

  }

  function getJson(){
    return $this->update_json();

  }

  function draw( $return = false ){
    $string = 'var '. basename( constant( 'gcalc\GCALC_NAMESPACE' ) ) .'__app_model ='. $this->getJson() .';';
    if ( !$return ) {
      echo $string;
    }
    return $string;
  }
  
/*
ta fn pobiera wszystkie niezbedne aplikacji dane
*/
  function get(){       
    $app_model = rest::app_model();
    if ( !is_string( $app_model ) ) {
      $app_model = "{ \"error\" : \"No model\" }";
    }
    return json_decode( $app_model, true );
  }
  
  
}



?>