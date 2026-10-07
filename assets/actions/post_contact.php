<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$captcha = $_POST['captcha'];
$message = $_POST['editor'];
$error = '';

if(empty($first_name)){
	$error .= 'Plase make sure to fill the first name field <br />';
}

if(empty($last_name)){
	$error .= 'Plase make sure to fill the last name field <br />';
}

if(empty($email)){
	$error .= 'Plase make sure to fill the email field <br />';
}

if(empty($message)){
	$error .= 'Plase make sure to fill the message field <br />';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $error .= 'Plase make sure to follow a proper email syntax <br />';
}

if (strlen($first_name) > 255) {
  $error .= 'First name is too long <br />';
}

if (strlen($first_name) < 2) {
  $error .= 'First name is too short <br />';
}

if (strlen($last_name) > 255) {
  $error .= 'Last name is too long <br />';
}

if (strlen($last_name) < 2) {
  $error .= 'Last name is too short <br />';
}

if (strlen($message) > 4000) {
  $error .= 'Message is too long <br />';
}

if (strlen($email) > 255) {
  $error .= 'Email is too long <br />';
}

if(empty($error) && $captcha == '15') {
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		//Server settings
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'server.alex77@gmail.com';                     //SMTP username
		$mail->Password   = 'rocmpyhftquyxasc';                               //SMTP password
		$mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = "ssl"`

		//Recipients
		$mail->setFrom('server.alex77@outlook.com', 'Budget-Layers');
		$mail->addAddress('server.alex77@gmail.com', 'Alexandre Lefebvre');     //Add a recipient
		$mail->addReplyTo($email, $name);
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//Attachments
		//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Message from Budget-Layers';
		$mail->Body    = $message;
		$mail->AltBody = $message;

		$mail->send();
		echo json_encode(array('code' => 'success', 'message' => 'The message was sent. Thank you for your input !<br /><br />'));
	} catch (Exception $e) {
		echo json_encode(array('code' => 'fail', 'message' => "Message could not be sent. Please send it manually to server.alex77@gmail.com. Mailer Error: {$mail->ErrorInfo}<br /><br />"));
	}
} else {
	echo json_encode(array('code' => 'fail', 'message' => $error."<br />"));
}

?>