<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';

$id = (isset($_POST["id"]))?trim($_POST["id"]):"";
$notes = (isset($_POST["notes"]))?trim($_POST["notes"]):"";
$notes = trim($notes);
$notes = addslashes($notes);
$task = new Task();
if($task->update_fields($id,array('notes'=>$notes))) {
	echo stripslashes($notes);
}

?>