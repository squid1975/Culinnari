<?php 
class Diet extends DatabaseObject {
    static protected $table_name = 'diet';
    static protected $db_columns = ['diet_id', 'diet_name', 'diet_icon_url'];
    
    public $diet_id;
    public $diet_name;
    public $diet_icon_url;
    
    public function __construct($args=[]) {
        $this->diet_id = $args['diet_id'] ?? null;
        $this->diet_name = $args['diet_name'] ?? '';
        $this->diet_icon_url = $args['diet_icon_url'] ?? '';
    }
    
    public static function find_all() {
        $sql = "SELECT * FROM " . static::$table_name;
        return static::find_by_sql($sql);
    }
}