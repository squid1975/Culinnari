<?php 

class Cookbook extends DatabaseObject {
    protected static $table_name = 'cookbook';
    protected static $db_columns = [
        'id',
        'cookbook_name', 
        'user_id'];
    
    public $id;
    public $cookbook_name;
    public $user_id;
    public $already_contains_recipe = false;
    
    public function __construct($args=[]) {
        $this->cookbook_name = $args['cookbook_name'] ?? ($_SESSION['username'] . (str_ends_with($_SESSION['username'], 's') ? "' cookbook" : "'s cookbook"));
        $this->user_id = $args['user_id'] ?? $_SESSION['user_id'];
    }

    protected function validate() {
        $this->errors = [];

        if(is_blank($this->cookbook_name)) {
            $this->errors[] = "Cookbook name cannot be blank.";
        } elseif (!has_length($this->cookbook_name, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "Cookbook name must be between 2 and 255 characters.";
        } elseif(!preg_match("^[A-Za-z \-']+$")){
            $this->errors[] = "Cookbook name can only contain letters, spaces, hyphens, and apostrophes.";
        }

        return $this->errors; 
    }

    /**
     * Returns all cookbooks for a user
     * @param mixed $user_id the id value of the user (id in user table, user_id in cookbook table)
     * @return Cookbook[] Array of Cookbook objects
     */
    public static function find_by_user_id($user_id){
        $sql = 'SELECT * FROM ' . static::$table_name . ' ';
        $sql .= 'WHERE user_id = ' . $user_id;
        return self::find_by_sql($sql);
    }

   
}

