<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

	$mail = new PHPMailer;

	$mail->isSMTP();
	$mail->SMTPDebug = false;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtps.aruba.it';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;

	$mail->Username = 'tecnico@mcassistance.it';
	$mail->Password = 'Anna25Elena17';
	$mail->setFrom('tecnico@mcassistance.it', 'TEST PHP');
	$mail->addAddress('gatta.andrea01@gmail.com'); //call this multiple times for multiple recipients
	$mail->Subject = 'test php';
	$mail->msgHTML('<h3>Hello World</h3>');
	$mail->AltBody = 'alternative body if html fails to load';
	//$mail->addAttachment('/path/to/file/); //OPTIONAL attachment

	if (!$mail->send()) {
	    echo "Mailer Error: ";
	    echo $mail->ErrorInfo;
	} else {
	    echo "Email sent";
	}
?>