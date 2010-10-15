<?php

require_once 'Database.php';

class DatabaseObject {
	
	protected static $table_name;
	protected static $db_fields;
	
	public static function find_all() {
		return self::find_by_sql('SELECT * FROM '.static::$table_name);
	}
	
	public static function find_by_id($id=0) {
		global $database;
		$result = self::find_by_sql('SELECT * FROM '.static::$table_name.' WHERE id="'.$database->escape_value($id).'"');
		return !empty($result) ? array_shift($result) : false;
	}
	
	public static function find_by_sql($sql='') {
		global $database;
		$result = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	public function attributes() {
		$attributes = array();
		foreach(static::$db_fields as $field) {
			if(property_exists($this,$field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes() {
		global $database;
		$clean_attributes = array();
		foreach($this->attributes() as $key => $value) {
			$clean_attributes[$key] = $database->escape_value($value);
		}
		return $clean_attributes;
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
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	protected function create() {
		global $database;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".static::$table_name." (";
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
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
	}
	
	public function delete($table_name,$id) {
		global $database;
		$sql = "DELETE FROM ".$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1";
		$database->query($sql);
		return($database->affected_rows() == 1) ? true : false;
	}
		
	private static function instantiate($record) {
		$class_name = get_called_class();
		$object = new $class_name;
		foreach($record as $attribute=>$value) {
			if($object->has_attribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
		$object_vars = $this->attributes();
		return array_key_exists($attribute,$object_vars);
	}
	
}