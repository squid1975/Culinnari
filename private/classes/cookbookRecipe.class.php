<?php

class CookbookRecipe extends DatabaseObject {
    protected static $table_name = 'cookbook_recipe';
    protected static $db_columns = [
        'id',
        'cookbook_id', 
        'recipe_id'];
    
    public $id;
    public $cookbook_id;
    public $recipe_id;
    
    public function __construct($args=[]) {
        $this->cookbook_id = $args['cookbook_id'] ?? 1;
        $this->recipe_id = $args['recipe_id'] ?? 1;
    }
    

    /**
     * Returns all recipes in a cookbook
     * @param mixed $cookbook_id the id value of the cookbook 
     * @return CookbookRecipe[] Array of CookbookRecipe objects
     */
    public static function get_cookbook_recipes_by_cookbook_id ($cookbook_id){
        $sql = "SELECT * FROM cookbook_recipe WHERE cookbook_id = '" . self::$database->escape_string($cookbook_id) . "'";
        return self::find_by_sql($sql);
    }

    /**
     * Determines if a recipe already exists in a cookbook
     * @param mixed $cookbook_id the id value of the cookbook
     * @param mixed $recipe_id the id value of the recipe
     */
    public static function recipe_exists_in_cookbook($cookbook_id, $recipe_id) {
        $sql = "SELECT * FROM cookbook_recipe WHERE cookbook_id = '" . self::$database->escape_string($cookbook_id) . "' AND recipe_id = '" . self::$database->escape_string($recipe_id) . "' LIMIT 1";
        $result = self::find_by_sql($sql);
        if($result){
            return true;
        } else {
            return false;
        }
    }

}

