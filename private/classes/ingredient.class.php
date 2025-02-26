<?php 
class Ingredient extends DatabaseObject
{
    static protected $table_name = 'ingredient';
    static protected $db_columns = ['ingredient_id',
                                    'ingredient_name',
                                    'ingredient_quantity',
                                    'ingredient_measurement_order',
                                    'ingredient_recipe_id'];

    public $ingredient_id;
    public $ingredient_name;
    public $ingredient_quantity;
    public $ingredient_measurement_name;
    public $ingredient_measurement_order;
    public $recipe_id;

    public function __construct($args = [])
    {
        $this->ingredient_name = $args['ingredient_name'] ?? '';
        $this->ingredient_description = $args['ingredient_description'] ?? '';
        $this->ingredient_measurement_order = $args['ingredient_measurement_order'] ?? '';
        $this->ingredient_recipe_id = $args['ingredient_recipe_id'] ?? '';
    }

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->ingredient_name)) {
            $this->errors[] = "Ingredient name cannot be blank.";
        }

        return $this->errors;
    }
}