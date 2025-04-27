<?php 

class RecipeMealType extends DatabaseObject {
static protected $table_name = 'recipe_meal_type';
    static protected $db_columns = [ 
        'id',
        'recipe_id',
        'meal_type_id'];

    public $id;
    public $recipe_id;
    public $meal_type_id;

    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->meal_type_id = $args['meal_type_id'] ?? 1;
    }

     /**
     * Find the meal types associated with a recipe
     * @param int|string $recipe_id The recipe_id (id in recipe table) of the recipe to look up
     * @return DatabaseObject[] An array of RecipeMealType objects
     */
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }
    
}

