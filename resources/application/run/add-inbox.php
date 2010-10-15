<?php
include $_SERVER['DOCUMENT_ROOT'].'/ztda-config.php';

// Pull the form data for registration
$inbox_data = (isset($_POST["inbox"]))?trim($_POST["inbox"]):"";
$submitting_page = (isset($_POST["submitting_page"]))?trim($_POST["submitting_page"]):"";

// Initialize objects
$task = new Task();
$validate = new Validation();

// Make sure a free user still has space to add an item
// Removed during beta testing
/*if($user->paid==0 && !$task->can_save($user->id.'_Tasks')) {
	$session->message('<p class="error">You have a free account and are limited to 25 items at a time. Upgrade for unlimited items.</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);
}*/

// Validate input
if($item = $validation->checkText('Inbox item',$inbox_data,true)) {
	// let's find out if the user has added a scheduled date
	$task->date_added = date('Y-m-d');
	if(USER_DATE_FORMAT=='dd/mm/yy') {
		$pattern = "(([1-9]|0[1-9]|[12][0-9]|3[01])[/]([0-9][0-9]|[1-9])[/]([2][01][0-9][0-9]|[0-9][0-9]))"; 
		if(preg_match($pattern,$item,$matches)) {
			$new_string = preg_replace($pattern, '', $item);
			$task->date_scheduled = $matches[3].'-'.$matches[2].'-'.$matches[1];
		} elseif(preg_match("(([0-9][0-9]|[1-9])[/]([0-9][0-9]|[1-9]))",$item,$matches)) {
			$new_string = preg_replace('(([0-9][0-9]|[1-9])[/]([0-9][0-9]|[1-9]))', '', $item);
			$task->date_scheduled = date('Y').'-'.$matches[2].'-'.$matches[1];
		} else {
			$task->date_scheduled = '0000-00-00';
			$new_string = $item;
		}
	} else {
		$pattern = "(([1-9]|0[1-9]|1[012])[/]([1-9]|0[1-9]|[12][0-9]|3[01])[/]([2][01][0-9][0-9]|[0-9][0-9]))"; 
		if(preg_match($pattern,$item,$matches)) {
			$new_string = preg_replace($pattern, '', $item);
			$task->date_scheduled = $matches[3].'-'.$matches[1].'-'.$matches[2];
		} elseif(preg_match("(([1-9]|0[1-9]|1[012])[/]([0-9][0-9]|[1-9]))",$item,$matches)) {
			$new_string = preg_replace('(([1-9]|0[1-9]|1[012])[/]([0-9][0-9]|[1-9]))', '', $item);
			$task->date_scheduled = date('Y').'-'.$matches[1].'-'.$matches[2];
		} else {
			$task->date_scheduled = '0000-00-00';
			$new_string = $item;
		}
	}
	
	
	// then, let's see if the user has marked this as a big rock item
	if(preg_match('/bigrock/',$new_string,$rm)) {
		$task->big_rock = 1;
		$new_string = preg_replace('/bigrock/','',$new_string);
	} 
	
	if(preg_match_all('/@[a-zA-Z0-9_]+/',$new_string,$contexts)) {
		foreach($contexts as $context) :
			$context_array = preg_replace('/@/','',$context);
		endforeach;
		$new_string = preg_replace('/@[a-zA-Z0-9_]+/','',$new_string);
	}
	
	// and finally, we need to see if the user has added a note/description for the task
	if(preg_match('/\*[[:print:]]+\**/',$new_string,$desc)) {
		$notes = preg_replace('/\*\**/','',$desc);
		$task->notes = $notes[0];
		$new_string = preg_replace('/\*[[:print:]]+\**/','',$new_string);
	}
	
	$task->item = $new_string;
		
	// okay, everything's checked out. let's save the task
	if($task->save()) {
		
		
		
		// next, we need to see if the user has added any contexts/labels to this task
		foreach($context_array as $name) :
			$add_context = new Context();
			$add_context->name = $name;
			$add_context->task_id = $task->id;
			$add_context->save();
		endforeach; 

		$session->message('<p class="success">You have successfully saved your Inbox item.</p>');
		redirect_to(SITE_URL.DS.$submitting_page.DS);	
	} else {
		$session->message('<p class="error">There was a problem saving your Inbox item."</p>');
		redirect_to(SITE_URL.DS.$submitting_page.DS);	
	}
} else {
	$session->message('<p class="error">Your inbox item had formatting errors.</p>');
	redirect_to(SITE_URL.DS.$submitting_page.DS);
}


?>