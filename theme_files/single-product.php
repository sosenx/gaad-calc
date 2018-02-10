<?php 
/* Template Name: Gaad Calc Dev  */ 


wp_head();

global $post;
$product_id = $post->ID;
$pargs = array(
	"pa_format" => "90x50",
    "pa_podloze" => "kreda-350g",
    "pa_zadruk" => "dwustronnie-kolorowe-4x4-cmyk",
    "pa_wrap" => "folia-blysk-dwustronnie",
    "pa_naklad" => "100"
);

$calc = new gcalc\calculate( $pargs, $product_id );
		
$calculation_array = $calc->get_calculation_array();

echo "<pre>";
	var_dump( $calculation_array);
echo "</pre>";

wp_footer();



?>



