<?php

class Validation {

	public $errors = array();

	public function checkPasswords($password,$confirm) {
		if($password == '') {
			$this->errors[] = "You cannot leave the password field blank.";
			return false;
		} elseif($confirm == '') {
			$this->errors[] = "Please verify your password.";
			return false;
		} elseif($password != $confirm) {
			$this->errors[] = "Your passwords do not match.";
			return false;
		} elseif($password == $confirm) {
			if((strlen($password) < 8) || (strlen($password) > 32)) {
				$this->errors[] = "Your password must be between 8 - 32 characters.";
				return false;
			} else {
				return $this->password = sha1($password);
			}
 		}
	} 
	
	public function checkText($field,$text,$required=false) {
		if($text=='' && $required==true) {
			$this->errors[] = "The ".$field." field cannot be blank.";
			return false;
		} else {
			$text = nl2br($text);
			$slashes = addslashes($text);
			$filtered = strip_tags($slashes, '<p><strong><em><a><h1><h2><h3><font><img><ul><ol><li><hr><span>');
			return $this->text = $filtered;
		}
	}
	
	public function checkMessage($field,$text,$required=false) {
		if($text=='' && $required==true) {
			$this->errors[] = "The ".$field." field cannot be blank.";
			return false;
		} else {
			$text = nl2br($text);
			$slashes = addslashes($text);
			$filtered = strip_tags($slashes, '<p><strong><em><a><h1><h2><h3><font><img><ul><ol><li><hr><span>');
			return $this->text = $filtered;
		}
	}
	
	public function checkHTML($field,$text,$required=false) {
		if($text=='' && $required==true) {
			$this->errors[] = "The ".$field." field cannot be blank.";
			return false;
		} else {
			$text = nl2br($text);
			$slashes = addslashes($text);
			$filtered = strip_tags($slashes, '<p><strong><em><a><h1><h2><h3><font><img><ul><ol><li><hr><span>');
			return $this->text = $filtered;
		}
	}
	
	public function checkValidDate($field,$date,$required=true) {
		if($date=='' && $required==true) {
			$this->errors[] = "The ".$field." field cannot be blank.";
			return false;
		} else {
			$newdate = explode('-',$date);
			if(!checkdate($newdate[1],$newdate[2],$newdate[0])) {
				$this->errors[] = "The ".$field." field is not in a valid format. Please make sure the date is formatted correctly: YYYY-MM-DD.";
			} else {
				return $this->text = $date;
			}
		}
	}
	
	public function checkEmail($email) {
  		// checks proper syntax
  		if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\.+_-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
  			$this->errors[] = "Your email address is not in the correct format. Please be sure to use a valid email address.";
   	 		return false;
  		} else {
  			return $this->email = $email;
  		}  
  	}
  	
  	public function checkValidUser($username,$email) {
		global $database;
		$sql = 'SELECT username,email FROM users WHERE username = "'.$username.'" AND email = "'.$email.'"';
		$result = $database->query($sql);
		if($database->num_rows($result)==1) {
			return true;
		} else {
			$this->errors[] = 'That username/email address is not in our system.';
		}
	}

}

$validation = new Validation();

?>