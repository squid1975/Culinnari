<?php 
class Diet extends DatabaseObject {
    protected static $table_name = 'diet';
    protected static $db_columns = [
        'id',
        'diet_name', 
        'diet_icon_url'];
    
    public $id;
    public $diet_name;
    public $diet_icon_url;
    
    public function __construct($args=[]) {
        $this->diet_name = $args['diet_name'] ?? '';
        $this->diet_icon_url = $args['diet_icon_url'] ?? '';
    }
    
}
