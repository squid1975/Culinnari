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

  function createRecipe($recipeData, $ingredients, $steps, $categories) {

    $recipe = new Recipe();
    $recipe->recipe_name = $recipeData['recipe_name'];
    $recipe->recipe_description = $recipeData['recipe_description'];
    $recipe->recipe_total_servings = $recipeData['recipe_total_servings'];
    $recipe->recipe_prep_time_seconds = $recipeData['recipe_prep_time_seconds'];
    $recipe->recipe_cook_time_seconds = $recipeData['recipe_cook_time_seconds'];
    $recipe->recipe_difficulty = $recipeData['recipe_difficulty'];
    $recipe->user_id = $recipeData['user_id'];

    // Start transaction to ensure data consistency
    $database->begin_transaction();

    try {
        // Save the recipe and get the new ID
        if (!$recipe->save()) {
            throw new Exception("Failed to save recipe.");
        }
        $recipe_id = $recipe->recipe_id;

        // Save ingredients
        foreach ($ingredients as $ingredient) {
            $sql = "INSERT INTO ingredients (recipe_id, ingredient_name, amount, unit) VALUES (";
            $sql .= "'" . $database->escape_string($recipe_id) . "', ";
            $sql .= "'" . $database->escape_string($ingredient['name']) . "', ";
            $sql .= "'" . $database->escape_string($ingredient['amount']) . "', ";
            $sql .= "'" . $database->escape_string($ingredient['unit']) . "')";
            if (!$database->query($sql)) {
                throw new Exception("Failed to save ingredient: " . $ingredient['name']);
            }
        }

        // Save steps
        foreach ($steps as $step_number => $step) {
            $sql = "INSERT INTO steps (recipe_id, step_number, instruction) VALUES (";
            $sql .= "'" . $database->escape_string($recipe_id) . "', ";
            $sql .= "'" . $database->escape_string($step_number + 1) . "', ";
            $sql .= "'" . $database->escape_string($step) . "')";
            if (!$database->query($sql)) {
                throw new Exception("Failed to save step: " . $step);
            }
        }

        foreach ($diets as $diet_id) {
          $sql = "INSERT INTO recipe_diet (recipe_id, diet_id) VALUES (";
          $sql .= "'" . $database->escape_string($recipe_id) . "', ";
          $sql .= "'" . $database->escape_string($diet_id) . "')";
          if (!$database->query($sql)) {
              throw new Exception("Failed to link diet ID: " . $diet_id);
          }
      }

      // 5️⃣ Save styles (many-to-many)
      foreach ($styles as $style_id) {
          $sql = "INSERT INTO recipe_style (recipe_id, style_id) VALUES (";
          $sql .= "'" . $database->escape_string($recipe_id) . "', ";
          $sql .= "'" . $database->escape_string($style_id) . "')";
          if (!$database->query($sql)) {
              throw new Exception("Failed to link style ID: " . $style_id);
          }
      }

      // 6️⃣ Save meal types (many-to-many)
      foreach ($meal_types as $meal_type_id) {
          $sql = "INSERT INTO recipe_meal_type (recipe_id, meal_type_id) VALUES (";
          $sql .= "'" . $database->escape_string($recipe_id) . "', ";
          $sql .= "'" . $database->escape_string($meal_type_id) . "')";
          if (!$database->query($sql)) {
         

        // Commit transaction if everything is successful
        $database->commit();
        return $recipe_id;
    } catch (Exception $e) {
        // Rollback on error
        $database->rollback();
        error_log($e->getMessage());
        return false;
    }
}

public function fractionToDecimal($fraction) {
  if (strpos($fraction, '/') !== false) {
      list($numerator, $denominator) = explode('/', $fraction);
      return $numerator / $denominator;
  }
  return $fraction; // Return as is if it's already a whole number
}

public function timeToSeconds($hours, $minutes){
  return ($hours * 3600) + ($minutes * 60);
}


  /**
   * Gets the associated user based on the user_id 
   * Implements lazy loading
   * 
   * @return User|null The user object if found, otherwise its null
   */
  public function getUser(){
    if(!$this->user){
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

    if(is_blank($this->recipe_description)){
      $this->errors[] = "Recipe description cannot be blank.";
    }

    if(is_blank($this->recipe_total_servings)){
      $this->errors[] = "Recipe total servings cannot be blank.";
    }

    return $this->errors;
  }

  /**
   * Gets the diet types associated with the recipe
   * 
   * @return array An array of diet types
   */
  public function getDiets() {
    $sql = "SELECT d.diet_name, d.diet_icon_url
            FROM recipe_diet_type rd
            JOIN diet d ON  rd.diet_id = d.diet_id
            WHERE rd.recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

  /**
   * Gets the meal types associated with the recipe
   * 
   * @return array An array of meal types 
   */
  public function getMealTypes() {
    $sql = "SELECT mt.meal_type_name, mt.meal_type_icon_url
            FROM recipe_meal_type rmt
            JOIN meal_type mt ON  rmt.meal_type_id = mt.meal_type_id
            WHERE rmt.recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

  /**
   * Gets the style associated with the recipe
   * 
   * @return array An array of styles 
   */
  public function getRecipeStyles() {
    $sql = "SELECT s.style_name, s.style_icon_url
            FROM recipe_style rs
            JOIN style s ON  rs.style_id = s.style_id
            WHERE rs.recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

  /**
   * Gets the ingredients associated with the recipe
   * 
   * @return array An array of ingredients 
   */
  public function getRecipeIngredients() {
    $sql = "SELECT i.ingredient_name, i.ingredient_measurement_amount, i.ingredient_measurement_unit
            FROM recipe_ingredient ri
            JOIN ingredient i ON  ri.ingredient_id = i.ingredient_id
            WHERE ri.recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

  /**
   * Gets the steps associated with the recipe
   * 
   * @return array An array of steps 
   */
  public function getRecipeSteps() {
    $sql = "SELECT step_description
            FROM recipe_step
            WHERE recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }   

  /**
   * Gets the recipe image associated with the recipe
   * 
   * @return array An array of recipe images
   */
  public function getRecipeImage() {
    $sql = "SELECT recipe_image_url
            FROM recipe_image
            WHERE recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

  /**
   * Gets the recipe video URL associated with the recipe
   * 
   * @return array An array of recipe video URLs
   */
  public function getRecipeVideo() {
    $sql = "SELECT recipe_video_url
            FROM recipe_video
            WHERE recipe_id ='" . self::$database->escape_string($this->id) . "'";
    
    return self::find_by_sql($sql);
  }

  public function getUserRecipes($user_id){
    $sql = "SELECT * FROM recipe WHERE user_id ='" . self::$database->escape_string($user_id) . "'";
    return self::find_by_sql($sql);
  }

  public function recipeQuery($searchQuery = "", $filters = [])
  {
      $sql = "SELECT * FROM " . self::$table_name . " WHERE 1=1";
      $params = [];
      $types = "";

      // Handle Search Query
      if (!empty($searchQuery)) {
          $sql .= " AND (recipe_name LIKE ? OR recipe_description LIKE ?)";
          $params[] = "%" . $searchQuery . "%";
          $params[] = "%" . $searchQuery . "%";
          $types .= "ss"; // Two string parameters
      }

      // Handle Meal Type Filter
      if (!empty($filters['mealType'])) {
          $mealTypes = $filters['mealType'];
          $placeholders = implode(',', array_fill(0, count($mealTypes), '?'));
          $sql .= " AND meal_type IN ($placeholders)";
          $params = array_merge($params, $mealTypes);
          $types .= str_repeat("s", count($mealTypes)); // String for each filter value
      }

      // Handle Style Filter
      if (!empty($filters['style'])) {
          $styles = $filters['style'];
          $placeholders = implode(',', array_fill(0, count($styles), '?'));
          $sql .= " AND style IN ($placeholders)";
          $params = array_merge($params, $styles);
          $types .= str_repeat("s", count($styles));
      }

      // Handle Diet Filter
      if (!empty($filters['diet'])) {
          $diets = $filters['diet'];
          $placeholders = implode(',', array_fill(0, count($diets), '?'));
          $sql .= " AND diet IN ($placeholders)";
          $params = array_merge($params, $diets);
          $types .= str_repeat("s", count($diets));
      }

      // Handle Sorting
      if (!empty($filters['sortBy'])) {
          switch ($filters['sortBy']) {
              case 'newest':
                  $sql .= " ORDER BY recipe_post_date DESC";
                  break;
              case 'oldest':
                  $sql .= " ORDER BY recipe_post_date ASC";
                  break;
              case 'rating':
                  $sql .= " ORDER BY rating DESC"; // Assuming you have a rating column
                  break;
              default:
                  $sql .= " ORDER BY recipe_post_date DESC";
                  break;
          }
      }

      // Prepare and execute the query
      $stmt = self::$database->prepare($sql);
      if (!empty($params)) {
          $stmt->bind_param($types, ...$params);
      }
      $stmt->execute();
      $result = $stmt->get_result();

      return $result;
  }
}


}