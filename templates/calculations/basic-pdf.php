<?php
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
		'cid'          => __( 'cid', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'parent_cid'   => __( 'parent_cid', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'product_slug' => __( 'product_slug', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'total_price'  => __( 'total_price', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'piece_price'  => __( 'piece_price', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'prod_cost'    => __( 'prod_cost', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'quantity'     => __( 'quantity', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'av_markup'    => __( 'av_markup', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'profit'    	=> __( 'profit', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
		'added'    		=> __( 'added', GAAD_PLUGIN_TEMPLATE_NAMESPACE ),
	);

?>






	<table class="header">
      <tbody>
        <tr>
          <td rowspan="2">
              Logotyp
          </td>
          <td colspan="2">
              <h3><?php echo __( 'Calculation', GAAD_PLUGIN_TEMPLATE_NAMESPACE) ?> # <?php echo $basic['cid'] ?></h3>
          </td>

          <td rowspan="2">
          		<p><?php echo __( 'Created', GAAD_PLUGIN_TEMPLATE_NAMESPACE) ?></p>
              	<p><?php echo $basic['added'] ?></p>
          </td>

		</tr>
		<tr>

          <td>
              <?php echo __( 'Product', GAAD_PLUGIN_TEMPLATE_NAMESPACE) ?>: <?php echo $basic['product_slug'] ?>
          </td>

          <td>
              <?php echo __( 'quantity', GAAD_PLUGIN_TEMPLATE_NAMESPACE) ?>: <?php echo $basic['quantity'] ?>
          </td>
        </tr>

      </tbody>
    </table>



<table class="basic-info">
  <tbody>
    <tr class="header_tr">
      <td colspan="2">
          <?php echo __( 'Product short info', GAAD_PLUGIN_TEMPLATE_NAMESPACE) ?>
      </td>
    </tr>

    <tr>
    	<td class="label"><?php echo $basic_labels['product_slug'] ?></td>
    	<td class="value"><?php echo $basic['product_slug'] ?></td>
    </tr>
    
    <tr>
    	<td class="label"><?php echo $basic_labels['quantity'] ?></td>
    	<td class="value"><?php echo $basic['quantity'] ?></td>
    </tr>
    
    <tr>
    	<td class="label"><?php echo $basic_labels['total_price'] ?></td>
    	<td class="value"><?php echo $basic['total_price'] ?></td>
    </tr>
    
    <tr>
    	<td class="label"><?php echo $basic_labels['profit'] ?></td>
    	<td class="value"><?php echo $basic['profit'] ?></td>
    </tr>
    
    <tr>
    	<td class="label"><?php echo $basic_labels['piece_price'] ?></td>
    	<td class="value"><?php echo $basic['piece_price'] ?></td>
    </tr>
    
    <tr>
    	<td class="label"><?php echo $basic_labels['prod_cost'] ?></td>
    	<td class="value"><?php echo $basic['prod_cost'] ?></td>
    </tr>
    
    <tr>
    	<td class="label"><?php echo $basic_labels['av_markup'] ?></td>
    	<td class="value"><?php echo $basic['av_markup'] ?> (<?php echo ($basic['av_markup']-1)*100 ?>%)</td>
    </tr>
    
  </tbody>
</table>


    <?php

var_dump( $calculation );
    ?>
