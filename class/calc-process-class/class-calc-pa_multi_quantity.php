<?php 
namespace gcalc\calc;


class pa_multi_quantity extends \gcalc\cprocess_calculation{

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->name = "pa_multi_quantity";
		$this->group = $group;		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		$this->product_id = $product_id;
		return $this;
	}

	/**
	* Calculates print cost and margin
	*/
	function calc(){		
		$pa_multi_quantity = $this->get_carg('pa_multi_quantity');
		$calculations = array();
		$q = explode(',', $pa_multi_quantity );
		$max = count( $q );
		for ($i=0; $i < $max; $i++) { 
			if( isset( $q[ $i ] ) ){
				$pa_quantity = (int)$q[ $i ];
				$pargs = array_merge( $this->cargs, array( 
					"pa_quantity" => $pa_quantity,
					"apikey" => '33bf6fbd7cd8379785a21e233d8e09f824e7bab459168a96312c1c882c1d7e1f',
					"apisecret" => '1efbc603bed6958d0d88898114343645ff16c55b6aa04ce3f4070e3c83cf70fe',
					"Authorization" => 'Basic *:'
					)
				);
				unset( $pargs['pa_multi_quantity'] );
				/*
				unset( $pargs['apikey'] );
				unset( $pargs['apisecret'] );
				unset( $pargs['Authorization'] );
				*/
				$calc = new \gcalc\calculate( $pargs );
				$data_permissions_f = new \gcalc\data_permissions_filter( $calc );
				$calculations[] = $data_permissions_f->get();
			}
		}



		return $this->parse_total( 
			$calculations,
			array(
				'value' => $pa_multi_quantity
			)
		);
	}

	/**
	*
	*/
	function do( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "*", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}

}


?>