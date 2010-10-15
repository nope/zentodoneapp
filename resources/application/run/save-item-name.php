<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
// Pull the form data for registration
$id = (isset($_POST["id"])) ? trim($_POST["id"]) : "";
$item = (isset($_POST["item"])) ? trim($_POST["item"]) : "";
$task = new Task();
$validation = new Validation();
$item = $validation->checkText('Item', $item, true);
if(!$validation->errors && $task->update_fields($id,array('item'=>$item))) {
	echo stripslashes($item);
} else {
	echo join(', ', $validation->errors);
}
?>