<?php 

class RecipeStyle extends DatabaseObject {
protected static $table_name = 'recipe_style';
    protected static $db_columns = ['recipe_id','style_id'];

    public $id;
    public $recipe_id;
    public $style_id;

    public function __construct($args=[]) {
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->style_id = $args['style_id'] ?? 1;
    }

    
}
?>