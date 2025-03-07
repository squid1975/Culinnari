<?php

class Recipe extends DatabaseObject
{

  protected static $table_name = 'recipe';
  protected static $db_columns =  ['id',
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
        $this->recipe_post_date = $args['recipe_post_date'] ?? date('Y-m-d h:m:s');
        $this->recipe_prep_time_seconds = $args['recipe_prep_time_seconds'] ?? NULL;
        $this->recipe_cook_time_seconds = $args['recipe_cook_time_seconds'] ?? NULL;
        $this->recipe_difficulty = $args['recipe_difficulty'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
    }
  
    public static function getUserRecipes($user_id) {
      $sql = "SELECT * FROM recipe WHERE user_id = '" . self::$database->escape_string($user_id) . "'";
      return Recipe::find_by_sql($sql); // 
  }

  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->recipe_name)) {
      $this->errors[] = "Recipe name cannot be blank.";
    }

    if(is_blank($this->recipe_description)){
      $this->errors[] = "Recipe description cannot be blank.";
    }

    if(is_blank($this->recipe_total_servings)){
      $this->errors[] = "Recipe total servings cannot be blank.";
    }

    return $this->errors;
  }

  public static function getIngredients($recipe_id){
    return Ingredient::find_by_id($recipe_id);
  }

  public static function getSteps($recipe_id){
    return Step::find_by_id($recipe_id);
  }

  public static function getDiets($recipe_id){
    return RecipeDiet::find_by_id($recipe_id);
  }

  public static function getImage($recipe_id){
    return RecipeImage::find_by_id($recipe_id);
  }

  public static function getMealTypes($recipe_id){
    return RecipeMealType::find_by_id($recipe_id);
  }

  public static function getStyles($recipe_id){
    return RecipeStyle::find_by_id($recipe_id);
  }

  public static function getVideo($recipe_id){
    return RecipeVideo::find_by_id($recipe_id);
  }



public static function deleteRecipe($id) {
  global $database;
  
  try {
      $database->begin_transaction();

      // Delete from junction tables
      $sql = "DELETE FROM recipe_meal_types WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      $sql = "DELETE FROM recipe_styles WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      $sql = "DELETE FROM recipe_diets WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      // Delete ingredients
      $sql = "DELETE FROM ingredients WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      // Delete steps
      $sql = "DELETE FROM steps WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      // Delete recipe image record
      $sql = "SELECT recipe_image FROM recipe_images WHERE recipe_id = " . $database->escape_string($id);
      $result = $database->query($sql);
      if ($row = $result->fetch_assoc()) {
          $imagePath = __DIR__ . '/../' . $row['recipe_image']; // Adjust path if necessary
          if (file_exists($imagePath)) {
              unlink($imagePath); // Delete image file
          }
      }
      $sql = "DELETE FROM recipe_images WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      // Delete video links
      $sql = "DELETE FROM recipe_videos WHERE recipe_id = " . $database->escape_string($id);
      $database->query($sql);

      // Finally, delete the recipe itself
      $sql = "DELETE FROM recipes WHERE id = " . $database->escape_string($id);
      $result = $database->query($sql);

      if (!$result) {
          throw new Exception("Unable to delete recipe.");
      }

      $database->commit();
      return true;
  } catch (Exception $e) {
      $database->rollback();
      return false;
  }
}



public static function find_newest_recipes() {
  // Perform the query to fetch the newest recipes, ordered by post date descending
  return Recipe::find_by_sql("SELECT * FROM recipe ORDER BY recipe_post_date DESC");
}

public static function find_beginner_recipes() {
  // Perform the query to fetch recipes with 'beginner' difficulty without ordering
  return Recipe::find_by_sql("SELECT * FROM recipe WHERE recipe_difficulty = 'beginner'");
}

public static function find_quick_recipes() {
  // Perform the query to fetch recipes where the sum of prep time and cook time is less than 1800 seconds (30 minutes)
  return Recipe::find_by_sql("SELECT * FROM recipe WHERE (recipe_prep_time_seconds + recipe_cook_time_seconds) < 1800");
}


} 
