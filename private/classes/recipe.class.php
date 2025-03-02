<?php

class Recipe extends DatabaseObject
{

  static protected $table_name = 'recipe';
  static protected $db_columns = [ 
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

  public static function createRecipe($recipeData, $ingredients, $steps, $image, $video, $diets, $styles, $meal_types) {
    $recipe = new Recipe();
    $recipe->recipe_name = $recipeData['recipe_name'];
    $recipe->recipe_description = $recipeData['recipe_description'];
    $recipe->recipe_total_servings = $recipeData['recipe_total_servings'];
    $recipe->recipe_prep_time_seconds = $recipeData['recipe_prep_time_seconds'];
    $recipe->recipe_cook_time_seconds = $recipeData['recipe_cook_time_seconds'];
    $recipe->recipe_difficulty = $recipeData['recipe_difficulty'];
    $recipe->user_id = $recipeData['user_id'];

    try {
        self::$database->begin_transaction();
        $recipe->save();
        $recipe_id = $recipe->id;

        // Save ingredients
        foreach ($ingredients as $ingredient) {
            $sql = "INSERT INTO recipe_ingredient (recipe_id, ingredient_name, ingredient_measurement_amount, ingredient_measurement_unit) VALUES (";
            $sql .= "'" . self::$database->escape_string($recipe_id) . "', ";
            $sql .= "'" . self::$database->escape_string($ingredient['name']) . "', ";
            $sql .= "'" . self::$database->escape_string($ingredient['amount']) . "', ";
            $sql .= "'" . self::$database->escape_string($ingredient['unit']) . "')";
            if (!self::$database->query($sql)) {
                throw new Exception("Failed to save ingredient: " . $ingredient['name']);
            }
        }

        // Save steps
        foreach ($steps as $step_number => $step) {
            $sql = "INSERT INTO recipe_step (recipe_id, step_number, step_description) VALUES (";
            $sql .= "'" . self::$database->escape_string($recipe_id) . "', ";
            $sql .= "'" . self::$database->escape_string($step_number + 1) . "', ";
            $sql .= "'" . self::$database->escape_string($step) . "')";
            if (!self::$database->query($sql)) {
                throw new Exception("Failed to save step: " . $step);
            }
        }

        // Save image
        if ($imageURL) {
          $sql = "INSERT INTO recipe_image (recipe_image, recipe_id) VALUES ('" . self::$database->escape_string($imageURL) . "', '" . self::$database->escape_string($recipe_id) . "')";
          if (!self::$database->query($sql)) {
              throw new Exception("Failed to save recipe image.");
          }
      }

        // Save video

        if (!empty($video)) {
          $sql = "INSERT INTO recipe_video (recipe_video_url, recipe_id) VALUES ('" . self::$database->escape_string($video) . "', '" . self::$database->escape_string($recipe_id) . "')";
          if (!self::$database->query($sql)) {
              throw new Exception("Failed to save video URL.");
          }
      }

        // Save diets (many-to-many relationship)
        foreach ($diets as $diet_id) {
            $sql = "INSERT INTO recipe_diet_type (recipe_id, diet_id) VALUES (";
            $sql .= "'" . self::$database->escape_string($recipe_id) . "', ";
            $sql .= "'" . self::$database->escape_string($diet_id) . "')";
            if (!self::$database->query($sql)) {
                throw new Exception("Failed to link diet ID: " . $diet_id);
            }
        }

        // Save styles (many-to-many relationship)
        foreach ($styles as $style_id) {
            $sql = "INSERT INTO recipe_style (recipe_id, style_id) VALUES (";
            $sql .= "'" . self::$database->escape_string($recipe_id) . "', ";
            $sql .= "'" . self::$database->escape_string($style_id) . "')";
            if (!self::$database->query($sql)) {
                throw new Exception("Failed to link style ID: " . $style_id);
            }
        }

        // Save meal types (many-to-many relationship)
        foreach ($meal_types as $meal_type_id) {
            $sql = "INSERT INTO recipe_meal_type (recipe_id, meal_type_id) VALUES (";
            $sql .= "'" . self::$database->escape_string($recipe_id) . "', ";
            $sql .= "'" . self::$database->escape_string($meal_type_id) . "')";
            if (!self::$database->query($sql)) {
                throw new Exception("Failed to link meal type ID: " . $meal_type_id);
            }
        }

        // Commit transaction if everything is successful
        self::$database->commit();
        return $recipe_id;
    } catch (Exception $e) {
        // Rollback on error
        self::$database->rollback();
        error_log($e->getMessage());
        return false;
    }
}



public static function getRecipesByUserId($user_id) {
  $sql = "SELECT * FROM recipe WHERE user_id = ?";
  $result = self::find_by_sql($sql, [$user_id]);
  return $result;
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

}