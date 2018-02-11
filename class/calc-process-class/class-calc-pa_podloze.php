<?php 
namespace gcalc\calc;


class pa_podloze extends \gcalc\cprocess_calculation{

	/*
	* Price per kg of used paper
	*/
	private $paper;

	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		parent::__construct( $product_attributes, $product_id, $parent );
		$this->name = "pa_podloze";		
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
		$weight = $this->paper['weight'];
		$pf = $this->parent->get_best_production_format();		
		$sheet_price = $pf['format_sq'] / 1000000 * $c * $weight;
		$sheets_quantity = (int)($this->cargs['pa_naklad'] / $pf['PPP']) + ( $this->cargs['pa_naklad'] % $pf['PPP'] > 0 ? 1 : 0 );

		$markup_db = new \gcalc\db\product_markup( $this->cargs, $this->product_id, $this->name);
		$markup = $markup_db->get_markup();
		$total_price = $sheet_price * $sheets_quantity;
		$markup_ = $total_price * $markup['markup'];

		return $total_price + $markup_ ;
	}

	/*
	* Aquire used paper
	*/
	public function get_paper(){
		$production_paper_db = new \gcalc\db\production\paper();
		$paper_slug = $this->cargs['pa_podloze'];
		return $this->paper = $production_paper_db->get_paper( $paper_slug );
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