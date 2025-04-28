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

    protected function validate() {
        $this->errors = [];

        if(self::recipe_exists_in_cookbook($this->cookbook_id, $this->recipe_id)){
            $this->errors['recipe_id'][] = "Recipe already exists in this cookbook.";
        }
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
        // Query the database to find the cookbook-recipe association
        $sql = "SELECT * FROM cookbook_recipe WHERE cookbook_id = '" . self::$database->escape_string($cookbook_id) . "' AND recipe_id = '" . self::$database->escape_string($recipe_id) . "' LIMIT 1";
        
        // Get the result from the query
        $result = self::find_by_sql($sql);
        
        // Check if the result is not empty
        if (!empty($result)) {
            return true; // Recipe exists in the cookbook
        } else {
            return false; // Recipe does not exist in the cookbook
        }
    }

    public static function find_by_cookbook_and_recipe($cookbook_id, $recipe_id) {
        $sql = "SELECT * FROM cookbook_recipe WHERE cookbook_id = '" . self::$database->escape_string($cookbook_id) . "' AND recipe_id = '" . self::$database->escape_string($recipe_id) . "' LIMIT 1";
        $result =  self::find_by_sql($sql);
        return $result ? array_shift($result) : null;
        
    }

}

