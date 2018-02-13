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
	* Calculates format costs (no costs in this case)
	*/
	function calc(){			
		$pf = $this->parent->get_best_production_format();	
		$sheets_quantity = (int)($this->cargs['pa_naklad'] / $pf['PPP']) + ( $this->cargs['pa_naklad'] % $pf['PPP'] > 0 ? 1 : 0 );
		$markup_ = 1;		
		$production_cost = $sheets_quantity * 0;
		$total_price = $production_cost * $markup_;
		$grain = $pf['format_w'] > $pf['format_h'] ? 'SG' : 'LG';

		return $this->parse_total( 			
			array(
				'production_cost' => $production_cost,
				'total_price' => $total_price,
				'markup_value' => $total_price - $production_cost,
				'markup' => $markup_
			),
			array(				
				'sheets_quantity' => $sheets_quantity,
				'production_format_short' => $pf['format'] .' '. $grain .' (' . $pf['format_w'] .'x'. $pf['format_h'] . ')',
				'production_format' => $pf
			)
		);
	}

	/**
	* Calculates best production format fit
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

		$min_lost = array( array( 'factor'=>15000000 ) );
		foreach ($impose_ as $key => $value) {

			if ( $impose_[ $key ][ 'lg' ]['factor'] < $min_lost[0]['factor'] ) {
				array_unshift( $min_lost, $impose_[ $key ][ 'lg' ] );
			}
			if ( $impose_[ $key ][ 'sg' ]['factor'] < $min_lost[0]['factor'] ) {
				array_unshift( $min_lost, $impose_[ $key ][ 'sg' ] );
			}	
		}
		
		$max_pieces = 0;
		$max_pieces_format = false;
		foreach ($min_lost as $key => $value) {
		
			if ( !isset($value['PPP']) ) {
				continue;
			}

			if ( $value['PPP'] > $max_pieces ) {
				$max_pieces = $value['PPP'];
				$max_pieces_format = $value;
			}
		}

		$min_lost_best = $max_pieces_format;

		$this->parent->set_best_production_format( $min_lost_best );
		$this->best_production_format = $min_lost_best;		
	}

	/**
	* Do simple imposition and return math data
	*
	*/
	function impose( array $product_dim, array $format ){	
		$production_formats = new \gcalc\db\production\formats();
		$print_color_mode = $this->get_print_color_mode('pa_zadruk');
		$split = $production_formats->get_split( implode( "x", $product_dim ), $print_color_mode );
		
		
		$prod_for_margins = $production_formats->get_prod_for_margins( implode( "x", $format ), $print_color_mode );
		$click = $production_formats->get_click( implode( "x", $format ), $print_color_mode );
		$print_sides = $this->get_print_sides(); //0-1side, 1-2sides
		$print_color_mode = $this->get_print_color_mode('pa_zadruk');
		$click_cost = $click[ $print_sides ];
		/*
		* Impose
		*/
		$w = 0;		
		$col_split = $split[0];
		$h = 0;		 
		
		$row_split = $split[1];
		$format_width = $format['width'] - ( $prod_for_margins['left'] + $prod_for_margins['right'] );
		$format_height = $format['height'] - ( $prod_for_margins['top'] + $prod_for_margins['bottom'] );
		$format_str = $this->str_dim_to_format( $format['width'] .'x'. $format['height'] );
		$cols = (int)($format_width / ( $product_dim['width'] + $col_split ));		
		$rows = (int)($format_height / ( $product_dim['height'] + $row_split ));		 
	
		$cols_width = $cols * ( $col_split + $product_dim['width'] );
		$rows_height= $rows * ( $row_split + $product_dim['height'] );
		$impose_data = array(
			'format' => $format_str,
			'PPP' => $cols * $rows,
			'cols_width' =>  $cols_width,
			'rows_height' => $rows_height,
			'cols' => $cols,
			'rows' => $rows,
			'product_sq' => ( $product_dim['width'] + $col_split ) * ( $product_dim['height'] + $row_split ),
			'format_sq' => $format['width'] * $format['height'],
			'format_w' => $format['width'],
			'format_h' => $format['height']		
		);

		if ( $impose_data['PPP'] === 0 ) {
			$impose_data['PPP'] = 1;
		}
		$impose_data[ 'lost_paper' ] = $impose_data['format_sq'] - ( $impose_data['product_sq'] * $impose_data['PPP'] );
		$impose_data[ 'lost_paper_per_piece' ] = $impose_data['lost_paper'] / $impose_data['PPP'];
		$impose_data[ 'piece_cost' ] = $click_cost / $impose_data['PPP'];
		$impose_data[ 'print_cost' ] = $click_cost;
		$impose_data[ 'factor' ] =  ($impose_data[ 'lost_paper_per_piece' ] + $impose_data[ 'piece_cost' ]) / $impose_data[ 'PPP' ];
		$impose_data[ 'factor' ] = $impose_data[ 'factor' ] < 0 ? 10000000 :  $impose_data[ 'factor' ];
		
		$impose_data[ 'prod_for_margins' ] = $prod_for_margins;
		$impose_data[ 'col_split' ] = $col_split;
		$impose_data[ 'row_split' ] = $row_split;

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
		$this->ptotal = new \gcalc\ptotal( $this->calc(), "+", NULL, $this->name );
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