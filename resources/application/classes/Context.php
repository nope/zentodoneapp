<?php

require_once 'Database.php';

class Context extends DatabaseObject {
	
	protected static $db_fields = array('id', 'name', 'task_id');
	public $id;
	public $name;
	public $task_id;
	public $errors=array();
	
	public function get_contexts($id=0) {
		global $database;
		$sql = 'SELECT name FROM '.$_SESSION['user_id'].'_Contexts WHERE task_id = '.$database->escape_value($id);
		$result = self::find_by_sql($sql);
		if(!empty($result)) {
			return $result;
		} else {
			return false;
		}
	}
	
	public function get_weight($name='') {
		global $database;
		$sql = 'SELECT name FROM '.$_SESSION['user_id'].'_Contexts WHERE name = "'.$database->escape_value($name).'"';
		$result = $database->query($sql);
		$weight = $database->num_rows($result);
		return $weight;
	}
	
	public static function find_by_name($name='') {
		global $database;
		$result = self::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Contexts WHERE name="'.$database->escape_value($name).'"');
		return !empty($result) ? array_shift($result) : false;
	}
		
	public function save() {
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function update_fields($id,$attributes) {
		global $database;
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".$_SESSION['user_id']."_Contexts SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	protected function create() {
		global $database;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".$_SESSION['user_id']."_Contexts (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	protected function update() {
		global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".$_SESSION['user_id']."_Contexts SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function delete_by_task($task_id) {
		global $database;
		$sql = "DELETE FROM ".$_SESSION['user_id']."_Contexts WHERE task_id=".$database->escape_value($task_id);
		
		return($database->query($sql)) ? true : false;
	}
	
}