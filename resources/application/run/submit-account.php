<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';

// Pull the form data for registration
$user_id = (isset($_POST["id"]))?trim($_POST["id"]):"";
$username = (isset($_POST["username"]))?trim($_POST["username"]):""; 
$first_name = (isset($_POST["first_name"]))?trim($_POST["first_name"]):"";
$last_name = (isset($_POST["last_name"]))?trim($_POST["last_name"]):"";
$email = (isset($_POST["email"]))?trim($_POST["email"]):"";
$password = (isset($_POST["password"]))?trim($_POST["password"]):"";
$confirm = (isset($_POST["confirm"]))?trim($_POST["confirm"]):"";
$newsletter = (isset($_POST["newsletter"]))?trim($_POST["newsletter"]):"";
$week_start = (isset($_POST["week_start"]))?trim($_POST["week_start"]):"";
$timezone = (isset($_POST["timezone"]))?trim($_POST["timezone"]):"";
$date_format = (isset($_POST["date_format"]))?trim($_POST["date_format"]):"";
$submitting_page = (isset($_POST["submitting_page"]))?trim($_POST["submitting_page"]):"";

// Initialize objects
$profile = new User();
$validate = new Validation();

// Validate input
$profile->first_name = $validate->checkText('First name',$first_name,false);
$profile->last_name = $validate->checkText('Last name',$last_name,false);
$profile->email = $validate->checkEmail($email);
$profile->newsletter = $newsletter;
$profile->id = $user_id;
$profile->username = $user->username;
$profile->last_login = $user->last_login;
$profile->register_date = $user->register_date;
$profile->invite_code = $user->invite_code;
$profile->invites_left = $user->invites_left;
$profile->week_start = $week_start;
$profile->paid = $user->paid;
$profile->timezone = $timezone;
$profile->date_format = $date_format;
if(!empty($password)) {
	$profile->password = $validate->checkPasswords($password,$confirm);
} else {
	$profile->password = $user->password;
}

$_SESSION['user_input'] = array (
	'first_name' => $profile->first_name,
	'last_name' => $profile->last_name,
	'email' => $profile->email,
	'week_start' => $profile->week_start,
	'timezone' => $profile->timezone,
	'date_format' => $profile->date_format
);

if(!$validate->errors && $profile->save()) {
	$session->message('<p class="success">You\'ve successfully updated your account.</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);
} else {
	$session->message('<p class="error">'.join(',',$validate->errors).'</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);
}


?>