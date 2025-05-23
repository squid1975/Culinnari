<?php 

class RecipeImage extends DatabaseObject {
    protected static $table_name = 'recipe_image';
    protected static $db_columns = [
        'id', 
        'recipe_image', 
        'recipe_id'];

    public $id;
    public $recipe_image;
    public $recipe_id;

    public function __construct($args=[]){
        $this->recipe_image = $args['recipe_image'] ?? '/images/default_recipe_image.webp';
        $this->recipe_id = $args['recipe_id'] ?? 1;
    }

    /**
     * Finds the first image associated with a recipe by the recipe_id
     * @param mixed $recipe_id the recipe_id (id in recipe table) of the recipe
     * @return bool|DatabaseObject|null An object of the RecipeImage class or false if not found
     */
    public static function find_image_by_recipe_id($recipe_id) {
        if ($recipe_id === null) {
            return null;
        }
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id='" . self::$database->escape_string($recipe_id) . "' LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /**
     * Finds all images associated with a recipe by the recipe_id
     * @param mixed $recipe_id the recipe_id (id in the recipe table) of the recipe
     * @return RecipeImage[] An array of RecipeImage objects matching the recipe ID
     */
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }

}

