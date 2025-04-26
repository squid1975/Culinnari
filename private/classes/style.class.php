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

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->style_name)) {
            $this->errors[] = "Style name cannot be blank.";
        } elseif (!has_length($this->style_name, ['min' => 2, 'max' => 50])) {
            $this->errors[] = "Style name must be between 2 and 50 characters.";
        } elseif (!preg_match("/^[A-Za-z\-']+$/", $this->style_name)) {
            $this->errors[] = "Style name can only contain letters, hyphens, and apostrophes.";
        }

        return $this->errors;
    }

}