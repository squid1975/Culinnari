<?php 

class Cookbook extends DatabaseObject {
    protected static $table_name = 'cookbook';
    protected static $db_columns = ['id','cookbook_name', 'user_id'];
    
    public $id;
    public $cookbook_name;
    public $user_id;
    
    public function __construct($args=[]) {
        $this->cookbook_name = $args['cookbook_name'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
    }
    
   
}

?>