<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
unset($_SESSION['signUp']);
// Pull the form data for registration
$username = (isset($_POST["username"]))?trim($_POST["username"]):"";
$email = (isset($_POST["email"]))?trim($_POST["email"]):"";

// Initialize objects
$password = new Password();
$validate = new Validation();

// Validate input
if(!$validation->checkValidUser($username,$email)) {
	$message = join("<br />", $validation->errors);
	$session->message('<p class="error">'.$message.'</p>');
	redirect_to(SITE_URL.DS.'forgot-password'.DS);
} 

if(!$validation->checkEmail($email)) {
	$message = join("<br />", $validation->errors);
	$session->message('<p class="error">'.$message.'</p>');
	redirect_to(SITE_URL.DS.'forgot-password'.DS);
} 

// Check errors
if($validation->errors) {
	$message = join("<br />", $validation->errors);
	$session->message('<p class="error">'.$message.'</p>');
	redirect_to(SITE_URL.DS.'forgot-password'.DS);	
} else {
	$password->sendResetPassword($username,$email);
	$session->message('<p class="success">Your password reset link has been emailed to <strong>'.$email.'</strong>. Please check your spam folder and add <em>no-reply@zentodoneapp.com</em> to your white list if you haven\'t received your email within 5 minutes.</p>');
	redirect_to(SITE_URL.DS.'forgot-password'.DS);
}

?>