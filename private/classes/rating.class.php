<?php

class Rating extends DatabaseObject {
    
    static protected $table_name = 'rating';
    static protected $db_columns = ['rating_id','user_id', 'recipe_id', 'rating_value', 'rating_date'];

    public $rating_id;
    public $user_id;
    public $recipe_id;
    public $rating_value;
    public $rating_date;

    public function __construct($args = [])
    {
        $this->rating = $args['rating'] ?? '';
        $this->recipe_id = $args['recipe_id'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->rating_date = $args['rating_date'] ?? CURRENT_TIMESTAMP;
    }

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->rating)) {
            $this->errors[] = "Rating cannot be blank.";
        }

        if (is_blank($this->recipe_id)) {
            $this->errors[] = "Recipe ID cannot be blank.";
        }

        if (is_blank($this->user_id)) {
            $this->errors[] = "User ID cannot be blank.";
        }

        return $this->errors;
    }

    public function getRecipe()
    {
        if (!$this->recipe) {
            $this->recipe = Recipe::find_by_id($this->recipe_id);
        }
        return $this->recipe;
    }

    public function getUser()
    {
        if (!$this->user) {
            $this->user = User::find_by_id($this->user_id);
        }
        return $this->user;
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
        if ($count == 1) {
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
        return
}


?>
