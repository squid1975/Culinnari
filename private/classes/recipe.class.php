<?php

class Recipe extends DatabaseObject
{

  static protected $table_name = 'recipe';
  static protected $db_columns = ['id', 
                                  'recipe_name', 
                                  'recipe_description', 
                                  'recipe_total_servings', 
                                  'recipe_post_date', 
                                  'recipe_prep_time_seconds', 
                                  'recipe_cook_time_seconds', 
                                  'recipe_difficulty', 
                                  'user_id'];

  public $id;
  public $recipe_name;
  public $recipe_description;
  public $recipe_total_servings;
  public $recipe_post_date;
  public $recipe_prep_time_seconds;
  public $recipe_cook_time_seconds;
  public $recipe_difficulty;
  public $user_id;

  public function __construct($args = [])
  {
    $this->recipe_name = $args['recipe_name'] ?? '';
    $this->recipe_description = $args['recipe_description'] ?? '';
    $this->recipe_total_servings = $args['recipe_total_servings'] ?? '';
    $this->recipe_post_date = $args['recipe_post_date'] ?? '';
    $this->recipe_prep_time_seconds = $args['recipe_prep_time_seconds'] ?? '';
    $this->recipe_cook_time_seconds = $args['recipe_cook_time_seconds'] ?? '';
    $this->recipe_difficulty = $args['recipe_difficulty'] ?? '';
    $this->user_id = $args['user_id'] ?? null;
  }

  /**
   * Gets the associated user based on the user_id 
   * Implements lazy loading
   * 
   * @return User|null The user object if found, otherwise its null
   */
  public function getUser(){
    if(!this->user){
        $this->user = User::find_by_id($this->user_id);
    }
    return $this->user;
  }


  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->recipe_name)) {
      $this->errors[] = "Recipe name cannot be blank.";
    }

    return $this->errors;
  }

  public function getDiets() {
    $sql = "SELECT d.diet_name, d.diet_icon_url
            FROM recipe_diet_type rd
            JOIN diet d ON  rd.diet_id = d.diet_id
            WHERE rd.recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

}