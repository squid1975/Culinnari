<?php
class Style extends DatabaseObject
{
    static protected $table_name = 'style';
    static protected $db_columns = ['id','style_name'];

    public $id;
    public $style_name;

    public function __construct($args = [])
    {
        $this->style_name = $args['style_name'] ?? '';
    }

}