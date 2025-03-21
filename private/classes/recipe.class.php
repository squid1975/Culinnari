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

  /**
   * Takes the recipe id and finds the diet icons associated with the recipe's diet types
   * @param mixed $recipe_id
   * @return array $diet_icons array of diet_icon urls
   */
  public static function get_diet_icons($recipe_id) {
    $recipe_diets = RecipeDiet::find_by_recipe_id($recipe_id); // Use find_by_recipe_id method to get related rows
    $diet_icons = [];
    
    // Check if the result is an array and iterate over it
    if ($recipe_diets) {
        foreach ($recipe_diets as $recipe_diet) {
            $diet = Diet::find_by_id($recipe_diet->diet_id);
            if ($diet) {
                $diet_icons[] = $diet->diet_icon_url; // Store the diet icon URL
            }
        }
    }
    
    return $diet_icons;
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

public static function search_recipes($searchQuery = '', $prepCookTimeTotal = [], $recipeDifficulty = [], $mealTypes = [], $styles = [], $diets = []) {
  // Start building the query
  $sql = "SELECT * FROM recipe WHERE 1=1"; // Base query (this ensures we have a valid WHERE clause)

  // Handle search query in recipe_name and recipe_description for partial matches
  if (!empty($searchQuery)) {
      // Explode the search query into individual words
      $searchTerms = explode(" ", $searchQuery);
      
      // Loop through search terms and create multiple LIKE conditions
      $searchConditions = [];
      foreach ($searchTerms as $term) {
          $term = "%" . $term . "%"; // Prepare each term for LIKE operator with wildcards
          $searchConditions[] = "(recipe_name LIKE '{$term}' OR recipe_description LIKE '{$term}')";
      }

      // Combine the search conditions with AND (match all terms)
      $sql .= " AND (" . implode(" AND ", $searchConditions) . ")";
  }

  // Add filter conditions for prepCookTimeTotal
  if (!empty($prepCookTimeTotal)) {
      $timeConditions = [];
      
      // Loop through selected time filters
      foreach ($prepCookTimeTotal as $timeFilter) {
          switch ($timeFilter) {
              case '900': // 15 mins or less
                  $timeConditions[] = "(recipe_prep_time_seconds + recipe_cook_time_seconds) <= 900";
                  break;
              case '1800': // 30 mins or less
                  $timeConditions[] = "(recipe_prep_time_seconds + recipe_cook_time_seconds) <= 1800";
                  break;
              case '2700': // 45 mins or less
                  $timeConditions[] = "(recipe_prep_time_seconds + recipe_cook_time_seconds) <= 2700";
                  break;
              case '3600-7200': // 1-2 hours (3600 - 7200)
                  $timeConditions[] = "(recipe_prep_time_seconds + recipe_cook_time_seconds) BETWEEN 3600 AND 7200";
                  break;
              case '7200+': // 2+ hours (greater than 7200)
                  $timeConditions[] = "(recipe_prep_time_seconds + recipe_cook_time_seconds) > 7200";
                  break;
          }
      }

      // If there are any time conditions, join them with OR
      if (!empty($timeConditions)) {
          $sql .= " AND (" . implode(" OR ", $timeConditions) . ")";
      }
  }

  // Add filter conditions for recipe_difficulty
  if (!empty($recipeDifficulty)) {
      $difficultyConditions = [];
      
      // Loop through selected difficulty filters
      foreach ($recipeDifficulty as $difficulty) {
          $difficultyConditions[] = "recipe_difficulty = '{$difficulty}'";
      }

      // If there are any difficulty conditions, join them with OR
      if (!empty($difficultyConditions)) {
          $sql .= " AND (" . implode(" OR ", $difficultyConditions) . ")";
      }
  }

  // Add JOINs for meal types, styles, and diets if necessary
  if(!empty($mealTypes)){
      $mealTypeConditions = [];
      foreach($mealTypes as $mealType) {
          $mealTypeConditions[] = "rm.meal_type_id = {$mealType}";
      }
      if (!empty($mealTypeConditions)) {
          $sql .= " JOIN recipe_meal_type AS rm ON r.id = rm.recipe_id AND (" . implode(" OR ", $mealTypeConditions) . ")";
      }
  }

  if(!empty($styles)){
      $styleConditions = [];
      foreach($styles as $style) {
          $styleConditions[] = "rs.style_id = {$style}";
      }
      if (!empty($styleConditions)) {
          $sql .= " JOIN recipe_style AS rs ON r.id = rs.recipe_id AND (" . implode(" OR ", $styleConditions) . ")";
      }
  }

  if(!empty($diets)){
      $dietConditions = [];
      foreach($diets as $diet) {
          $dietConditions[] = "rd.diet_id = {$diet}";
      }
      if (!empty($dietConditions)) {
          $sql .= " JOIN recipe_diet AS rd ON r.id = rd.recipe_id AND (" . implode(" OR ", $dietConditions) . ")";
      }
  }
  return self::find_by_sql($sql);
}

  // Execute the query and return the results
}




 
