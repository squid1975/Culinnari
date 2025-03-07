<?php 

class RecipeVideo extends DatabaseObject {
    protected static $table_name = 'recipe_video';
    protected static $db_columns = ['id', 'recipe_video_url', 'recipe_id'];

    public $id;
    public $recipe_video_url;
    public $recipe_id;

    public function __construct($args=[]){
        $this->recipe_image = $args['recipe_video_url'] ?? NULL;
        $this->recipe_id = $args['recipe_id'] ?? 1;
    }

    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }

}