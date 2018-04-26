<?php 
namespace gcalc\calc;


class pa_folding extends \gcalc\cprocess_calculation{

	
	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->group = $group;
		$this->name = "pa_folding";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		
		

		return $this;
	}

	/**
	 * Strips pa_folding string into arrays using known unadjustable separators.
	 * @param  $folds pa_folding attribute value
	 * @return boolean|array	Returns false if folding isnt nessesary or string parameter is null
	 */
	public function get_folding_data( $folds ){
		if (strlen( $folds ) > 0 ) {
			$m = array( array(), array() );
			$tmp = explode('|', $folds );
			
			$m[0] = strlen( $tmp[0] ) > 0 ? explode(',', $tmp[0] ) : array();			
			$m[1] = strlen( $tmp[1] ) > 0 ? explode(',', $tmp[1] ) : array();

			$folding_data = array(
				'vertical' => $m[0],
				'horizontal' => $m[1],
				'counterv' => count( $m[0] ),
				'counterh' => count( $m[1] ),
				'runs' => ( count( $m[0] ) > 0 ? 1 : 0 ) + ( count( $m[1] ) > 0 ? 1 : 0 )
			);

			return $folding_data;
		}
		return null;
	}

	/**
	 * Aquires folding click cost from formats class
	 * @param  array 	$folds Parsed by pa_folding::get_folding_data $folds array
	 * @return float 	Folding click cost
	 */
	public function get_click( $folds = NULL ){
		$production_formats = new \gcalc\db\production\formats();
		if ( !empty( $folds ) && !is_null( $folds ) ) {
			return 0.01 * (int)$folds['runs'];
		}
		return false;
	}

	/**
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			
		$production_formats = new \gcalc\db\production\formats();
		$pf = $this->parent->get_best_production_format( $this->group );	
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		//$folds = $this->get_folding_data( $this->get_carg('pa_folding') );		
		//$folding_click = $this->get_click( $folds );
		$folding_click = strlen($this->get_carg('pa_folding'))>0 ? 0.01 : 0;


		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->parent->get_product_id(), $this);
		$markup = $markup_db->get_markup();

		$markup_ = $markup['markup'];		
		$production_cost = $folding_click * $sheets_quantity ;
		$total_price = $production_cost * $markup_;
		


		return $this->parse_total( 			
			array(				
				'total_price' => $total_price,
				'production_cost' => $production_cost,				
				'markup' => $markup_
			),
			array(											
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