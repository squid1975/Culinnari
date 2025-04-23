<?php

class DatabaseObject {

  protected static $database;
  protected static $table_name = "";
  protected static $columns = [];
  public $errors = [];

  public static function set_database($database) {
    self::$database = $database;
  }

  public static function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if(!$result) {
      exit("Database query failed.");
    }

    // results into objects
    $object_array = [];
    while($record = $result->fetch_assoc()) {
      $object_array[] = static::instantiate($record);
    }

    $result->free();

    return $object_array;
  }

  public static function find_all() {
    $sql = "SELECT * FROM " . static::$table_name;
    return static::find_by_sql($sql);
  }

  public static function count_all() {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }

  public static function find_by_id($id) {
    if ($id === null) {
      return null;
    }
    $sql = "SELECT * FROM " . static::$table_name . " WHERE id='" . self::$database->escape_string($id) . "'";
    $result_array = static::find_by_sql($sql);
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  protected static function instantiate($record) {
    $object = new static;
    // Could manually assign values to properties
    // but automatically assignment is easier and re-usable
    foreach($record as $property => $value) {
      if(property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }

  protected function validate() {
    $this->errors = [];

    // Add custom validations
    return $this->errors;
  }

  protected function create() {
    $this->validate();
    if(!empty($this->errors)) { return false; }
    

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    $result = self::$database->query($sql);
    if($result) {
      $this->id = self::$database->insert_id;
    }
    return $result;
  }

  protected function update() {
    $this->validate();
    if(!empty($this->errors)) { return false; }

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

  public function save() {
    // A new record will not have an ID yet
    if(isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  }

  public function merge_attributes($args=[]) {
    foreach($args as $key => $value) {
      if(property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  // Properties which have database columns, excluding ID
  public function attributes() {
    $attributes = [];
    foreach(static::$db_columns as $column) {
      if($column == 'id') { continue; }
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  protected function sanitized_attributes() {
  $sanitized = [];
  foreach($this->attributes() as $key => $value) {
    // If the value is an integer, leave it as is
    if (is_int($value)) {
      $sanitized[$key] = $value;
    } else {
      // If it's not an integer, escape it as a string
      $sanitized[$key] = is_null($value) ? null : self::$database->escape_string($value);
    }
  }
  return $sanitized;
}

  public function delete() {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }
  public static function begin_transaction() {
    return self::$database->begin_transaction();
}


public function commit() {
  return self::$database->commit();
}

public function rollback() {
  return self::$database->rollback();
}



}

