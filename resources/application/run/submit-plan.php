<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';

// Pull the form data for registration
$date_scheduled = (isset($_POST["date_scheduled"]))?trim($_POST["date_scheduled"]):"";
$bigrock = (isset($_POST["bigrock"]))?trim($_POST["bigrock"]):"";
$task_id = (isset($_POST["task_id"]))?trim($_POST["task_id"]):"";
$submitting_page = (isset($_POST["submitting_page"]))?trim($_POST["submitting_page"]):"";

// Initialize objects
$task = new Task();
$validation = new Validation();

if(!$validation->errors && $task->update_fields($task_id,array('date_scheduled'=>$date_scheduled,'big_rock'=>$bigrock))) {
	$session->message('<p class="success">You have successfully saved your item.</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);
} else {
	$session->message('<p class="error">There was an error saving your item.</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);
}
?>