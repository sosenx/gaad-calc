<?php 
/* Template Name: Gaad Calc Dev  */ 


wp_head();

global $post;

echo do_shortcode( $post->post_content);


wp_footer();



?>



