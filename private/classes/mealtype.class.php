<?php

class MealType extends DatabaseObject {
    protected static $table_name = 'meal_type';
    protected static $db_columns = [
        'id',
        'meal_type_name'];

    public $id;
    public $meal_type_name;

    public function __construct($args=[]) {
        $this->meal_type_name = $args['meal_type_name'] ?? '';
    }

    /**
     * Validates the meal type name
     * @return array An array of error messages, empty if no errors
     */
    protected function validate() {
        $this->errors = [];

        if(is_blank($this->meal_type_name)) {
            $this->errors[] = "Meal type name cannot be blank.";
        } elseif(!has_length($this->meal_type_name, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "Meal type name must be between 2 and 255 characters.";
        }

        return $this->errors;
    }


}


