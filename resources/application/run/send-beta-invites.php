<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
$i=0;
// Pull the form data for registration
$emails = (isset($_POST["user_id"])) ? $_POST["user_id"] : "";
$email_body = (isset($_POST["emailBody"])) ? trim($_POST["emailBody"]) : "";
$submitting_page = (isset($_POST["submitting_page"]))?trim($_POST["submitting_page"]):"";
$validation = new Validation();
$email_body = $validation->checkMessage('Email Message',$email_body,false);
$subject = 'Zen To Done App Beta Invitation';
$headers = 'From: ZenToDoneApp.com <no-reply@zentodoneapp.com>';
foreach($emails as $email) :
	$new_user = User::find_by_id($email);
	$message = 
'Your Beta Invite Code is: '.$new_user->invite_code.'
You may sign up for your account here: '.SITE_URL.DS.'sign-up'.DS.'

';
	$message .= stripslashes($email_body);
		if(!mail($new_user->email,$subject,$message,$headers)) {
			$session->message('<p class="error">There was an error sending out your invitation to '.$new_user->email.'. Please try again.</p>');
			redirect_to(SITE_URL.DS.$submitting_page.DS);
		} else {
			$i++;
		} 
endforeach;

	$session->message('<p class="success">You\'ve successfully sent out your invitations. Thank you for spreading the news!</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);

?>