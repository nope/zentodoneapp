<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';
// Pull the form data for registration
$id = (isset($_POST["id"])) ? trim($_POST["id"]) : "";
$context_string = (isset($_POST["context"])) ? trim($_POST["context"]) : "";
$validation = new Validation();


if(preg_match_all('/@[a-zA-Z0-9_]+/',$context_string,$contexts)) {
	foreach($contexts as $context) :
		//$context = $validation->checkText('Context',$context,false);
		$context_array = preg_replace('/@/','',$context);
	endforeach;
}

if(!$validation->errors) {
	
	foreach($context_array as $name) :
		$add_context = new Context();
		$add_context->name = $name;
		$add_context->task_id = $id;
		$add_context->save();
	endforeach; 
	echo '&nbsp;<script type="text/javascript">window.location= ""</script>';
} else {
	echo join(', ', $validation->errors);
}
?>