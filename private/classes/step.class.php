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
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }
    

}