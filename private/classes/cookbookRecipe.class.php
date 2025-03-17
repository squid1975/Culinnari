<?php

class CookbookRecipe extends DatabaseObject {
    protected static $table_name = 'cookbook_recipe';
    protected static $db_columns = ['id','cookbook_id', 'recipe_id'];
    
    public $id;
    public $cookbook_id;
    public $recipe_id;
    
    public function __construct($args=[]) {
        $this->cookbook_id = $args['cookbook_id'] ?? 1;
        $this->recipe_id = $args['recipe_id'] ?? 1;
    }
    

    public static function get_cookbook_recipes ($cookbook_id){
        $sql = "SELECT * FROM cookbook_recipe WHERE id = '" . self::$database->escape_string($cookbook_id) . "'";
        return self::find_by_sql($sql);
    }
   
}

?>