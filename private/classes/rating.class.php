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
        $this->rating = $args['rating'] ?? '';
        $this->recipe_id = $args['recipe_id'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->rating_value = $args['rating_value'] ?? '';
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

    public function getRecipe()
    {
        if (!$this->recipe_id) {
            $this->recipe_id = Recipe::find_by_id($this->recipe_id);
        }
        return $this->recipe_id;
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

    public function getAverageRating()
    {
        $sql = "SELECT AVG(rating) FROM rating ";
        $sql .= "WHERE recipe_id='" . self::$database->escape_string($this->recipe_id) . "'";

        $result = self::$database->query($sql);
        $row = $result->fetch_row();
        return;
    }
}


?>
