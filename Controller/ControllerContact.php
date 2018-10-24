<?php


/*LOAD ROUTE ACTION*/
$controller->addAction('mail',false,false);

class ControllerContact{

	public static function mail(){
		if(!empty($_POST['content']) && !empty($_POST['subject'])){
			$to      = 'admin@survive-in-hell.fr';
			$subject = $_POST['subject'];
			$headers = 'From: '.$mail ."\r\n" .
			'Reply-To: '.$mail . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		    mail($to, $subject,$_POST['content'], $headers);
		}
	}
}