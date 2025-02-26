<?php

class MealType extends DatabaseObject {
    static protected $table_name = '';
    static protected $db_columns = ['meal_type_id', 'meal_type_name'];

    public $meal_type_id;
    public $meal_type_name;

    public function __construct($args=[]) {
        $this->meal_type_id = $args['meal_type_id'] ?? null;
        $this->meal_type_name = $args['meal_type_name'] ?? '';
    }

    static public function find_all() {
        $sql = "SELECT * FROM " . static::$table_name;
        return static::find_by_sql($sql);
      }

}


