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
    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->meal_type_name)) {
            $this->errors['meal_type_name'][] = "Meal type name cannot be blank.";
        } elseif (!has_length($this->meal_type_name, ['min' => 2, 'max' => 50])) {
            $this->errors['meal_type_name'][] = "Meal type name must be between 2 and 50 characters.";
        } elseif (!preg_match("/^[A-Za-z\-']+$/", $this->meal_type_name)) {
            $this->errors['meal_type_name'][] = "Meal type name can only contain letters, hyphens, and apostrophes.";
        } elseif (!has_unique_name($this->meal_type_name, 'MealType', $this->id ?? 0)) {
            $this->errors['meal_type_name'][] = "Meal type name already exists. Please choose another.";
        }

        return $this->errors;
    }

     /**
     * Validates the meal type name (checking for uniqueness)
     *  * @return array Array of records where the name already exists
     */
    public static function find_by_name($meal_type_name)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE meal_type_name = '" . self::$database->escape_string($meal_type_name) . "'";
        $result_array = static::find_by_sql($sql);
        if (!empty($result_array)) {
            return array_shift($result_array);
        } else {
            return false;
        }
    }


}


