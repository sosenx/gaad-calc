<?php 
/* Template Name: Gaad Calc Dev  */ 


wp_head();

global $post;
$product_id = $post->ID;
$pargs = array(
	
    "pa_format" => "100x160",
    "pa_paper" => "kreda-150g",
    "pa_print" => "4x4",         
    "pa_quantity" => 1000,
    

    "pa_cover_format" => "270x250",
   // "pa_cover_paper" => "kreda-350g",
   // "pa_cover_print" => "4x0",
   // "pa_cover_wrap" => "gloss-1x0",    
   // "pa_cover_spot_uv" => "1x1",

    "pa_bw_pages" => 100,
    "pa_bw_format" => "140x215",
    //"pa_bw_paper" => "kreda-115g",
    //"pa_bw_print" => "1x1",    

    "pa_color_pages" => 100,
    //"pa_color_paper" => "kreda-135g",
    //"pa_color_print" => "4x4",
    //"pa_color_stack" => "stack",
 
    "group_cover" => "",
    "group_bw" => "",
    "group_color" => ""/**/  
);

$calc = new gcalc\calculate( $pargs, $product_id );
		
$calculation_array = $calc->calc();

echo "<pre>";
	var_dump( $calculation_array );
echo "</pre>";

wp_footer();



?>



