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
        } elseif (!has_length($this->ingredient_name, ['min' => 2, 'max' => 50])) {
            $this->errors['ingredient_name'][] = "Ingredient name must be between 2 and 50 characters.";
        } 
        
        if (is_blank($this->ingredient_quantity)) {
            $this->errors['ingredient_quantity'][] = "Ingredient quantity cannot be blank.";
        } elseif (!is_numeric($this->ingredient_quantity)) {
            $this->errors['ingredient_quantity'][] = "Ingredient quantity must be a number.";
        } elseif ($this->ingredient_quantity <= 0) {
            $this->errors['ingredient_quantity'][] = "Ingredient quantity must be greater than 0.";
        }
         elseif (!has_length($this->ingredient_quantity, ['min' => 1, 'max' => 6])) {
            $this->errors['ingredient_quantity'][] = "Ingredient quantity must be between 1 and 6 characters.";
        } elseif (!preg_match("/^\d+(\s\d+\/\d+)?$/", $this->ingredient_quantity)) {
            $this->errors['ingredient_quantity'][] = "Ingredient quantity can only contain numbers, mixed numbers, or fractions (e.g., 1, 1 1/2, 11 1/2, 1/2).";
        }

        if($ingredient_measurement_name != 'teaspoon' || $ingredient_measurement_name != 'tablespoon' || $ingredient_measurement_name != 'cup' || $ingredient_measurement_name != 'ounce' || $ingredient_measurement_name != 'pint' || $ingredient_measurement_name != 'quart' || $ingredient_measurement_name != 'gallon' || $ingredient_measurement_name != 'liter' || $ingredient_measurement_name != 'milliliter' || $ingredient_measurement_name != 'n/a') {
            $this->errors['ingredient_measurement_name'][] = "Ingredient measurement name invalid.";
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