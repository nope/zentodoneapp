<?php

require_once 'Database.php';

class User extends DatabaseObject {
	
	protected static $table_name='users';
	protected static $db_fields = array('id', 'username', 'password', 'email', 'first_name', 'last_name', 'register_date', 'last_login', 'newsletter', 'invite_code', 'invites_left', 'paid', 'week_start','timezone','date_format');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $email;
	public $register_date;
	public $last_login;
	public $newsletter;
	public $invite_code;
	public $invites_left;
	public $paid;
	public $week_start;
	public $timezone;
	public $date_format;
	public $errors=array();

	public static function beta_authenticate($email='',$invite_code='') {
		global $database;
		$email = $database->escape_value($email);
		$invite_code = $database->escape_value($invite_code);
		
		$sql = 'SELECT * FROM users WHERE email = "'.$email.'" AND invite_code = "'.$invite_code.'" LIMIT 1';
		$result = self::find_by_sql($sql);
		if(!empty($result)) {
			self::recordLastLogin($username);
			return array_shift($result);
		} else {
			return false;
		}
	}

	public static function authenticate($username='',$password='') {
		global $database;
		global $session;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
		
		$sql = 'SELECT * FROM users WHERE username = "'.$username.'" AND password = "'.$password.'" LIMIT 1';
		$result = self::find_by_sql($sql);
		if(!empty($result)) {
			self::recordLastLogin($username);
			return array_shift($result);
		} else {
			return false;
		}
	}
	
	public static function recordLastLogin($username) {
		global $database;
		$date = date('Y-m-d');
		$sql = 'UPDATE users SET last_login = "'.$date.'" WHERE username = "'.$username.'"';
		$database->query($sql);
	}
	
	public static function addInvitedUser($email) {
		global $database;
		// Need to write code to see if the email address is already present in the database
		$beta_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890'), 0, 16);
		$sql = 'INSERT INTO users (email,invite_code,invites_left) VALUES ("'.$email.'","'.$beta_code.'",5)';
		if($database->query($sql)) {
			return $beta_code;
		} else {
			return false;
		}
	}
	
	public static function addEmailsToDb($email) {
		global $database;
		// Need to write code to see if the email address is already present in the database
		$beta_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890'), 0, 16);
		$sql = 'REPLACE INTO users (email,invite_code,invites_left) VALUES ("'.$email.'","'.$beta_code.'",5)';
		if($database->query($sql)) {
			return $beta_code;
		} else {
			return false;
		}
	}
	
	public static function updateInvitesLeft($id,$i) {
		global $database;
		$sql = 'UPDATE users SET invites_left = '.$i.' WHERE id = '.$id.' LIMIT 1';
		if($database->query($sql)) {
			return true;
		} else {
			return false;
		}
	}
		
	public static function initiate_tables($user_id) {
		global $database;
		$create = "CREATE TABLE ".$user_id."_Tasks (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `item` VARCHAR(1000) NOT NULL, `date_added` DATE NOT NULL, `date_scheduled` DATE NOT NULL, `date_completed` DATE NOT NULL, `contexts` TEXT NOT NULL, `notes` TEXT NOT NULL, `big_rock` BOOL NOT NULL, `completed` BOOL NOT NULL, `archived` BOOL NOT NULL);";
		$create2 = "CREATE TABLE ".$user_id."_Contexts (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(100) NOT NULL, `task_id` INT(11) NOT NULL);";
		$created = $database->query($create);
		$created2 = $database->query($create2);
		if($created && $created2) {
			return true;
		}
		return false;
	}
	
	public function full_name() {
		if(isset($this->first_name) && isset($this->last_name)) {
			return $this->first_name . ' ' . $this->last_name;
		} else {
			return '';
		}
	}
	
	public function update_fields_by_username($username,$attributes) {
		global $database;
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE username=\"". $database->escape_value($username)."\"";
		$result = $database->query($sql);
		if($result) { return true; } else { return false; }
	}
	
	public function user_stats() {
		global $database;
		$sql = 'SELECT id FROM users';
		$result = $database->query($sql);
		$total = $database->num_rows($result);
		$sql2 = 'SELECT id FROM users WHERE register_date != "0000-00-00"';
		$result2 = $database->query($sql2);
		$total2 = $database->num_rows($result2);
		$sql3 = 'SELECT id FROM users WHERE newsletter = 1';
		$result3 = $database->query($sql3);
		$total3 = $database->num_rows($result3);
		return 'Total Users: <strong>'.$total.'</strong> | Active Users: <strong>'.$total2.'</strong> | Newsletter subscribers: <strong>'.$total3.'</strong>';
	}
	
}