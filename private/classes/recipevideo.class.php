<?php 

class RecipeVideo extends DatabaseObject {
    protected static $table_name = 'recipe_video';
    protected static $db_columns = ['id', 'recipe_video_url', 'recipe_id'];

    public $id;
    public $recipe_video_url;
    public $recipe_id;

    public function __construct($args=[]){
        $this->recipe_video_url = $args['recipe_video_url'] ?? '';
        $this->recipe_id = $args['recipe_id'] ?? 1;
    }

    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "' LIMIT 1";
        $result_array = static::find_by_sql($sql);
    
        // Check if a result is found and return the first object
        return !empty($result_array) ? $result_array[0] : null; // Return the object or null if no result is found
    }
}