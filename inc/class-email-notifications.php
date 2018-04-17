<?php
namespace gcalc\calculations;

//$production_formats = new \gcalc\db\production\formats();

class email_notifications extends \gcalc\email_notifications {


	public function __construct( array $data, \WP_User $user ){
		parent::__construct( $data, $user );
	}



	/**
	 * In this specific context this function send messages as following:
	 *
	 *	- master full raport
	 *	- account raport - email of given user
	 *	- contractor raport - email from requst
	 * 
	 * @param  array|null $settings [description]
	 * @return [type]               [description]
	 */
	public function send( array $settings = NULL ) {
		
		$this->send_account_calculation_raport();
		$this->send_master_calculation_raport();
		$this->send_contractor_calculation_raport();
		
		//var_dump($a);
	}



	public function send_account_calculation_raport(){
		$phpmailer 		= $this->get_phpmailer();
		$pdf_data 		= $this->get_pdf_data();
		$post_data 		= $this->get_post_data();
		$h 				= $this->get_h();
		$owner_user 	= $this->get_owner_user();

		$calculation 	= $this->get_calculation();
		$cid 			= $calculation[ 'cid' ];

		$subject 		= \__( 'Calculation raport', 'gcalc-report-pdf' ) . ' #' . $cid;
		$body 			=  $post_data['account']['post_content'];
		$body 			.=  $this->get_owner_footer();

		$calculation_pdf_filename = basename( $pdf_data['account']['file'] );
		$production_formats = new \gcalc\db\production\formats();

		$phpmailer->From = 'gaad@localhost';
		$phpmailer->FromName = 'GcalcAPI';
		$phpmailer->Subject = $subject;
		$phpmailer->SingleTo = true;
		
		$phpmailer->AddAddress( $owner_user->user_email ); // the recipient's address
		$phpmailer->Body = $body;
		$phpmailer->AddAttachment( $pdf_data['account']['file'], $calculation_pdf_filename ); // add the attachment
		$a = $phpmailer->Send(); // the last thing - send the email
	}


	public function send_contractor_calculation_raport(){
		$phpmailer = $this->get_phpmailer();
		$pdf_data 	= $this->get_pdf_data();
		$post_data 	= $this->get_post_data();
		$h 	= $this->get_h();
		$calculation = $this->get_calculation();
		$cid = $calculation[ 'cid' ];

		$subject = \__( 'Calculation raport', 'gcalc-report-pdf' ) . ' #' . $cid;
		$body =  $post_data['contractor']['post_content'];
		$body .=  $this->get_owner_footer();


		$calculation_pdf_filename = basename( $pdf_data['contractor']['file'] );
		$production_formats = new \gcalc\db\production\formats();
		$masteradmin = $production_formats->get_masteradmin( 'notifications' );


		$phpmailer->From = 'gaad@localhost';
		$phpmailer->FromName = 'GcalcAPI';
		$phpmailer->Subject = $subject;
		$phpmailer->SingleTo = true;
		
		$phpmailer->AddAddress( $h[ 'contractor-email' ] ); // the recipient's address
		$phpmailer->Body = $body;
		$phpmailer->AddAttachment( $pdf_data['contractor']['file'], $calculation_pdf_filename ); // add the attachment
		$a = $phpmailer->Send(); // the last thing - send the email
	}


	public function send_master_calculation_raport(){
		$phpmailer = $this->get_phpmailer();
		$pdf_data 	= $this->get_pdf_data();
		$post_data 	= $this->get_post_data();
		$h 	= $this->get_h();
		$calculation = $this->get_calculation();
		$cid = $calculation[ 'cid' ];

		$subject 		= \__( 'Calculation raport', 'gcalc-report-pdf' ) . ' #' . $cid;
		$body 			=  $post_data['master']['post_content'];
		$body 			.=  $this->get_owner_footer();


		$calculation_pdf_filename = basename( $pdf_data['master']['file'] );
		$production_formats = new \gcalc\db\production\formats();
		$masteradmin = $production_formats->get_masteradmin( 'notifications' );


		$phpmailer->From = 'gaad@localhost';
		$phpmailer->FromName = 'GcalcAPI';
		$phpmailer->Subject = $subject; // subject
		$phpmailer->SingleTo = true;
		
		$phpmailer->AddAddress( 'master@localhost' ); // the recipient's address
		$phpmailer->Body = $body;
		$phpmailer->AddAttachment( $pdf_data['master']['file'], $calculation_pdf_filename ); // add the attachment
		$a = $phpmailer->Send(); // the last thing - send the email
	}


	public function get_phpmailer(){
		global $phpmailer; // define the global variable
		if ( !is_object( $phpmailer ) || !is_a( $phpmailer, 'PHPMailer' ) ) { // check if $phpmailer object of class PHPMailer exists
			// if not - include the necessary files
			require_once \ABSPATH . \WPINC . '/class-phpmailer.php';
			require_once \ABSPATH . \WPINC . '/class-smtp.php';
			$phpmailer = new \PHPMailer( true );
		}
		$phpmailer->ClearAttachments(); // clear all previous attachments if exist
		$phpmailer->ClearCustomHeaders(); // the same about mail headers
		$phpmailer->ClearReplyTos();
		$phpmailer->ClearAllRecipients();
		$phpmailer->ContentType = 'text/html'; // Content Type
		$phpmailer->IsHTML( true );
		$phpmailer->CharSet = 'utf-8';

		//other global configurations
		return $phpmailer;
	}


}