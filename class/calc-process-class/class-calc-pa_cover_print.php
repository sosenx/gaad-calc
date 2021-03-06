<?php 
namespace gcalc\calc;


class pa_cover_print extends \gcalc\cprocess_calculation{

	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->name = "pa_cover_print";	
		$this->group = $group;	
		$this->cargs = $product_attributes;
		$this->product_id = $product_id;
		$this->dependencies = NULL;
	
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){
		$pf = $this->parent->get_best_production_format( $this->group );	
		$pa_quantity = $this->get_carg( 'pa_master_quantity' );
		$sheets_quantity = (int)( $pa_quantity / $pf['pieces']) + ( $pa_quantity % $pf['pieces'] > 0 ? 1 : 0 );
		$print_color_mode = substr( $pf['print_color_mode'], 0, 2);		
		$pages = $this->get_pages( );				

		/**
		 * outside markup source (prom requst attributes)		  
		 */
		$group = $this->get_group();
		$markup_attr_name = 'markup_' . str_replace( 'pa_', '', $group[1] );
		$overridden_markup_value = (int)$this->get_carg( $markup_attr_name ) / 100;

		if ( is_null( $overridden_markup_value ) || $overridden_markup_value === 0 ) {				
			$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
			$markup = $markup_db->get_markup( );	//true = gets markup from markup product group, not product type
			
			$markup_ = $this->get_val_from( 
				'', 
				"min", 
				$markup["markup_cover_print"][$print_color_mode],
				$pa_quantity
				);
		} else {
			$markup_ = $overridden_markup_value;
		}
		
		$production_cost = $sheets_quantity * $pf['print_cost'] * $pages; // devide by 2 cos we dealing with pages 2pages == 1 sheet
		
		$total_price = $production_cost * $markup_;
		
		return $this->parse_total( 
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(
				'print_cost' => $pf['print_cost'],
				'sheets_quantity' => $sheets_quantity * $pages
			)
		);
	}


	/**
	*
	*/
	function do__( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

}


?>