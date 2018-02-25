<?php 
/* Template Name: Gaad Calc Dev  */ 


wp_head();

global $post;
$product_id = $post->ID;
$pargs = array(
	
    "product_slug" => "druk-ksiazek",
    "pa_format" => "90x50",
    "pa_quantity" => 99,
    "pa_paper" => "kreda-350g",
    "pa_print" => "4x4",
                 
    "pa_wrap" => "gloss-1x1",   
    "pa_spot_uv" => "1x0",


    "pa_cover_format" => "175x235",
    "pa_cover_paper" => "kreda-300g",
    "pa_cover_print" => "4x0",    
    "pa_cover_type" => "hard",
    
    "pa_cover_dust_jacket_paper" => "kreda-150g",
    "pa_cover_dust_jacket_print" => "4x4",
    "pa_cover_dust_jacket_wrap" => "0x0",
    "pa_cover_dust_jacket_spot_uv" => "1x0",

    "pa_cover_cloth_covering_paper" => "offset-150g",
    "pa_cover_cloth_covering_wrap" => "gloss-1x0",
    "pa_cover_cloth_covering_print" => "4x4",
    "pa_cover_cloth_covering_spot_uv" => "1x0",
    "pa_cover_ribbon" => true,
    
    
    
    

    
    "pa_cover_wrap" => "gloss-1x0",    
    "pa_cover_spot_uv" => "1x1",
    "pa_cover_flaps" => true,/*
    "pa_cover_left_flap_width" => 100,
    "pa_cover_right_flap_width" => 100,



*/
    "pa_bw_pages" => 100,
    "pa_bw_format" => "175x235",
    "pa_bw_paper" => "ekobookw-70g-2.0",
    "pa_bw_print" => "1x1", 

    "pa_color_pages" => 120,
    "pa_color_format" => "175x235",
    "pa_color_paper" => "kreda-135g",
    "pa_color_print" => "4x4",
    "pa_color_stack" => "stack",
/**/
 
    "group_cover" => "",
    "group_bw" => "",
    "group_color" => "",

    "apikey" => "g1a2a3d",
    "apisecret" => "k1o2o3t",
    "Authorization" => "Basic ".base64_encode( 'gaad:koot123' )
      
);


$calc = new gcalc\calculate( $pargs );
$calc->calc();
//echo "<pre>";   var_dump( $calculation_array );echo "</pre><hr>";

$data_permissions_f = new gcalc\data_permissions_filter( $calc );
var_dump( $data_permissions_f->get() );

/*
foreach ($calculation_array as $key => $value) {
    var_dump( $value->total['name'], $value->total['total_price']);
}
*/
wp_footer();



?>



