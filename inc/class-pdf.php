<?php 
namespace gcalc;

class pdf  {

	private $cid;
	private $table;
	private $content = '';
	private $PDF;


 	public function __construct( $cid, $table = NULL, array $content = NULL ) {
 		
 		$this->set_cid( $cid );
 		$this->set_table( $table );
 		$this->set_content( $content );

		$this->PDF = new \TCPDF( 'P', 'mm', 'A4', true, 'UTF-8', false, false );

		// set document information
		$this->PDF->SetCreator( 'GAAD CALC API' );
		$this->PDF->SetAuthor('MCP');
		$this->PDF->SetTitle('');
		$this->PDF->SetSubject('');
		$this->PDF->SetKeywords('');
 		$this->PDF->setFontSubsetting(true);
		$this->PDF->SetFont('helvetica', '', 10, '', true);
		$this->PDF->AddPage();
 	}


 	private function upload_calculation_pdf_as_media_lib_items( string $path, array $attr = NULL ){
		$filename = basename( $path );
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
		}
 	}

 	public function calculation(  ) {
 		//var_dump( GAAD_PLUGIN_TEMPLATE_DIR . $this->get_cid() .'-calc.pdf' );
 		$r = array( 'pdf' => true ); 

		$calc_basic_path = GAAD_PLUGIN_TEMPLATE_DIR . $this->get_cid() . '-calc.pdf';

		// Set some content to print
		$html = $this->get_content()[0];

		// Print text using writeHTMLCell()
		$this->PDF->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		 
		$this->PDF->Output( $calc_basic_path, "F" );
		$this->upload_calculation_pdf_as_media_lib_items( $calc_basic_path );


 		return $r;
 	}


	/**/
	function set_content(  $content ){
		$this->content = $content;
	}

 	/**/
 	function set_table( string $table = NULL ){
 		$this->table =  GAAD_PLUGIN_TEMPLATE_NAMESPACE . ( is_null( $table ) ?'_archives' : $table );
 	}
 	
	/**/
	function set_cid( string $cid ){
		$this->cid = $cid;
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


}