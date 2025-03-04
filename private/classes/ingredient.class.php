<?php 
class Ingredient extends DatabaseObject
{
    static protected $table_name = 'ingredient';
    static protected $db_columns = [
                                    'name',
                                    'quantity',
                                    'measurement_order',
                                    'recipe_id'];

    public $id;
    public $name;
    public $quantity;
    public $measurement_name;
    public $measurement_order;
    public $recipe_id;

    public function __construct($args = [])
    {
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->measurement_order = $args['measurement_order'] ?? '';
        $this->recipe_id = $args['recipe_id'] ?? '';
    }

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->name)) {
            $this->errors[] = "Ingredient name cannot be blank.";
        }

        return $this->errors;
    }
}