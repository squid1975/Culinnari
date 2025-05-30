<?php 

class RecipeDiet extends DatabaseObject {
protected static $table_name = 'recipe_diet';
    protected static $db_columns = [
        'id',
        'recipe_id',
        'diet_id'];

    public $id;
    public $recipe_id;
    public $diet_id;

    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->diet_id = $args['diet_id'] ?? 1;
    }

    /**
     * Finds the diets associated with a recipe 
     * @param int $recipe_id The recipe_id (id in recipe table) of the recipe
     * @return RecipeDiet[] An array of RecipeDiet objects
     */
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }
}
?>