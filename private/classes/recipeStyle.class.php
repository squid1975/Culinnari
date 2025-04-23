<?php 

class RecipeStyle extends DatabaseObject {
    protected static $table_name = 'recipe_style';
    protected static $db_columns = [ 
        'id',
        'recipe_id',
        'style_id'];

    public $id;
    public $recipe_id;
    public $style_id;

    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->style_id = $args['style_id'] ?? 1;
    }

    /**
     * Find the styles associated with a recipe
     * @param int|string $recipe_id The recipe_id (id in recipe table) of the recipe to look up
     * @return DatabaseObject[] An array of RecipeStyle objects
     */
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }
}
