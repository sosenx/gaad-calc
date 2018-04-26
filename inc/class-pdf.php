<?php 
namespace gcalc;



class gaadPdf extends \TCPDF {


	public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		parent::__construct( $orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa );
	

	}

	public function Footer(){
 		$this->SetY(-13);
		$this->SetFont('freesans', '', 7, '', true);
		$html = \gcalc\actions::calculation_pdf_Footer();





		// Print text using writeHTMLCell()
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	}
}



class pdf  {

	private $cid;
	private $table;
	private $content = '';
	private $PDF;
	private $parent_post_id;


 	public function __construct( $cid, $table = NULL, array $content = NULL, integer $parent_post_id ) {
 		
 		$this->set_cid( $cid );
 		$this->set_table( $table );
 		$this->set_content( $content );
		$this->set_parent_post_id( $parent_post_id );

		$this->pdf_basic_setup();
		
 	}

 	private function pdf_basic_setup(){
 		$this->PDF = new gaadPdf( 'P', 'mm', 'A4', true, 'UTF-8', false, false );

		// set document information
		$this->PDF->SetCreator( 'GAAD CALC API' );
		$this->PDF->SetAuthor('MCP');
		$this->PDF->SetTitle('');
		$this->PDF->SetSubject('');
		$this->PDF->SetKeywords('');
 		$this->PDF->setFontSubsetting(true);
		$this->PDF->SetFont('freesans', '', 8, '', true);


		$this->PDF->SetMargins(6, 8, 6);
		$this->PDF->SetHeaderMargin(0);
		$this->PDF->SetFooterMargin(0);

		// set auto page breaks
		$this->PDF->SetAutoPageBreak(TRUE, 20);


		$this->PDF->setPrintHeader(false);



		$this->PDF->setImageScale(\PDF_IMAGE_SCALE_RATIO);
		$this->PDF->AddPage();
 	}


 	public static function get_attachment_by_post_name( $post_name ) {
		$r = array();
 		global $wpdb;
      	$results = $wpdb->get_results( 
        	$q = "SELECT * FROM `wp_posts` WHERE `post_name` LIKE '" .$post_name. "%' AND `post_type` LIKE 'attachment' ORDER BY `ID` DESC",
        	\ARRAY_A );

      	$results['exists'] = !empty( $results );
     $results['q'] = $q;
      return $results;
    }

 	private function upload_calculation_pdf_as_media_lib_items( string $path, array $attr = NULL ){
 		$parent_post_id = $this->get_parent_post_id();
		$filename = basename( $path );
		$attachment_name = str_replace( '.pdf','', $filename );
		$attachment_exists = $this->get_attachment_by_post_name( $attachment_name );

		if ( $attachment_exists['exists'] ) {
			$delete_attachment_status = wp_delete_attachment( $attachment_exists[0]['ID'], true );			
		}

		$upload_file = \wp_upload_bits( $filename, null, file_get_contents($path) );
		if ( !$upload_file['error'] ) {
			$wp_filetype = \wp_check_filetype( $filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent' => $parent_post_id,
				'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attachment_id = \wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
			if (!\is_wp_error($attachment_id)) {
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				$attachment_data = \wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
				\wp_update_attachment_metadata( $attachment_id,  $attachment_data );
			}

		unlink( $path );

		return $upload_file;
		}
 	}


 	/**
 	 * create summary pdf for account
 	 * @param  [type] $parent_post_id [description]
 	 * @return [type]                 [description]
 	 */
 	public function account_calculation_pdf( $parent_post_id ) {
 		//var_dump( GCALC_DIR . $this->get_cid() .'-calc.pdf' );

		$calc_pdf_path = GCALC_DIR . $this->get_cid() . '-account.pdf';

		// Set some content to print
		$html = $this->get_content()[0];

		// Print text using writeHTMLCell()
		$this->PDF->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		 
		$this->PDF->Output( $calc_pdf_path, "F" );
		$uploaded = $this->upload_calculation_pdf_as_media_lib_items( $calc_pdf_path );

 		return $uploaded;
 	}


 	/**
 	 * create summary pdf for client
 	 * @param  [type] $parent_post_id [description]
 	 * @return [type]                 [description]
 	 */
 	public function contractor_calculation_pdf( $parent_post_id ) {
 		//var_dump( GCALC_DIR . $this->get_cid() .'-calc.pdf' );

 		$return_path = is_null( $return_path ) ? false : true;

		$calc_pdf_path = GCALC_DIR . $this->get_cid() . '-contractor.pdf';




		// Set some content to print
		$html = $this->get_content()[0];

		// Print text using writeHTMLCell()
		$this->PDF->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		 
		$this->PDF->Output( $calc_pdf_path, "F" );
		$uploaded = $this->upload_calculation_pdf_as_media_lib_items( $calc_pdf_path );

 		return $uploaded;
 	}


 	/**
 	 * create summary pdf for client
 	 * @param  [type] $parent_post_id [description]
 	 * @return [type]                 [description]
 	 */
 	public function master_calculation_pdf( $parent_post_id ) {
 		//var_dump( GCALC_DIR . $this->get_cid() .'-calc.pdf' );
		$this->PDF->setPrintFooter(false);
		$this->PDF->SetAutoPageBreak(TRUE, 5);

		$calc_pdf_path = GCALC_DIR . $this->get_cid() . '-master.pdf';

		// Set some content to print
		$html = $this->get_content()[0];
		$html = explode('<!--more-->', $html );

		// Print text using writeHTMLCell()
		$this->PDF->writeHTMLCell(0, 0, '', '', $html[0], 0, 1, 0, true, '', true);
		 
		// 2nd page
		$this->PDF->AddPage();
		//var_dump($html[1]);

		// Set some content to print
	//$html = '<h1>tutaj szczegółowe opisy procesów, surowych kosztów etc</h1>';

		// Print text using writeHTMLCell()
		$this->PDF->writeHTMLCell(0, 0, '', '', $html[1], 0, 1, 0, true, '', true);

		$this->PDF->Output( $calc_pdf_path, "F" );
		$uploaded = $this->upload_calculation_pdf_as_media_lib_items( $calc_pdf_path );

 		return $uploaded;
 	}


	/**/
	function set_content(  $content ){
		$this->content = $content;
	}

 	/**/
 	function set_table( string $table = NULL ){
 		$this->table =  GCALC_NAMESPACE . ( is_null( $table ) ?'_archives' : $table );
 	}
 	
	/**/
	function set_cid( string $cid ){
		$this->cid = $cid;
	}

	/**/
	function set_parent_post_id( integer $parent_post_id ){
		$this->parent_post_id = $parent_post_id;
	}
	

 	/**/
 	function get_cid( ){
 		return $this->cid;
 	}

 	/**/
 	function get_table( ){
 		return $this->table;
 	}

 	/**/
 	function get_content( ){
 		return $this->content;
 	}

 	/**/
 	function get_parent_post_id( ){
 		return $this->parent_post_id;
 	}

}