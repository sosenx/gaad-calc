<?php 
/* Template Name: Gaad Calc Dev  */ 


wp_head();

global $post;
$product_id = $post->ID;
$pargs = array(
	"pa_format" => "210x297",
    "pa_podloze" => "offset-80g",
    "pa_zadruk" => "dwustronnie-kolorowe-4x0-cmyk",    
    //"pa_zadruk" => "dwustronnie-kolorowe-1x1-cmyk",    
    //"pa_wrap" => "folia-blysk-dwustronnie",
    "pa_wrap" => "folia-brak",
    "pa_naklad" => "100",
  //  "pa_spot_uv" => "blyszczacy-lakier-punktowy-dwustronnie"    
);

$calc = new gcalc\calculate( $pargs, $product_id );
		
$calculation_array = $calc->calc();

echo "<pre>";
	var_dump( $calculation_array );
echo "</pre>";

wp_footer();



?>



