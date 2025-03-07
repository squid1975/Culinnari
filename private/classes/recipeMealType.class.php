<?php 

class RecipeMealType extends DatabaseObject {
static protected $table_name = 'recipe_meal_type';
    static protected $db_columns = ['recipe_id','meal_type_id'];

    public $id;
    public $recipe_id;
    public $meal_type_id;

    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->meal_type_id = $args['meal_type_id'] ?? 1;
    }

    
}
?>
