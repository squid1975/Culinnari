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

public static function get_meal_type_names($recipe_id) {
  $recipe_meal_types = RecipeMealType::find_by_recipe_id($recipe_id);
  $meal_type_names = [];

  if ($recipe_meal_types) {
      foreach ($recipe_meal_types as $recipe_meal_type) {
          $meal_type = MealType::find_by_id($recipe_meal_type->meal_type_id);
          if ($meal_type) {
              $meal_type_names[] = $meal_type->meal_type_name;
          }
      }
  }

  return $meal_type_names;
}

public static function get_style_names($recipe_id) {
  $recipe_styles = RecipeStyle::find_by_recipe_id($recipe_id);
  $style_names = [];

  if ($recipe_styles) {
      foreach ($recipe_styles as $recipe_style) {
          $style = Style::find_by_id($recipe_style->style_id);
          if ($style) {
              $style_names[] = $style->style_name;
          }
      }
  }

  return $style_names;
}

public static function get_recipe_username($recipe_id) {
  $recipe = Recipe::find_by_id($recipe_id);
  $user = User::find_by_id($recipe->user_id);
  return $user->username;
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

public static function search_recipes(
    $searchQuery = '', 
    $prepCookTimeTotal = [], 
    $recipeDifficulty = [], 
    $mealTypes = [], 
    $styles = [], 
    $diets = [], 
    $sortBy = 'recipe[recipe_post_date] DESC'
) {
    // Base query with average rating calculation
    $sql = "SELECT r.*, 
                   COALESCE(AVG(rt.rating_value), 0) AS avg_rating 
            FROM recipe AS r 
            LEFT JOIN rating AS rt ON r.id = rt.recipe_id";

    // Initialize join conditions array
    $joins = [];

    // Add JOINs for meal types, styles, and diets if necessary
    if (!empty($mealTypes)) {
        $joins[] = "JOIN recipe_meal_type AS rm ON r.id = rm.recipe_id";
    }
    if (!empty($styles)) {
        $joins[] = "JOIN recipe_style AS rs ON r.id = rs.recipe_id";
    }
    if (!empty($diets)) {
        $joins[] = "JOIN recipe_diet AS rd ON r.id = rd.recipe_id";
    }

    // Add additional JOINs
    if (!empty($joins)) {
        $sql .= " " . implode(" ", $joins);
    }

    // Initialize WHERE conditions
    $conditions = ["1=1"]; // Ensures valid WHERE clause

    // Handle search query in recipe_name and recipe_description for partial matches
    if (!empty($searchQuery)) {
        $searchTerms = explode(" ", $searchQuery);
        $searchConditions = [];
        foreach ($searchTerms as $term) {
            $escapedTerm = "%" . self::$database->real_escape_string($term) . "%";
            $searchConditions[] = "(r.recipe_name LIKE '{$escapedTerm}' OR r.recipe_description LIKE '{$escapedTerm}')";
        }
        $conditions[] = "(" . implode(" AND ", $searchConditions) . ")";
    }

    // Add filter conditions for prepCookTimeTotal
    if (!empty($prepCookTimeTotal)) {
        $timeConditions = [];
        foreach ($prepCookTimeTotal as $timeFilter) {
            switch ($timeFilter) {
                case '900': 
                    $timeConditions[] = "(r.recipe_prep_time_seconds + r.recipe_cook_time_seconds) <= 900";
                    break;
                case '1800': 
                    $timeConditions[] = "(r.recipe_prep_time_seconds + r.recipe_cook_time_seconds) <= 1800";
                    break;
                case '2700': 
                    $timeConditions[] = "(r.recipe_prep_time_seconds + r.recipe_cook_time_seconds) <= 2700";
                    break;
                case '3600-7200': 
                    $timeConditions[] = "(r.recipe_prep_time_seconds + r.recipe_cook_time_seconds) BETWEEN 3600 AND 7200";
                    break;
                case '7200+': 
                    $timeConditions[] = "(r.recipe_prep_time_seconds + r.recipe_cook_time_seconds) > 7200";
                    break;
            }
        }
        if (!empty($timeConditions)) {
            $conditions[] = "(" . implode(" OR ", $timeConditions) . ")";
        }
    }

    // Add filter conditions for recipe_difficulty
    if (!empty($recipeDifficulty)) {
        $difficultyConditions = [];
        foreach ($recipeDifficulty as $difficulty) {
            $difficultyConditions[] = "r.recipe_difficulty = '" . self::$database->real_escape_string($difficulty) . "'";
        }
        if (!empty($difficultyConditions)) {
            $conditions[] = "(" . implode(" OR ", $difficultyConditions) . ")";
        }
    }

    // Add filter conditions for meal types
    if (!empty($mealTypes)) {
        $mealTypeConditions = [];
        foreach ($mealTypes as $mealType) {
            $mealTypeConditions[] = "rm.meal_type_id = " . intval($mealType);
        }
        if (!empty($mealTypeConditions)) {
            $conditions[] = "(" . implode(" OR ", $mealTypeConditions) . ")";
        }
    }

    // Add filter conditions for styles
    if (!empty($styles)) {
        $styleConditions = [];
        foreach ($styles as $style) {
            $styleConditions[] = "rs.style_id = " . intval($style);
        }
        if (!empty($styleConditions)) {
            $conditions[] = "(" . implode(" OR ", $styleConditions) . ")";
        }
    }

    // Add filter conditions for diets
    if (!empty($diets)) {
        $dietConditions = [];
        foreach ($diets as $diet) {
            $dietConditions[] = "rd.diet_id = " . intval($diet);
        }
        if (!empty($dietConditions)) {
            $conditions[] = "(" . implode(" OR ", $dietConditions) . ")";
        }
    }

    // Add WHERE clause to the SQL query
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Group by recipe ID to ensure correct aggregation
    $sql .= " GROUP BY r.id";

    // Handle sorting
    switch ($sortBy) {
        case "rating[rating_value] DESC":
            $sql .= " ORDER BY avg_rating DESC"; // Highest-rated first
            break;
        case "rating[rating_value] ASC":
            $sql .= " ORDER BY avg_rating ASC"; // Lowest-rated first
            break;
        case "recipe[recipe_post_date] DESC":
            $sql .= " ORDER BY r.recipe_post_date DESC"; // Newest first
            break;
        case "recipe[recipe_post_date] ASC":
            $sql .= " ORDER BY r.recipe_post_date ASC"; // Oldest first
            break;
        case "recipe[recipe_name] ASC":
            $sql .= " ORDER BY r.recipe_name ASC"; // A-Z
            break;
        default:
            $sql .= " ORDER BY r.recipe_post_date DESC"; // Default sorting (Newest first)
            break;
    }

    return self::find_by_sql($sql);
}

  public static function get_username_by_recipe_id($recipe_id) {
    // Get the user_id from the recipe table using the recipe_id
    $sql = "SELECT user_id FROM " . static::$table_name . " WHERE id='" . self::$database->escape_string($recipe_id) . "'";
    $result = self::$database->query($sql);

    // Check if a result was returned
    if ($result && $row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];

        // Now that we have the user_id, fetch the username from the user table
        $user_sql = "SELECT username FROM user WHERE id='" . self::$database->escape_string($user_id) . "'";
        $user_result = self::$database->query($user_sql);

        // Check if a result was returned and return the username
        if ($user_result && $user_row = $user_result->fetch_assoc()) {
            return $user_row['username'];
        } else {
            return false; // User not found
        }
    } else {
        return false; // Recipe not found or user_id is invalid
    }
}
}




 
