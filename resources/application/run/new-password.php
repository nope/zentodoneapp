<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
// Pull the form data for registration
$username = (isset($_POST["username"]))?trim($_POST["username"]):"";
$password = (isset($_POST["password"]))?trim($_POST["password"]):"";
$confirm = (isset($_POST["confirm"]))?trim($_POST["confirm"]):"";
$url = (isset($_POST["url"]))?trim($_POST["url"]):"";

// Initialize objects
$new_password = new Password();
$user = new User();
$validate = new Validation();

$user->password = $validation->checkPasswords($password,$confirm);

// Make sure the username matches the URL sent to the email address
if(!$new_password->validUsernameLink($username,$url)) {
	$session->message('<p class="error">That username is not associated with this reset link.</p>');
	redirect_to(SITE_URL.DS.'reset-password'.DS.$url.DS);
} else {
	$new_password->username = $validation->checkText('username',$username,true);
}


// Check errors
if($validation->errors) {
	$message = join("<br />", $validation->errors);
	$session->message('<p class="error">'.$message.'</p>');
	redirect_to(SITE_URL.DS.'reset-password'.DS.$url.DS);	
} elseif($user->update_fields_by_username($new_password->username,array('password'=>$user->password))) {
	$session->message('<p class="success">You have successfully reset your password. You may now <a href="'.SITE_URL.DS.'login'.DS.'">log in</a>.');
	redirect_to(SITE_URL.DS.'reset-password'.DS.$url.DS);
} else {
	$message = join("<br />", $validation->errors);
	$session->message('<p class="error">'.$message.'</p>');
	redirect_to(SITE_URL.DS.'reset-password'.DS.$url.DS);
}

?>