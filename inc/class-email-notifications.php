<?php
namespace gcalc\calculations;

//$production_formats = new \gcalc\db\production\formats();

class email_notifications extends \gcalc\email_notifications {



	public function __construct( array $post_data, \WP_User $user ){
		parent::__construct( $post_data, $user );
	}



	public function send( array $settings = NULL ) {
		global $phpmailer; // define the global variable
		if ( !is_object( $phpmailer ) || !is_a( $phpmailer, 'PHPMailer' ) ) { // check if $phpmailer object of class PHPMailer exists
			// if not - include the necessary files
			require_once \ABSPATH . \WPINC . '/class-phpmailer.php';
			require_once \ABSPATH . \WPINC . '/class-smtp.php';
			$phpmailer = new \PHPMailer( true );
		}


		$post_data = $this->get_post_data();

		


		$phpmailer->ClearAttachments(); // clear all previous attachments if exist
		$phpmailer->ClearCustomHeaders(); // the same about mail headers
		$phpmailer->ClearReplyTos(); 
		$phpmailer->From = 'gaad@localhost';
		$phpmailer->FromName = 'Gaad';
		$phpmailer->Subject = 'Plugin: ' ; // subject
		$phpmailer->SingleTo = true;
		$phpmailer->ContentType = 'text/html'; // Content Type
		$phpmailer->IsHTML( true );
		$phpmailer->CharSet = 'utf-8';
		$phpmailer->ClearAllRecipients();
		$phpmailer->AddAddress( 'gaad1@localhost' ); // the recipient's address
		$phpmailer->Body = $post_data['contractor']['post_content'];
		//$phpmailer->AddAttachment(getcwd() . '/plugins/' . $plugin_name . '.zip', $plugin_name . '.zip'); // add the attachment
		$a = $phpmailer->Send(); // the last thing - send the email
		//var_dump($a);
	}






}