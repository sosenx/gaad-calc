<?php 
/* Template Name: Gaad Calc Dev  */ 


wp_head();

global $post;
$product_id = $post->ID;
$pargs = array(	
    "product_slug" => "druk-ksiazek",

    "pa_format" => "90x50",
    "pa_quantity" => 1500,
    //"pa_multi_quantity" => "10,50,150",
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
    "pa_cover_flaps" => true,
    "pa_cover_left_flap_width" => 100,
    "pa_cover_right_flap_width" => 100,

    "pa_bw_pages" => 100,
    "pa_bw_format" => "175x235",
    "pa_bw_paper" => "ekobookw-70g-2.0",
    "pa_bw_print" => "1x1", 

    "pa_color_pages" => 120,
    "pa_color_format" => "175x235",
    "pa_color_paper" => "kreda-135g",
    "pa_color_print" => "4x4",
    "pa_color_stack" => "stack",

 
    "group_cover" => "",
    "group_bw" => "",
    "group_color" => "",
   
    "apikey" => "g1a2a3d",
    "apisecret" => "k1o2o3t",
    "Authorization" => "Basic ".base64_encode( 'gaad:koot123' ),
  /**/
/*
   "apikey" => "7c2ecd07f155648431e0f94b89247d713c5786e1e73e953f2fe7eca39534cd6d",
   "apisecret" => "d66d261760296433de080dd8d7daebb7e4355473b35fa3091420e9907bd47ad5",
   "Authorization" => "Basic ".base64_encode( 'www:www' )
*/
  // "apikey" => "8a7c8b67fe8bde8bb31f62db5896a1cd8c7bfa29ff7b86554a1ad2958c166e92",
    //"apisecret" => "62c582a63ce60ee9b5e046abcc7625261532bee74df467927586d5ea384fff27",
    //"Authorization" => "Basic ".base64_encode( 'gaad:elevatori123' )

    //"apikey" => "anonymous",
    //"apisecret" => "anonymous-secret",
    //"Authorization" => "Basic ".base64_encode( '*:' )
);
//var_dump("Basic ".base64_encode( 'gaad:koot123' ));
//var_dump( hash('sha256', 'inner'), hash('sha256', 'inner-secret'), md5('inner'));


$q= array( 10, 50, 100, 350, 500, 750, 1000, 1500);
foreach ($q as $key => $value) {
    $pargs['pa_quantity'] = $value;
    $calc = new gcalc\calculate( $pargs );
    $data_permissions_f = new gcalc\data_permissions_filter( $calc );
    $calculation = $data_permissions_f->get();
    $data_permissions_f->save_calculation();

}



//var_dump( $calculation );

wp_footer();



?>



