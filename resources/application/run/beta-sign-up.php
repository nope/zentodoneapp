<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
unset($_SESSION['signUp']);
// Pull the form data for registration
$username = (isset($_POST["username"]))?trim($_POST["username"]):"";
$password = (isset($_POST["password"]))?trim($_POST["password"]):"";
$confirm = (isset($_POST["confirm"]))?trim($_POST["confirm"]):"";
$email = (isset($_POST["email"]))?trim($_POST["email"]):"";
$invite_code = (isset($_POST["invite_code"]))?trim($_POST["invite_code"]):"";
$newsletter = (isset($_POST["newsletter"]))?trim($_POST["newsletter"]):"";
$_SESSION['signUp'] = array('username'=>$username,'email'=>$email,'invite_code'=>$invite_code,'newsletter'=>$newsletter); 

// Initialize objects
$user = new User();
$validate = new Validation();

// Validate input
if($validation->checkText('username',$username,true)) {
	$user->username = $validation->checkText('username',$username,true);
} else {
	unset($_SESSION['signUp']['username']);
}

$user->password = $validation->checkPasswords($password,$confirm);
$user->invite_code = $validation->checkText('Beta Invite Code',$invite_code,true);

if($validation->checkEmail($email)) {
	$user->email = $validation->checkEmail($email);
} else {
	unset($_SESSION['signUp']['email']);
}

// Check errors
if($validation->errors) {
	$message = join("<br />", $validation->errors);
	$session->message('<p class="error">'.$message.'</p>');
	redirect_to(SITE_URL.DS.'sign-up'.DS);	
} elseif(!$allow = User::beta_authenticate($user->email,$user->invite_code)) { // Check to see if they are in the db, which means they are part of the beta
	unset($_SESSION['signUp']);
	$session->message('<p class="error">This is a closed beta release. We are sorry for the inconvenience. Please sign up for our newsletter to be informed when Zen To Done App is released publicly.</p>');
	redirect_to(SITE_URL.DS.'sign-up'.DS);
} elseif($allow->username!='') {
	unset($_SESSION['signUp']);
	$session->message('<p class="error">You have already signed up for the beta release. Please login with your credentials.</p>');
	redirect_to(SITE_URL.DS.'login'.DS);
} elseif($user->update_fields($allow->id,array('username'=>$user->username,'password'=>$user->password,'newsletter'=>$newsletter,'register_date'=>date('Y-m-d')))) {
	if($user->initiate_tables($allow->id)) {
		unset($_SESSION['signUp']);
		$session->message('<p class="success">You have successfully registered!</p>');
		redirect_to(SITE_URL.DS.'login'.DS);
	} else {
		$session->message('<p class="success">There was a problem creating your account. Please try again or contact us.</p>');
		redirect_to(SITE_URL.DS.'sign-up'.DS);
	}
}

?>