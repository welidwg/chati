<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailerPHPMailerPHPMailer;
use PHPMailerPHPMailerException;

class PhpmailerController extends Controller
{
    public function sendEmail ($email,$subject,$body) {
  	
  	// is method a POST ?

			require '../vendor/autoload.php'; // load Composer's autoloader

			$mail = new \PHPMailer\PHPMailer\PHPMailer(true); // Passing `true` enables exceptions

			try {

				// Mail server settings

				$mail->isSMTP(); // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
				$mail->SMTPAuth = true; // Enable SMTP authentication
				$mail->Username = 'CliniqueManager@gmail.com'; // SMTP username
				$mail->Password = 'Barcelona1899'; // SMTP password
				$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587; // TCP port to connect to

				$mail->setFrom('CliniqueManager@gmail.com', 'Chati');
				$mail->addAddress($email); // Add a recipient, Name is optional
				/*$mail->addCC($_POST['email-cc']);
				$mail->addBCC($_POST['email-bcc']);
				$mail->addReplyTo('your-email@gmail.com', 'Your Name');*/
				// print_r($_FILES['file']); exit;

				/*for ($i=0; $i < count($_FILES['file']['tmp_name']) ; $i++) { 
					$mail->addAttachment($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]); // Optional name
				}*/

				$mail->isHTML(true); // Set email format to HTML

				$mail->Subject = $subject;
				$mail->Body= $body;
				// $mail->AltBody = plain text version of your message;

				if( !$mail->send() ) {
			    return 0;
				} else {
					return 1;
				}

			} catch (Exception $e) {
				// return back()->with('error','Message could not be sent.');
                return 10;
			}
		
  }
}
