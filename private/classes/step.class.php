<?php

class Step extends DatabaseObject {
    protected static $table_name = 'step';
    protected static $db_columns = ['id',
                                    'recipe_id',
                                    'step_number',
                                    'step_description'];

    public $id;
    public $recipe_id;
    public $step_number;
    
    public $step_description;
    
    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->step_number = $args['step_number'] ?? 1;
        $this->step_description = $args['step_description'] ??'';

    }

    protected function validate() {
        $this->errors = [];

        if (is_blank($this->step_description)) {
            $this->errors['step_description'] = "Step description cannot be blank.";
        } elseif (!has_length($this->step_description, ['min' => 2, 'max' => 255])) {
            $this->errors['step_description'] = "Step description must be between 2 and 255 characters.";
        } 
        
        return $this->errors;
    }
    
    /**
     * Finds all steps associated with a recipe
     * @param int $recipe_id the recipe_id (id in recipe table) of the recipe to look up
     * @return DatabaseObject[] array of Step objects matching the recipe ID
     */
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }
    

}