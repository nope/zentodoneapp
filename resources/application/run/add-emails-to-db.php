<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
$i=0;
// Pull the form data for registration
$id = $user->id;
$emails = (isset($_POST["database_emails"])) ? trim($_POST["database_emails"]) : "";
$submitting_page = (isset($_POST["submitting_page"]))?trim($_POST["submitting_page"]):"";
$updateUser = new User();
$validation = new Validation();
$remove_space = str_replace(' ','',$emails);
$email_array = explode(',',$remove_space);
$error = '';
foreach($email_array as $email) :
		$beta_code = User::addEmailsToDb($email);
		if(!$beta_code) {
			$error .= $email;
		} else {
			$i++;
		}
endforeach;
	
	if(!empty($error)) {
		$errors = join(',',$error);
		$session->message('<p class="error">There was an error with the following email addresses<br />'.$errors.'<br />Please manually add them.</p>');
	} else {
		$session->message('<p class="success">You\'ve successfully added those emails to the database.</p>');
	}
	redirect_to(SITE_URL.DS.$submitting_page.DS);

?>