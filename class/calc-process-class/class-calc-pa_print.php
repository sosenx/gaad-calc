<?php 
namespace gcalc\calc;


class pa_print extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group );
		$this->name = "pa_print";	
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
		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
		$pages = $this->get_pages( );
		$markup = $markup_db->get_markup();				
		$markup_ = $markup_db->get_markup_value( $this->cargs['pa_quantity'], $markup['markup'][$print_color_mode] );		

		$production_cost = $sheets_quantity * $pf['print_cost'] * $pages;
		$total_price = $production_cost * $markup_;
		$markup_ = $this->get_val_from( 
			'',
			"min", 
			$markup['markup'][$print_color_mode],
			$pa_quantity
			);

		
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
	function do( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

}


?>