<?php 
namespace gcalc\calc;


class pa_paper extends \gcalc\cprocess_calculation{

	/*
	* Price per kg of used paper
	*/
	private $paper;

	function __construct( $product_attributes, $product_id, \gcalc\calculate $parent, $group, \gcalc\cprocess $pa_parent ){	
		parent::__construct( $product_attributes, $product_id, $parent, $group, $pa_parent );
		$this->name = "pa_paper";		
		$this->group = $group;
		$this->product_id = $product_id;
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;
		
		$this->get_paper();
		

		return $this;
	}

	
		
	/**
	* Calculates paper cost and margin
	*/
	function calc(){		
		$c = $this->paper['price_per_kg'];
		$group_name = $this->get_group()[0];
		$weight = $this->paper['weight'];
		$pf = $this->parent->get_best_production_format( $this->group );		
		$sheet_cost = $pf['format_sq'] / 1000000 * $c * $weight;
		$sheets_quantity = (int)($this->cargs['pa_quantity'] / $pf['pieces']) + ( $this->cargs['pa_quantity'] % $pf['pieces'] > 0 ? 1 : 0 );
		$pages = $this->get_pages( );
		
		/**
		 * outside markup source (prom requst attributes)		  
		 */
		$group = $this->get_group();
		$markup_attr_name = 'markup_' . str_replace( 'pa_', '', $group[1] );
		$overridden_markup_value = (int)$this->get_carg( $markup_attr_name ) / 100;

		if ( is_null( $overridden_markup_value ) ) {
			$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this);
			$markup = $markup_db->get_markup();
			$markup_ = $markup['markup'];		
		} else {	
			$markup_ = $overridden_markup_value;
		}
	

		$production_cost = $sheet_cost * $sheets_quantity * $pages;//* (int)$this->cargs['pa_quantity'];
		$total_price = $production_cost * $markup_;

		$production_format_short = $pf['format'] . ' ' . $pf['grain'];
		$common_format_short = $pf['common_format']['name'] . ' ' . $pf['common_format']['grain'];

		return $this->parse_total( 
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(
				'sheet_cost' => $sheet_cost,
				'sheets_quantity' => $sheets_quantity * $pages,
				'paper' => $this->paper,
				'production_format_short' => $production_format_short,
				'common_format_short' => $common_format_short,
				'pages' => $pages
			)
		);
	}

	/*
	* Aquire used paper
	*/
	public function get_paper(){
		$group = $this->get_group();
		$production_paper_db = new \gcalc\db\production\paper();		
		$paper_slug = array_key_exists( $group[1], $this->cargs ) ? $this->cargs[$group[1]] : '*';
		if ($paper_slug === '*' && preg_match('/_master_/', $group[1])) {
			$master_paper = str_replace('_master', '', $group[1]);
			$paper_slug = array_key_exists( $master_paper, $this->cargs ) ? $this->cargs[$master_paper] : '*';	
		}
		$paper = $production_paper_db->get_paper( $paper_slug );
		


		return $this->set_paper( $paper );
	}

	/**
	*
	*/
	function do__( ){	
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->get_name() );
		$this->done = true;
		return $this->ptotal;
	}
	

	/**
	*
	*/
	function set_paper( $paper ){	
		$this->paper = $paper;
	}
	

}


?>