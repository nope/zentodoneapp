<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
// Pull the form data for registration
$name = (isset($_POST["name"]))?trim($_POST["name"]):"";
$email = (isset($_POST["email"]))?trim($_POST["email"]):"";
$subject = (isset($_POST["subject"]))?trim($_POST["subject"]):"";
$body = (isset($_POST["body"]))?trim($_POST["body"]):"";
$validation = new Validation();
$name = $validation->checkText('Name',$name,true);
$subject = $validation->checkText('Subject',$subject,true);
$message = $validation->checkText('Message Body',$body,true);
$to = 'nikki@geekdesigngirl.com';
$headers = 'From: '.$name.'<'.$email.'>
Reply-To: '.$email;
	if(!mail($to,'ZTDA Contact: '.$subject,$message,$headers)) {
		$session->message('<p class="error">There was an error sending your message. Please try again.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);
	} else {
		$session->message('<p class="success">You\'ve successfully sent your message. Thanks for getting in touch with Zen To Done App.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);
	}
?>