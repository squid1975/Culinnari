<?php

class Rating extends DatabaseObject {
    
    protected static $table_name = 'rating';
    protected static $db_columns = ['user_id', 'recipe_id', 'rating_value', 'rating_date'];

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

    protected function validate()
    {
        $this->errors = [];

        if (empty($this->rating_value)) {
            $this->errors[] = "Rating cannot be blank.";
        }
        return $this->errors;
    }

  

    public function getRatingCount()
    {
        $sql = "SELECT COUNT(*) FROM rating ";
        $sql .= "WHERE recipe_id='" . self::$database->escape_string($this->recipe_id) . "'";

        $result = self::$database->query($sql);
        $row = $result->fetch_row();
        return array_shift($row);
    }

    public function getRatingCountString()
    {
        $count = $this->getRatingCount();
        if(!$count){
            return "Unrated";
        }
        elseif ($count == 1) {
            return "1 rating";
        } else {
            return "{$count} ratings";
        }
    }

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


?>
