<?php

class Rating extends DatabaseObject {
    
    protected static $table_name = 'rating';
    protected static $db_columns = [
        'id',
        'user_id', 
        'recipe_id', 
        'rating_value', 
        'rating_date'];

    public $id;
    public $user_id;
    public $recipe_id;
    public $rating_value;
    public $rating_date;

    public function __construct($args = [])
    {
        $this->user_id = $args['user_id'] ?? 1;
        $this->recipe_id = $args['recipe_id'] ?? 1;
        $this->rating_value = $args['rating_value'] ?? 1;
        $this->rating_date = $args['rating_date'] ?? date('Y-m-d h:m:s');
    }

    /**
     * Validates rating value **FALLBACK FOR REQUIRED ATTRIBUTE**
     * @return array $errors An array of error messages if validation fails
     */
    protected function validate()
    {
        $this->errors = [];
        if (empty($this->rating_value)) {
            $this->errors[] = "Rating cannot be blank.";
        }
        return $this->errors;
    }

    /**
     * Finds the average rating for a recipe
     * @param mixed $recipe_id the recipe_id(id in the recipe table) of the recipe to calculate the average rating for
     * @return float the average rating for the recipe or 0 if no ratings exist
     */
    public static function get_average_rating($recipe_id) {
        $sql = "SELECT AVG(rating_value) AS avg_rating FROM rating ";
        $sql .= "WHERE recipe_id='" . self::$database->escape_string($recipe_id) . "'";
    
        $result = self::$database->query($sql);
    
        if (!$result) {
            die("Database query failed: " . self::$database->error);
        }
    
        $row = $result->fetch_assoc();
        return $row['avg_rating'] ?? 0; // Return the average rating or 0 if null
    }

    /**
     * Finds the rating for a specific user and recipe
     * @param mixed $user_id the user_id (id in the user table) of the user to look up
     * @param mixed $recipe_id the recipe_id (id in the recipe table) of the recipe to look up
     * @return bool|DatabaseObject The Rating object found if a match is found, false otherwise
     */
    public static function find_by_user_and_recipe( $user_id, $recipe_id ) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE user_id='" . self::$database->escape_string($user_id) . "' ";
        $sql .= "AND recipe_id='" . self::$database->escape_string($recipe_id) . "'";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }
}
