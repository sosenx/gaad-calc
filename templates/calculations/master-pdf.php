<?php

  $__ns = 'gcalc-report-pdf';


	$basic = array(
		'cid'          => $calculation[ 'cid' ],
		'parent_cid'   => $calculation[ 'parent_cid' ],
		'product_slug' => $calculation[ 'product_slug' ],
		'total_price'  => $calculation[ 'total_price' ],
		'piece_price'  => $calculation[ 'piece_price' ],
		'prod_cost'    => $calculation[ 'prod_cost' ],
		'quantity'     => $calculation[ 'quantity' ],
		'av_markup'    => $calculation[ 'av_markup' ],
		'profit'    	=> $calculation[ 'total_price' ] - $calculation[ 'prod_cost' ],
		'added'    		=> $calculation[ 'added' ],
	);

	$basic_labels = array(
		'cid'          => __( 'cid', $__ns ),
		'parent_cid'   => __( 'parent_cid', $__ns ),
		'product_slug' => __( 'product_slug', $__ns ),
		'total_price'  => __( 'total_price', $__ns ),
		'piece_price'  => __( 'piece_price', $__ns ),
		'prod_cost'    => __( 'prod_cost', $__ns ),
		'quantity'     => __( 'quantity', $__ns ),
		'av_markup'    => __( 'av_markup', $__ns ),
		'profit'    	=> __( 'profit', $__ns ),
		'added'    		=> __( 'added', $__ns ),
	);


 $book_info = array(
  'contractor-nip'   => $headers[ 'contractor-nip' ],
  'contractor-email' => $headers[ 'contractor-email' ],
  'title'            => $calculation[ 'bvars' ][ 'pa_title' ],
  'isbn'             => $calculation[ 'bvars' ][ 'pa_book_number' ],
  'isbn_value'       => $calculation[ 'bvars' ][ 'pa_book_number_value' ],
 );


 $book_info_labels = array(
  'title' => __( 'Title', $__ns ),
  'isbn' => __( 'Book number', $__ns ),
  'contractor-nip' => __( 'contractor-nip', $__ns ),
  'contractor-email' => __( 'contractor-email', $__ns ),

 );



$summary = array(
  'account' => $calculation[ 'bvars' ][ 'user' ],
  'added' => $basic[ 'added' ],
  'total_price' => $basic[ 'total_price' ],
  'piece_price' => $basic[ 'piece_price' ],
  'quantity' => $basic[ 'quantity' ],

);


//custom markups
$custom_markups = array(); 
foreach ($calculation[ 'bvars' ] as $key => $value) {
  if ( preg_match( '/^markup_/', $key)) {
    $custom_markups[ $key ] = $value;
  }
}



  $pa_bw_pages = $calculation[ 'bvars' ][ 'pa_bw_pages' ] == 0 ? -1 : $calculation[ 'bvars' ][ 'pa_bw_pages' ];
  $pa_color_pages = $calculation[ 'bvars' ][ 'pa_color_pages' ] == 0 ? -1 : $calculation[ 'bvars' ][ 'pa_color_pages' ];

  $attr = array(
    
    'basic' => array(
      'header' =>  __( 'Basic info', $__ns ),
      'attr' => array(
        'pa_format' => $calculation[ 'bvars' ][ 'pa_format' ]. 'mm (' . $calculation[ 'bvars' ][ 'pa_orientation' ] .')',

        'pa_bw_pages'     => $pa_bw_pages,
        'pa_color_pages'  => $pa_color_pages,

      ) 
    ),

    'cover' => array(
      'header' =>  __( 'Cover', $__ns ),
      'attr' => array(
        'pa_cover_type' => $calculation[ 'bvars' ][ 'pa_cover_type' ],
        'pa_cover_paper' => $calculation[ 'bvars' ][ 'pa_cover_paper' ],
        'pa_cover_print' => $calculation[ 'bvars' ][ 'pa_cover_print' ],
        'pa_cover_finish' => $calculation[ 'bvars' ][ 'pa_cover_finish' ],
        'pa_cover_spot_uv' => $calculation[ 'bvars' ][ 'pa_cover_spot_uv' ],
        'pa_cover_flaps' => $calculation[ 'bvars' ][ 'pa_cover_flaps' ],
        'pa_cover_left_flap_width'  => $calculation[ 'bvars' ]['pa_cover_left_flap_width'],
        'pa_cover_right_flap_width' => $calculation[ 'bvars' ]['pa_cover_right_flap_width'],
        'pa_cover_board_thickness' => $calculation[ 'bvars' ][ 'pa_cover_board_thickness' ],
      ) 
    ),

    'bw_block' => array(
      'header' =>  __( 'B&W block', $__ns ),
      'attr' => array(
        'pa_bw_pages'     => $calculation[ 'bvars' ][ 'pa_bw_pages' ] == 0 ? -1 : $calculation[ 'bvars' ][ 'pa_bw_pages' ],
        'pa_bw_paper' => $calculation[ 'bvars' ][ 'pa_bw_paper' ],
        'pa_bw_print' => $calculation[ 'bvars' ][ 'pa_bw_print' ]
      ) 
    ),

    'color_block' => array(
      'header' =>  __( 'Color block', $__ns ),
      'attr' => array(
        'pa_color_pages'     => $calculation[ 'bvars' ][ 'pa_color_pages' ] == 0 ? -1 : $calculation[ 'bvars' ][ 'pa_color_pages' ],
        'pa_color_paper' => $calculation[ 'bvars' ][ 'pa_color_paper' ],
        'pa_color_print' => $calculation[ 'bvars' ][ 'pa_color_print' ],
        'pa_color_pages_numbers' => $calculation[ 'bvars' ][ 'pa_color_pages_numbers' ],
        'pa_color_stack' => $calculation[ 'bvars' ][ 'pa_color_stack' ] === 'true' ? 'block' : 'mixed',
      ) 
    ),

    'packing' => array(
      'header' =>  __( 'Packing for shipment', $__ns ),
      'attr' => array(
        'pa_pieces_per_carton'      => $calculation[ 'bvars' ][ 'pa_pieces_per_carton' ],
        'pa_groupwrap'              => $calculation[ 'bvars' ][ 'pa_groupwrap' ],
      ) 
    ),

  );


  $attr_val_suffix = array(
    'pa_bw_pages' => ' ' . __( 'pages', $__ns ),
    'pa_color_pages' => ' ' . __( 'pages', $__ns ),
    'pa_cover_left_flap_width'  => ' ' . __( 'mm', $__ns ),
    'pa_cover_right_flap_width' => ' ' . __( 'mm', $__ns ),
    'pa_pieces_per_carton' => ' ' . __( ' pcs.', $__ns ),
    'pa_groupwrap' => ' ' . __( ' pcs. together', $__ns ),


    'costs_pa_bw_paper' => ' ' . __( 'b&w block', $__ns ),
    'costs_pa_color_paper' => ' ' . __( 'color block', $__ns ),
    'costs_pa_cover_dust_jacket_print' => ' ' . __( 'cover', $__ns ),
    'costs_pa_cover_type' => ' ',
    'costs_pa_bw_print' => ' ' . __( 'b&w', $__ns ),
    'costs_pa_cover_endpaper_print' => ' ' . __( 'cover', $__ns ),
    'costs_pa_cover_paper' => ' ' . __( 'cover', $__ns ),
    'costs_pa_cover_cloth_covering_print' => ' ' . __( 'cover', $__ns ),
    'costs_pa_cover_print' => ' ' . __( 'cover', $__ns ),
    'costs_pa_color_print' => ' ' . __( 'color', $__ns ),
  );




//cover mod
 if ( $calculation[ 'bvars' ]['pa_cover_type'] === 'hard') {   
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_spot_uv' ] );
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_flaps' ] );
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_paper' ] );
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_finish' ] );
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_print' ] );
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_left_flap_width' ] );
  unset( $attr['cover'][ 'attr' ][ 'pa_cover_right_flap_width' ] );
 // unset( $attr['cover'][ 'attr' ][ '' ] );
 
   // cloth_covering
    $pa_cover_cloth_covering_finish =  $calculation[ 'bvars' ]['pa_cover_cloth_covering_finish'];
    $pa_cover_cloth_covering_print =  $calculation[ 'bvars' ]['pa_cover_cloth_covering_print'];
    $pa_cover_cloth_covering_paper =  $calculation[ 'bvars' ]['pa_cover_cloth_covering_paper'];
    $pa_cover_cloth_covering_spot_uv =  $calculation[ 'bvars' ]['pa_cover_cloth_covering_spot_uv'];

    if ( strlen( $pa_cover_cloth_covering_print ) > 0 && strlen( $pa_cover_cloth_covering_paper ) > 0 ) {
      $attr['cloth_covering'] = array(
        'header' =>  __( 'Cloth covering', $__ns ),
        'attr' => array(
          'pa_cover_cloth_covering_paper' => $pa_cover_cloth_covering_paper,
          'pa_cover_cloth_covering_print' => $pa_cover_cloth_covering_print,
          'pa_cover_cloth_covering_finish' => $pa_cover_cloth_covering_finish,
          'pa_cover_cloth_covering_spot_uv' => $pa_cover_cloth_covering_spot_uv
        )
      );
    }

  // endpaper
    $pa_cover_endpaper_paper =  $calculation[ 'bvars' ]['pa_cover_endpaper_paper'];
    $pa_cover_endpaper_print =  $calculation[ 'bvars' ]['pa_cover_endpaper_print'];

    if ( strlen( $pa_cover_endpaper_print ) > 0 && strlen( $pa_cover_endpaper_paper ) > 0 ) {
      $attr['endpaper'] = array(
        'header' =>  __( 'Endpaper', $__ns ),
        'attr' => array(
          'pa_cover_endpaper_paper' => $pa_cover_endpaper_paper,
          'pa_cover_endpaper_print' => $pa_cover_endpaper_print
        )
      );
    }


    // dust_jacket
    $pa_cover_dust_jacket_paper =  $calculation[ 'bvars' ]['pa_cover_dust_jacket_paper'];
    $pa_cover_dust_jacket_print =  $calculation[ 'bvars' ]['pa_cover_dust_jacket_print'];
    $pa_cover_dust_jacket_finish =  $calculation[ 'bvars' ]['pa_cover_dust_jacket_finish'];
    $pa_cover_dust_jacket_spot_uv =  $calculation[ 'bvars' ]['pa_cover_dust_jacket_spot_uv'];

    if ( strlen( $pa_cover_dust_jacket_print ) > 0 && strlen( $pa_cover_dust_jacket_paper ) > 0 ) {
      $attr['dust_jacket'] = array(
        'header' =>  __( 'Cloth covering', $__ns ),
        'attr' => array(
          'pa_cover_dust_jacket_paper' => $pa_cover_dust_jacket_paper,
          'pa_cover_dust_jacket_print' => $pa_cover_dust_jacket_print,
          'pa_cover_dust_jacket_finish' => $pa_cover_dust_jacket_finish,
          'pa_cover_dust_jacket_spot_uv' => $pa_cover_dust_jacket_spot_uv
        )
      );
    }

 } else { //other cove types: perfect, saddle, spiral, section-sewn

    unset( $attr['cover'][ 'attr' ][ 'pa_cover_board_thickness' ] );

    //removing flaps width settings
    if ( $attr['cover'][ 'attr' ][ 'pa_cover_flaps' ] === 'no-flaps') {
      unset( $attr['cover'][ 'attr' ][ 'pa_cover_left_flap_width' ] );
      unset( $attr['cover'][ 'attr' ][ 'pa_cover_right_flap_width' ] );
    } else {

      if ( $attr['cover'][ 'attr' ][ 'pa_cover_flaps' ] === 'flap-left') {
        unset( $attr['cover'][ 'attr' ][ 'pa_cover_right_flap_width' ] );
      }

      if ( $attr['cover'][ 'attr' ][ 'pa_cover_flaps' ] === 'flap-right') {
        unset( $attr['cover'][ 'attr' ][ 'pa_cover_left_flap_width' ] );
      }
    }
 } 


//no bw block
if( $pa_bw_pages === -1 ){
  unset( $attr[ 'bw_block' ]);
}

//no color block 
if( $pa_color_pages === -1 ){
  unset( $attr[ 'color_block' ]);
} else { //color block settings

  if ( $attr['color_block'][ 'attr' ][ 'pa_color_stack' ] === 'mixed' ) {
      unset( $attr['color_block'][ 'attr' ][ 'pa_color_pages_numbers' ] );    
  }


}



?>


<table class="page">  
  <tbody>
    <tr>
      <td colspan="2"> <!-- first col -->
        
        <table class="header">
            <tbody>
              <tr>
                <td rowspan="2" class="logotype">


                  <br><br>
                    <img class="logo" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAdgAAADfCAYAAABVq8KVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo4RjFFNUQ1NDQwQjAxMUU4OTFEMENDREY0MjUzQzE4NyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo4RjFFNUQ1NTQwQjAxMUU4OTFEMENDREY0MjUzQzE4NyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjhGMUU1RDUyNDBCMDExRTg5MUQwQ0NERjQyNTNDMTg3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjhGMUU1RDUzNDBCMDExRTg5MUQwQ0NERjQyNTNDMTg3Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+M+v+wgAAG2VJREFUeNrsnQmUX1V9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
">
                </td>
                <td colspan="2">
                    <h3><?php echo __( 'Calculation', $__ns ) ?> ( master ) # <?php echo $basic['cid'] ?></h3>
                </td>

                <td rowspan="1" class="bardoce-holder" valign="middle" align="center">
                    <?php 
                      $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
                      echo '<img class="barcode" src="data:image/jpg;base64,' . base64_encode( $generator->getBarcode( substr($basic['cid'], strlen($basic['cid'])-6 ) , $generator::TYPE_CODE_128)) . '">';
                    ?>
                </td>

            </tr>

            <tr class="header-nd-line">

              <td class="first">
                  <?php echo __( 'Product', $__ns ) ?>: <?php echo $basic['product_slug'] ?>
              </td>

              <td class="center">
                  <?php echo __( 'Quantity', $__ns ) ?>: <?php echo $basic['quantity']. ' ' . __( 'pcs.', $__ns ) ?>
              </td>

              <td class="last">
                  <?php echo __( 'Created', $__ns ) ?> : <?php echo $basic['added'] ?>
              </td>


            </tr>

          </tbody>
        </table>



      </td>
    </tr>

<!-- margin between header and book info -->
<tr>  
  <td colspan="2"> 

    <h3 class="document-title-red"><?php echo __( 'Confidential company data.', $__ns ) ?></h3>

  </td>  
</tr>


    <tr>
      <td colspan="2">
        
        <table class="book-info">
          <tbody>
            <tr class="header">
              <td colspan="2"><div class="line"><?php echo __( 'Book', $__ns ) ?></div></td>
            </tr>

            <tr>
              <td class="label"><div class="line"><?php echo $book_info_labels['title']; ?></div></td>
              <td class="value"><div class="line"><?php echo $book_info['title'] ?></div></td>
            </tr>

              <?php if ( $book_info['isbn'] === 'isbn' || $book_info['isbn'] === 'issn' ) {
                ?>

                <tr>
                  <td class="label"><div class="line"><?php echo $book_info_labels['isbn']; ?></div></td>
                  <td class="value"><div class="line"><?php echo $book_info['isbn'] ?></div></td>
                </tr>     

                <?php
              } ?>

            <tr class="header">
              <td colspan="2"><div class="line"><?php echo __( 'Contreactor', $__ns ) ?></div></td>
            </tr>

            <tr>
              <td class="label"><div class="line"><?php echo $book_info_labels['contractor-nip']; ?></div></td>
              <td class="value"><div class="line"><?php echo $book_info['contractor-nip'] ?></div></td>
            </tr>
            <tr>
              <td class="label"><div class="line"><?php echo $book_info_labels['contractor-email']; ?></div></td>
              <td class="value"><div class="line"><?php echo $book_info['contractor-email'] ?></div></td>
            </tr>     
           
            
          </tbody>
        </table>

      </td>
    </tr>

<!-- margin between book info and content -->
<tr>  
  <td colspan="2"><br></td>  
</tr>

<!-- body, left + right -->
    <tr>
      <td class="left">

        <table class="basic-info">
          <tbody>
            <tr class="header">
              <td colspan="2"><div class="line"><?php echo __( 'Product short info', $__ns ) ?></div></td>
            </tr>

            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['product_slug'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['product_slug'] ?></div></td>
            </tr>
            
            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['quantity'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['quantity'] . ' ' . __( 'pcs.', $__ns ) ?></div></td>
            </tr>
            
            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['total_price'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['total_price'] ?> PLN</div></td>
            </tr>
            
            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['profit'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['profit'] ?> PLN</div></td>
            </tr>
            
            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['piece_price'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['piece_price'] ?> PLN</div></td>
            </tr>
            
            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['prod_cost'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['prod_cost'] ?> PLN</div></td>
            </tr>
            
            <tr>
              <td class="label"><div class="line"><?php echo $basic_labels['av_markup'] ?></div></td>
              <td class="value"><div class="line"><?php echo $basic['av_markup'] ?> (<?php echo ($basic['av_markup']-1)*100 ?>%)</div></td>
            </tr>
            
          </tbody>
        </table>

        <!-- CUSTOM MARKUPS -->
        <?php
        if (!empty( $custom_markups )) {
           ?><br><br>
             <table class="markups-info">
              <tbody>
                <tr class="header">
                  <td colspan="2"><div class="line"><?php echo __( 'Markups', $__ns ) ?></div></td>
                </tr>

            <?php foreach ($custom_markups as $key => $value) { ?>

                <tr>
                  <td class="label"><div class="line"><?php echo __( $name = str_replace( 'markup_','pa_', $key ), $__ns ) . ' ' . $attr_val_suffix[ 'costs_' . $name ] ?></div></td>
                  <td class="value"><div class="line"><?php echo $value ?>%</div></td>
                </tr>

            <?php } ?>
                
               
                
              </tbody>
            </table>
           <?php
         } 
        ?>


        <!-- COSTS -->
        <br><br>
           <table class="costs-info">
            <tbody>
              <tr class="header">
                <td colspan="2"><div class="line"><?php echo __( 'Costs', $__ns ) ?></div></td>
              </tr>  

              <?php 
              foreach ( $calculation[ 'full_total' ]['total_pcost_equasion'] as $key => $value) { 
                if ( $value === 0) {
                  continue;
                }

                ?>
                  <tr>
                    <td class="label"><div class="line"><?php echo __( $key, $__ns ) . ' ' . $attr_val_suffix[ 'costs_' . $key ]?></div></td>
                    <td class="value"><div class="line"><?php echo round($value, 2) ?> PLN</div></td>
                  </tr>
                <?php
              } ?>

                  <tr class="header">
                    <td colspan="2" class="total-bar"></td>
                  </tr> 
                   <tr>
                    <td class="label"><div class="line"><?php echo __( 'Total', $__ns ) ?></div></td>
                    <td class="value"><div class="line"><?php echo round( $calculation[ 'full_total' ]['total_pcost_'], 2); ?> PLN</div></td>
                  </tr>

          </tbody>
        </table>
      


      </td><!--/.left col -->
      
      <td class="right">


        <table class="attr-list">
          <tbody>
            <tr class="header">
              <td colspan="2"><div class="line"><?php echo __( 'Product attributes', $__ns ) ?></div></td>
            </tr>


            <?php 
              foreach ( $attr as $key => $value ) {
                ?>
                 <tr class="header">
                  <td colspan="2"><div class="line"><?php echo __( $value['header'], $__ns ) ?></div></td>
                </tr>

                <?php

                foreach ($value[ 'attr' ] as $key2 => $value2 ) {
                  if( $value2 != -1 ){
                    ?>
                        <tr>
                          <td class="label"><div class="line"><?php echo __( $key2, $__ns ); ?></div></td>
                          <td class="value"><div class="line"><?php echo __( $value2, $__ns );
                            if ( array_key_exists( $key2, $attr_val_suffix ) ) {
                              echo $attr_val_suffix[ $key2 ];
                            }
                           ?></div></td>
                        </tr>
  
                    <?php
                  }
                }
              }
            ?>


          </tbody>
        </table>



      </td>   

    </tr>



<!-- margin summary -->
<tr>  
  <td colspan="2"><br><br></td>  
</tr>


<tr>  
  <td colspan="2">


      <table class="summary">
          <tbody>
            <tr class="header big">
              <td colspan="5"><div class="line"><?php echo __( 'Summary', $__ns ) ?></div></td>
            </tr>

            <tr class="header">
              <td><div class="line"><?php echo __( 'Account contact', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Created, date', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Quantity', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Total price', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Piece price', $__ns ) ?></div></td>
            </tr>

            <tr>
              <td class="value"><div class="line"><?php echo $summary[ 'account' ] ?></div></td>
              <td class="value"><div class="line"><?php echo $summary[ 'added' ] ?></div></td>
              <td class="value"><div class="line"><?php echo $summary[ 'quantity' ] . ' ' . __( 'pcs.', $__ns ) ?></div></td>
              <td class="value"><div class="line"><?php echo $summary[ 'total_price' ] ?> PLN</div></td>
              <td class="value"><div class="line"><?php echo $summary[ 'piece_price' ] ?> PLN</div></td>

            </tr>

           
            
          </tbody>
        </table>

  </td>  
</tr>

  </tbody>
</table>




<!--more-->



<?php 
  $used_formats = $calculation['full_total']['used_formats'];
  $used_media = $calculation['full_total']['used_media'];
  $total_markup = $calculation['full_total']['total_markup'];
  $total_pcost = $calculation['full_total']['total_pcost_equasion'];
  $total_cost = $calculation['full_total']['total_cost_equasion'];
  $total_cost_ = $calculation['full_total']['total_cost_'];
  $total_pcost_ = $calculation['full_total']['total_pcost_'];
  $average_markup = $calculation['full_total']['average_markup'];
?>


<table class="page2">  
  <tbody>
    

    <tr>  
      <td colspan="2"> 

        <h3 class="document-title-red"><?php echo __( 'Used formats', $__ns ) ?></h3>
        <table class="formats-info">
          <tbody>
            <tr class="header">
              <td><div class="line"><?php echo __( 'Type', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Imposition slots', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Print format', $__ns ) ?></div></td>
            </tr>

                <?php foreach ($used_formats as $key => $value) { ?>

                    <tr>
                      <td class="label"><div class="line"><?php echo __( 'formats_' . $key, $__ns );  ?></div></td>
                      
                      <?php 
                        $split = explode('@', $value);
                      ?>
                      <td class="value value-1"><div class="line"><?php echo $split[0] ?></div></td>
                      <td class="value value-2"><div class="line"><?php echo $split[1] ?></div></td>
                    </tr>

                <?php } ?>
                    
           
            
          </tbody>
        </table>

      </td>  
    </tr>


     <tr>  
      <td colspan="2"> 

        <h3 class="document-title-red"><?php echo __( 'Used Media', $__ns ) ?></h3>
        <table class="formats-info">
          <tbody>
            <tr class="header">
              <td><div class="line"><?php echo __( 'Type', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Imposition slots', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Print format', $__ns ) ?></div></td>
            </tr>

                <?php foreach ($used_media as $key => $value) { ?>

                    <tr>
                      <td class="label"><div class="line"><?php echo __( 'media_' . $key, $__ns );  ?></div></td>
                      
                      <?php 
                        $split = explode('@', $value);
                      ?>
                      <td class="value value-1"><div class="line"><?php echo $split[0] ?></div></td>
                      <td class="value value-2"><div class="line"><?php echo $split[1] ?></div></td>
                    </tr>

                <?php } ?>
                    
           
            
          </tbody>
        </table>

      </td>  
    </tr>



    <tr>
      <td colspan="2"> <!-- first col -->
      </td>
    </tr>


    <tr> 
      <td class="left">
      
 <h3 class="document-title-red"><?php echo __( 'Production costs', $__ns ) ?></h3>
        <table class="pcosts-info">
          <tbody>
            <tr class="header">
              <td><div class="line"><?php echo __( 'Process', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Value', $__ns ) ?></div></td>
            </tr>

                <?php foreach ($total_pcost as $key => $value) { ?>
                  
                    <tr>
                      <td class="label"><div class="line"><?php echo __( 'pcost_' . $key, $__ns );  ?></div></td>
                      <td class="value"><div class="line"><?php echo round( $value, 2) ?></div></td>
                      
                    </tr>

                <?php } ?>
                    
           
            
          </tbody>
        </table>


      </td>

      <td class="right">
      

        <h3 class="document-title-red"><?php echo __( 'Selling prices', $__ns ) ?></h3>
        <table class="costs-info">
          <tbody>
            <tr class="header">
              <td><div class="line"><?php echo __( 'Process', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Value', $__ns ) ?></div></td>
            </tr>

                <?php foreach ($total_cost as $key => $value) { ?>
                  
                    <tr>
                      <td class="label"><div class="line"><?php echo __( 'cost_' . $key, $__ns );  ?></div></td>
                      <td class="value"><div class="line"><?php echo round( $value, 2) ?></div></td>
                      
                    </tr>

                <?php } ?>
                    
           
            
          </tbody>
        </table>


      </td>
    </tr>


    <tr>
      <td class="left">
       
        <h3 class="document-title-red"><?php echo __( 'Markups layers', $__ns ) ?></h3>
        <table class="markups-info">
          <tbody>
            <tr class="header">
              <td><div class="line"><?php echo __( 'Markup layer', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Value', $__ns ) ?></div></td>
            </tr>

                <?php foreach ($total_markup as $key => $value) { ?>
                  
                    <tr>
                      <td class="label"><div class="line"><?php echo __( 'markup_' . $key, $__ns );  ?></div></td>
                      <td class="value"><div class="line"><?php echo round( ( $value - 1 ) * 100, 2)

 ?>%</div></td>
                      
                    </tr>

                <?php } ?>
                    
           
            
          </tbody>
        </table>




      </td>
    
      <td class="right">
        
       <?php
       $totals = array(
          'cost_' => $total_cost_,
          'pcost_' => $total_pcost_,
          'profit_' => $total_cost_ - $total_pcost_,
          'commision' => ( $total_cost_ - $total_pcost_ ) / 20,
          'average_markup' => $average_markup,
       );



       ?>

      <h3 class="document-title-red"><?php echo __( 'TOTALS', $__ns ) ?></h3>
        <table class="totals-info">
          <tbody>
            <tr class="header">
              <td><div class="line"><?php echo __( 'Name', $__ns ) ?></div></td>
              <td><div class="line"><?php echo __( 'Value', $__ns ) ?></div></td>
            </tr>

                <?php foreach ($totals as $key => $value) { ?>
                  
                    <tr>
                      <td class="label"><div class="line"><?php echo __( 'totals_' . $key, $__ns );  ?></div></td>
                      <td class="value"><div class="line"><?php echo round( $value, 2) ?></div></td>                      
                    </tr>

                <?php } ?>
                    
           
            
          </tbody>
        </table>




      </td>
    </tr>
   


  </tbody>
</table>       





    <?php
//var_dump( $calculation );
    ?>
