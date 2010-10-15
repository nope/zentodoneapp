<?php

require_once 'Database.php';

class Task extends DatabaseObject {
	
	protected static $db_fields = array('id', 'item', 'date_added', 'date_scheduled', 'date_completed', 'contexts', 'notes', 'big_rock', 'completed', 'archived');
	public $id;
	public $item;
	public $date_added;
	public $date_scheduled;
	public $date_completed;
	public $contexts;
	public $notes;
	public $big_rock;
	public $completed;
	public $archived;
	public $errors=array();
	
	public function can_save() {
		global $database;
		$sql = 'SELECT id FROM '.$_SESSION['user_id'].'_Tasks';
		$result = $database->query($sql);
		$num = $database->num_rows($result);
		return ($num<25) ? true : false;
	}
	
	public static function find_by_id($id=0) {
		global $database;
		$result = self::find_by_sql('SELECT * FROM '.$_SESSION['user_id'].'_Tasks WHERE id="'.$database->escape_value($id).'"');
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
		$sql = "UPDATE ".$_SESSION['user_id']."_Tasks SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	protected function create() {
		global $database;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".$_SESSION['user_id']."_Tasks (";
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
		$sql = "UPDATE ".$_SESSION['user_id']."_Tasks SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
		
}