<?php
include 'ztda-config.php';

if(!isset($_SESSION['user_id'])) {
	// user is not logged in
	
} else {
	// user is logged in.
	$user = User::find_by_id($_SESSION['user_id']);
	$home_link = DS.'home'.DS;
	if(empty($user->timezone)) {
		$timezone_message = '<p class="error">Please set your timezone in <a href="'.SITE_URL.DS.'account'.DS.'">your account</a>.</p>';
		defined('TODAY') ? null : define('TODAY', date('l, F j, Y'));
	} else {
		date_default_timezone_set($user->timezone);
		defined('TODAY') ? null : define('TODAY', date('l, F j, Y'));
	}
	defined('USER_DATE_FORMAT') ? 'mm/dd/yy' : define('USER_DATE_FORMAT', $user->date_format);
	if($user->week_start=='M') { 
		$week_start = 1;
		$week_range = getWeekRange($start, $end);    
		$sql_week_range = week_range_for_sql($start, $end);  
	} else {
		$week_start = 0;
		$week_range = getWeekRangeSunday(date('Y-m-d'));  
		$sql_week_range = getWeekRangeSundaySql(date('Y-m-d')); 
	}
}

// Login Code

if (isset($_POST['login']))	{
	// Check fields
	if (!isset($_POST['username']) or strlen($_POST['username']) == 0) {
		$error = 'Please enter your user name';
	} elseif (!isset($_POST['password']) or strlen($_POST['password']) == 0) {
		$error = 'Please enter your password';
	} else {
		$username = trim($_POST['username']);
		$password = sha1($_POST['password']);
		$found_user = User::authenticate($username,$password);
		//echo $found_user;
		if($found_user) {
			$session->login($found_user);
			redirect_to(SITE_URL.DS.'home'.DS);	
		} else {
			$session->message('<p class="error">Username/password combination is incorrect.</p>');
			redirect_to(SITE_URL.DS.'login'.DS);
		}
	}
}

// Beta Invite Signup Code
if(isset($_POST['betaSignUp'])) {
	include APP_DIR.DS.'run'.DS.'beta-sign-up.php';
}

// Inbox item add
if(isset($_POST['addInbox'])) {
	include APP_DIR.DS.'run'.DS.'add-inbox.php';
}

// Inbox item add
if(isset($_POST['addInboxDashboard'])) {
	include APP_DIR.DS.'run'.DS.'add-inbox.php';
}

// Account update
if(isset($_POST['submitAccount'])) {
	include APP_DIR.DS.'run'.DS.'submit-account.php';
}

// Send out invites
if(isset($_POST['submitEmails'])) {
	include APP_DIR.DS.'run'.DS.'send-invites.php';
}

// Save weekly plan
if(isset($_POST['submitPlan'])) {
	include APP_DIR.DS.'run'.DS.'submit-plan.php';
}

// Complete task
if(isset($_GET['complete'])) {
	$task_id = trim($_GET['complete']);
	$complete = Task::update_fields($task_id, array('completed'=>1,'date_completed'=>date('Y-m-d')));
	if($complete) {
		$session->message('<p class="success">You have successfully marked that task as completed.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);	
	} else {
		$session->message('<p class="error">There was an error completing that task.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);	
	}
}

// Archive task
if(isset($_GET['archive'])) {
	$task_id = trim($_GET['archive']);
	$archive = Task::update_fields($task_id, array('archived'=>1));
	if($archive) {
		$session->message('<p class="success">You have successfully archived that task.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);	
	} else {
		$session->message('<p class="error">There was an error archiving that task.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);	
	}
}

// Delete task
if(isset($_GET['delete'])) {
	$task_id = trim($_GET['delete']);
	$delete = Task::delete($_SESSION['user_id'].'_Tasks',$task_id);
	$delete2 = Context::delete_by_task($task_id);
	if($delete) {
		$session->message('<p class="success">You have successfully deleted that task.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);	
	} else {
		$session->message('<p class="error">There was an error deleting that task.</p>');
		redirect_to($_SERVER['HTTP_REFERER']);	
	}
}

// Send password link
if(isset($_POST['reset_password'])) {
	include APP_DIR.DS.'run'.DS.'reset-password.php';
}

// Reset password
if(isset($_POST['new_password'])) {
	include APP_DIR.DS.'run'.DS.'new-password.php';
}

// Send Contact Form
if(isset($_POST['sendContact'])) {
	include APP_DIR.DS.'run'.DS.'send-contact.php';
}

// Send Feedback Form
if(isset($_POST['sendFeedback'])) {
	include APP_DIR.DS.'run'.DS.'send-contact.php';
}

// Add Emails to Db
if(isset($_POST['addEmailsToDatabase'])) {
	include APP_DIR.DS.'run'.DS.'add-emails-to-db.php';
}

// Email Newsletter/Beta Invites
if(isset($_POST['sendBetaInvitesOut'])) {
	include APP_DIR.DS.'run'.DS.'send-beta-invites.php';
}


$page = isset($_GET['page']) ? $_GET['page'] : 'beta';

$page2 = isset($_GET['page2']) ? $_GET['page2'] : false;

$page3 = isset($_GET['page3']) ? $_GET['page3'] : false;

if(!empty($page2) && $page2!='#' && !empty($page3)) {
	switch($page2) {
		case 'contexts' :
			$contexts = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts WHERE name = "'.$page3.'"');
			$big_rocks = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE big_rock = 1 AND archived = 0 AND date_scheduled BETWEEN '.$sql_week_range);
			$inbox_items = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE date_scheduled != "'.date('y-m-d').'" AND big_rock = 0 AND completed = 0 ORDER BY id DESC');
			$labels = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts GROUP BY name ORDER BY name ASC');
			include 'pages/contexts.php';
			break;
		}
} elseif(!empty($page2) && $page2!='#' && empty($page3)) {
	if($page == 'reset-password') {
		$now = date('Y-m-d H:i:s');
		$reset = Password::find_by_url($page2);
		if($reset->expiry_date <= $now) {
			$session->message('<p class="error">That link is no longer valid. Please request a password reset again.</p>');
			redirect_to(SITE_URL.DS.'forgot-password'.DS);
		} 
		include 'pages/reset-password.php';
		die();
	}
	switch($page2) {
		case 'contexts' :
			$contexts = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts GROUP BY name');
			$big_rocks = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE big_rock = 1 AND date_scheduled BETWEEN '.$sql_week_range);
			$inbox_items = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE date_scheduled != "'.date('y-m-d').'" AND big_rock = 0 AND completed = 0 ORDER BY id DESC');
			$labels = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts GROUP BY name ORDER BY name ASC');
			include 'pages/all-contexts.php';
			break;
		}
} else {
switch($page) {
	case 'home' :
		if(!isset($_SESSION['user_id'])) { redirect_to(SITE_URL.DS.'login'.DS); }
		$mits = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE date_scheduled BETWEEN DATE_SUB("'.date('Y-m-d').'", INTERVAL 31 DAY) AND "'.date('Y-m-d').'" AND archived = 0 ORDER BY completed ASC, big_rock DESC, date_scheduled ASC');
		$big_rocks = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE big_rock = 1 AND completed = 0 AND date_scheduled BETWEEN '.$sql_week_range);
		$inbox_items = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE date_scheduled = "0000-00-00" AND big_rock = 0 AND completed = 0 ORDER BY id DESC');
		$labels = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts GROUP BY name ORDER BY name ASC');		
		include 'pages/dashboard.php';
		break;
	case 'inbox' :
		if(!isset($_SESSION['user_id'])) { redirect_to(SITE_URL.DS.'login'.DS); }
		$mits = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE archived = 0 AND completed = 0 AND date_scheduled = "0000-00-00" ORDER BY date_added ASC');
		$big_rocks = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE big_rock = 1 AND date_scheduled BETWEEN '.$sql_week_range);
		$labels = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts GROUP BY name ORDER BY name ASC');		
		include 'pages/inbox.php';
		break;
	case 'archive' :
		$mits = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE archived = 1 || completed = 1 ORDER BY date_scheduled ASC');
		$big_rocks = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE big_rock = 1 AND date_scheduled BETWEEN '.$sql_week_range);
		$inbox_items = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE date_scheduled = "0000-00-00" AND big_rock = 0 AND completed = 0 ORDER BY id DESC');
		$labels = Context::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts GROUP BY name ORDER BY name ASC');
		include 'pages/archive.php';
		break;
	case 'list' :
		include 'pages/list.php';
		break;
	case 'account' :
		if(!isset($_SESSION['user_id'])) { redirect_to(SITE_URL.DS.'login'.DS); }
		include 'pages/account.php';
		break;
	case 'admin-options' :
		if(!isset($_SESSION['user_id'])) { redirect_to(SITE_URL.DS.'login'.DS); }
		if($user->id!=1) { 
			$session->message('<p class="error">You are not authorized to view that page.</p>');
			redirect_to(SITE_URL.DS.'login'.DS); 
		}
		include 'pages/admin-options.php';
		break;
	case 'plan' :
		$mits = Task::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE  archived = 0 AND completed = 0 ORDER BY date_scheduled ASC');
		include 'pages/plan.php';
		break;
	case 'sign-up' :
		include 'pages/sign-up.php';
		break;
	case 'login' :
		include 'pages/login.php';
		break;
	case 'about' :
		include 'pages/about.php';
		break;
	case 'faq' :
		include 'pages/faq.php';
		break;
	case 'terms-and-conditions' :
		include 'pages/conditions.php';
		break;
	case 'contact' :
		include 'pages/contact.php';
		break;
	case 'feedback' :
		include 'pages/feedback.php';
		break;
	case 'forgot-password' :
		include 'pages/forgot-password.php';
		break;
	case 'logout' :
		if(isset($_POST['logout'])) {
			session_start();
			$_SESSION = array();
			if(isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time()-42000, '/');
			}
			session_destroy();
			include 'pages/logout.php';
		} else {
			include 'pages/login.php';
		}
		break;
	default :
		include 'pages/beta.php';
		break;
}
}

?>