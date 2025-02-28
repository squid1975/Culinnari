<?php

class MealType extends DatabaseObject {
    static protected $table_name = 'meal_type';
    static protected $db_columns = ['meal_type_name'];

    public $id;
    public $meal_type_name;

    public function __construct($args=[]) {
        $this->meal_type_name = $args['meal_type_name'] ?? '';
    }


}


