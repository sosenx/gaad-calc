<?php 
namespace gcalc\calc;


class pa_format extends \gcalc\cprocess_calculation{

	/**
	* net width
	*/
	private $width;

	/**
	* net height
	*/
	private $height;
	
	/**
	* best_production_format object
	*/
	private $best_production_format;


	function __construct( array $product_attributes, int $product_id, \gcalc\calculate $parent ){	
		parent::__construct( $product_attributes, $product_id, $parent );
		$this->name = "pa_format";		
		$this->cargs = $product_attributes;
		$this->dependencies = NULL;

		$this->parse_dimensions();
		$this->calculate_best_production_format();


		return $this;
	}

	/**
	*
	*/
	function calculate_best_production_format( ){	
		$production_formats = new \gcalc\db\production\formats();
		$all_formats = $production_formats->get_formats();
		$impose_ = array();

		foreach ($all_formats as $key => $value) {
			$impose_[$key] = array(
				'lg' => $this->impose(
					array( 'width' => $this->get_width(), 'height' => $this->get_height() ), // product net
					array( 'width' => $value['width'], 'height' => $value['height'] ) //format
				),
				'sg' => $this->impose(
					array( 'width' => $this->get_width(), 'height' => $this->get_height() ),
					array( 'width' => $value['height'], 'height' => $value['width'] )
				)
			);			
		}		

		$min_lost = array( array( 'piece_cost'=>10000 ) );
		foreach ($impose_ as $key => $value) {
			if ( $impose_[ $key ][ 'lg' ]['piece_cost'] < $min_lost[0]['piece_cost'] ) {
				array_unshift( $min_lost, $impose_[ $key ][ 'lg' ] );
			}
			if ( $impose_[ $key ][ 'sg' ]['piece_cost'] < $min_lost[0]['piece_cost'] ) {
				array_unshift( $min_lost, $impose_[ $key ][ 'sg' ] );
			}
		}
		$this->parent->set_best_production_format( $min_lost[0] );
		$this->best_production_format = $min_lost[0];		
	}

	/**
	* Do simple imposition and return math data
	*
	*/
	function impose( array $product_dim, array $format ){	
		$production_formats = new \gcalc\db\production\formats();
		$split = $production_formats->get_split( implode( "x", $product_dim ) );
		$prod_for_margins = $production_formats->get_prod_for_margins( implode( "x", $format ) );
		$click = $production_formats->get_click( implode( "x", $format ) );
		$print_sides = $this->get_print_sides(); //0-1side, 1-2sides
		$click_cost = $click[ $print_sides ];
		/*
		* Impose cols
		*/
		$w = 0;		
		$col_split = $split[0];
		$format_width = $format['width'] - ( $prod_for_margins['left'] + $prod_for_margins['right'] );
		$cols = (int)($format_width / ( $product_dim['width'] + $col_split ));		

		/*
		* Impose rows
		*/
		$h = 0;		 
		$row_split = $split[1];
		$format_height = $format['height'] - ( $prod_for_margins['top'] + $prod_for_margins['bottom'] );
		$rows = (int)( $format_height / ( $product_dim['height'] + $row_split ) );
				
		$impose_data = array(
			'format' => $this->str_dim_to_format( $format['width'] .'x'. $format['height'] ),
			'PPP' => $cols * $rows,
			'cols_width' => $cols * ( $col_split + $product_dim['width'] ),
			'rows_height' => $rows * ( $row_split + $product_dim['height'] ),
			'cols' => $cols,
			'rows' => $rows,
			'product_sq' => ( $product_dim['width'] + $col_split ) * ( $product_dim['height'] + $row_split ),
			'format_sq' => $format['width'] * $format['height'],
			'format_w' => $format['width'],
			'format_h' => $format['height']		
		);
		$impose_data[ 'lost_paper' ] = $impose_data['format_sq'] - ( $impose_data['product_sq'] * $impose_data['PPP'] );
		$impose_data[ 'lost_paper_per_piece' ] = $impose_data['lost_paper'] / $impose_data['PPP'];
		$impose_data[ 'piece_cost' ] = $click_cost / $impose_data['PPP'];
		$impose_data[ 'print_cost' ] = $click_cost;
		

		return $impose_data;
	}

	/**
	*
	*/
	function str_dim_to_format( string $format_str ){	
		$production_formats = new \gcalc\db\production\formats();
		$str_dim_to_format = $production_formats->get_str_dim_to_format( $format_str );

		return $str_dim_to_format;
	}

	/**
	*
	*/
	function do( ){	
		$this->ptotal = new \gcalc\ptotal( 0, "+", NULL, $this->name );
		$this->done = true;
		return $this->ptotal;
	}


	/**
	*
	*/
	function parse_dimensions( ){	
		$dim = explode( "x", $this->cargs['pa_format'] ); 
		$this->set_width((int)$dim[0]);
		$this->set_height((int)$dim[1]);		
	}

	/**
	* Getter for width
	*
	*/
	function get_width( ){			
		return $this->width;		
	}

	/**
	* Getter for height
	*
	*/
	function get_height( ){			
		return $this->height;		
	}
	/**
	* Setter for width
	*
	*/
	function set_width( $val ){			
		$this->width = $val;		
	}

	/**
	* Setter for height
	*
	*/
	function set_height( $val ){			
		$this->height = $val;		
	}

}


?>