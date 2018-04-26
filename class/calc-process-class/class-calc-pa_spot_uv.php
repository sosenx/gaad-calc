<?php 
namespace gcalc\calc;


class pa_spot_uv extends \gcalc\cprocess_calculation{

	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->name = "pa_spot_uv";		
		$this->group = $group;
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->product_id = $product_id;
		$this->parent = $parent;
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){
		$production_formats = new \gcalc\db\production\formats();
		$parent = $this->get_parent();
		$pf = $this->parent->get_best_production_format( $this->group );				
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		
		$tmp = array( 'width' => $pf['common_format']['width'] , 'height' => $pf['common_format']['height']  );
		$format_multiplier = ( $tmp['width'] <= 210 && $tmp['height'] <= 297 ) || ( $tmp['width'] <= 297 && $tmp['height'] <= 210 ) ? 1 : 2;
		$spot_uv_sides = $this->get_spot_uv_sides(); //0-single, 1-double, -1 - none
		
		if ( $spot_uv_sides >= 0 ) {
			$spot_uv_cost = $production_formats->get_spot_uv_cost( );
			$uvstacks = (int)($sheets_quantity / $spot_uv_cost['stack']) + 
				($sheets_quantity / $spot_uv_cost['stack'] > 0 && $sheets_quantity / $spot_uv_cost['stack'] < 1 ? 1 : 0 );
			
			$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this );
			$markup = $markup_db->get_markup();

			$markup_ = $markup['markup'];		
			$production_cost = $uvstacks * $spot_uv_cost['cost'];
			$total_price = $production_cost * $markup_;

		} else {				
			$markup_ = 1;		
			$production_cost = 0 * $sheets_quantity;
			$total_price = $production_cost * $markup_;
		}
		
		
		return $this->parse_total( 
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(		
				'spot_uv' => $spot_uv_sides == 0 ? '1x0' : '1x1',		
				'sheets_quantity' => $sheets_quantity
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