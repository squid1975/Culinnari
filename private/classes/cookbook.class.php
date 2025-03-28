<?php 

class Cookbook extends DatabaseObject {
    protected static $table_name = 'cookbook';
    protected static $db_columns = ['id','cookbook_name', 'user_id'];
    
    public $id;
    public $cookbook_name;
    public $user_id;
    
    public function __construct($args=[]) {
        $this->cookbook_name = $args['cookbook_name'] ?? ($_SESSION['username'] . (str_ends_with($_SESSION['username'], 's') ? "' cookbook" : "'s cookbook"));
        $this->user_id = $args['user_id'] ?? $_SESSION['user_id'];
    }

    public static function find_by_user_id($user_id){
        $sql = 'SELECT * FROM ' . static::$table_name . ' ';
        $sql .= 'WHERE user_id = ' . $user_id;

        return self::find_by_sql($sql);
    }

   
}

?>