<?php

class MealType extends DatabaseObject {
    protected static $table_name = 'meal_type';
    protected static $db_columns = ['id','meal_type_name'];

    public $id;
    public $meal_type_name;

    public function __construct($args=[]) {
        $this->meal_type_name = $args['meal_type_name'] ?? '';
    }


}


