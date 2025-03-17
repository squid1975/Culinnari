<?php 

class RecipeDiet extends DatabaseObject {
protected static $table_name = 'recipe_diet';
    protected static $db_columns = ['recipe_id','diet_id'];

    public $id;
    public $recipe_id;
    public $diet_id;

    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->diet_id = $args['diet_id'] ?? 1;
    }

    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }
}
?>