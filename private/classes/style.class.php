<?php
class Style extends DatabaseObject
{
    protected static $table_name = 'style';
    protected static $db_columns = [
        'id',
        'style_name'];

    public $id;
    public $style_name;

    public function __construct($args = [])
    {
        $this->style_name = $args['style_name'] ?? '';
    }

}