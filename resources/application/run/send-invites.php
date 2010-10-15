<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
$i=0;
// Pull the form data for registration
$id = $user->id;
$emails = (isset($_POST["invite_emails"])) ? trim($_POST["invite_emails"]) : "";
$submitting_page = (isset($_POST["submitting_page"]))?trim($_POST["submitting_page"]):"";
$updateUser = new User();
$validation = new Validation();
$subject = $user->first_name.' '.$user->last_name.' thinks you would enjoy Zen To Done App!';
$headers = 'From: '.$user->email.'
Reply-To: '.$user->email;
$remove_space = str_replace(' ','',$emails);
$email_array = explode(',',$remove_space);
foreach($email_array as $email) :
	if($validation->checkEmail($email)) {
		$beta_code = User::addInvitedUser($email);
		$message = $user->first_name.' '.$user->last_name.' is using Zen To Done App. They think you would enjoy it and have invited you to the Beta release. You may sign up here: '.SITE_URL.DS.'sign-up'.DS.'
Your beta invite code is: '.$beta_code.'
As we said, Zen To Done App is in beta and we want to improve it with your help. You\'ll notice a little FEEDBACK link in the footer on every page and we hope you\'ll use it! We look forward to your feedback!';
		if(!mail($email,$subject,$message,$headers)) {
			$session->message('<p class="error">There was an error sending out your invitations. Please try again.</p>');
			redirect_to(SITE_URL.DS.$submitting_page.DS);
		} else {
			$i++;
		}
	} else {
		$session->message('<p class="error">There was an error with the email address '.$email.'. Please try again.</p>');
		redirect_to(SITE_URL.DS.$submitting_page.DS);
	}
endforeach;

	$update_invites_left = User::updateInvitesLeft($user->id,($user->invites_left - $i));

	$session->message('<p class="success">You\'ve successfully sent out your invitations. Thank you for spreading the news!</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);

?>