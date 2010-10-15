<?php

require_once 'Database.php';

class Password extends DatabaseObject {
	
	protected static $table_name='password_retrieval';
	protected static $db_fields = array('id', 'username', 'url', 'expiry_date');
	public $id;
	public $username;
	public $url;
	public $expiry_date;
	public $errors=array();
	
	public static function find_by_url($url='') {
		global $database;
		$result = self::find_by_sql('SELECT * FROM '.static::$table_name.' WHERE url="'.$database->escape_value($url).'"');
		return !empty($result) ? array_shift($result) : false;
	}

	public function sendResetPassword($username,$email) {
		global $database;
		$reset_link = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 16);
		$hour = date('H') + 1;
		$expiry_date = date('Y-m-d '.$hour.':i:s');
		$sql = 'INSERT INTO password_retrieval (username, url, expiry_date) VALUES ("'.$username.'","'.$reset_link.'","'.$expiry_date.'")';
		$result = $database->query($sql);
		if($result) {
			$subject = 'Your Password Reset Link for Zen To Done App';
			$headers = 'From: Zen To Done App <no-reply@zentodoneapp.com>';
			$message = 'Your password reset link is '.SITE_URL.DS.'reset-password'.DS.$reset_link.DS.'. You will have 1 hour to reset your password before this link is no longer valid.';
			if(!mail($email,$subject,$message,$headers)) {
				$session->message('<p class="error">There was an error sending the password reset link to your email address. Please try again.</p>');
				redirect_to(SITE_URL.DS.'forgot-password'.DS);
			} 
		} else {
			$session->message('<p class="error">We were unable to create a password link for you. This is probably temporary. Please try again in a few moments.</p>');
			redirect_to(SITE_URL.DS.'forgot-password'.DS);
		}
	}
	
	public function validUsernameLink($username,$url) {
		global $database;
		$result = self::find_by_sql('SELECT * FROM '.static::$table_name.' WHERE url="'.$database->escape_value($url).'" AND username = "'.$database->escape_value($username).'"');
		return !empty($result) ? array_shift($result) : false;
	}
	
}