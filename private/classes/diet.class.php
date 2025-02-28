<?php 
class Diet extends DatabaseObject {
    static protected $table_name = 'diet';
    static protected $db_columns = ['diet_name', 'diet_icon_url'];
    
    public $id;
    public $diet_name;
    public $diet_icon_url;
    
    public function __construct($args=[]) {
        $this->diet_name = $args['diet_name'] ?? '';
        $this->diet_icon_url = $args['diet_icon_url'] ?? '';
    }
    
   
}