<?php
class Style extends DatabaseObject
{
    static protected $table_name = 'style';
    static protected $db_columns = ['style_id', 'style_name',];

    public $style_id;
    public $style_name;

    public function __construct($args = [])
    {
        $this->style_id = $args['style_id'] ?? null;
        $this->style_name = $args['style_name'] ?? '';
    }

}