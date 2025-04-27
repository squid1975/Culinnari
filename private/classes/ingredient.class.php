<?php 
class Ingredient extends DatabaseObject
{
    protected static $table_name = 'ingredient';
    protected static $db_columns = ['id',
    'ingredient_quantity',
    'ingredient_measurement_name',
    'ingredient_name',
    'ingredient_recipe_order',
    'recipe_id'];

    public $id;
    public $ingredient_name;
    public $ingredient_quantity;
    public $ingredient_measurement_name;
    public $ingredient_recipe_order;
    public $recipe_id;

    public function __construct($args = [])
    {
        $this->ingredient_name = $args['ingredient_name'] ?? '';
        $this->ingredient_quantity = $args['ingredient_quantity'] ?? 1;
        $this->ingredient_measurement_name = $args['ingredient_measurement_name'] ?? 'n/a';
        $this->ingredient_recipe_order = $args['ingredient_recipe_order'] ?? 1;
        $this->recipe_id = $args['recipe_id'] ?? 1;
    }

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->ingredient_name)) {
            $this->errors['ingredient_name'][] = "Ingredient name cannot be blank.";
        } 

        if (is_blank($this->ingredient_quantity)) {
            $this->errors['ingredient_quantity'][] = "Ingredient quantity cannot be blank.";
        }  

       
        return $this->errors;
    }

    /**
     * Finds ingredients associated with a recipe
     * @param mixed $recipe_id the recipe_id (id in recipe table) of the recipe
     * @return Ingredient[] An array of ingredient objects matching the recipe ID
     */
    public static function find_by_recipe_id($recipe_id) {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE recipe_id = '" . self::$database->escape_string($recipe_id) . "'";
        $result_array = static::find_by_sql($sql);
        return $result_array; // Ensure this returns an array of objects
    }

}