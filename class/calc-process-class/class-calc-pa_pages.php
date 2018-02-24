<?php 
namespace gcalc\calc;


class pa_pages extends \gcalc\cprocess_calculation{

	
	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent, array $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->group = $group;
		$this->name = "pa_pages";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		
		$this->add_related_procesess();

		return $this;
	}

	function add_related_procesess( ){
		$cover_type = $this->cargs['pa_cover_type'];
		$parent = $this->parent;

		switch ($cover_type) {
			case 'hard':	
					$group_name = $this->group[0];
					$process_name = 'pa_' . $group_name .'_sewing';
					$parent->bvars['pa_sewing'] = true;
					$this->cargs['pa_sewing'] = true;
					$parent->add_todo_process( $this->cargs, array( $group_name,  $process_name )  );
				break;

				
			case 'section_sewn':	
					$group_name = $this->group[0];
					$process_name = 'pa_' . $group_name .'_sewing';
					$parent->bvars['pa_sewing'] = true;
					$this->cargs['pa_sewing'] = true;
					$parent->add_todo_process( $this->cargs, array( $group_name,  $process_name )  );
				break;
			
			default:
				# code...
				break;
		}

	}


	/**
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			
		$pf = $this->parent->get_best_production_format( $this->group );	
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		$markup_ = 1;		
		$production_cost = $sheets_quantity * 0;
		$total_price = $production_cost * $markup_;
		$grain = $pf['grain'];

		return $this->parse_total( 			
			array(				
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
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