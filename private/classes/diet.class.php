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

    protected function validate()
    {
        $this->errors = [];

        if (is_blank($this->diet_name)) {
            $this->errors[] = "Diet name cannot be blank.";
        } elseif (!has_length($this->diet_name, ['min' => 2, 'max' => 50])) {
            $this->errors[] = "Diet name must be between 2 and 50 characters.";
        } elseif (!preg_match("/^[A-Za-z\-']+$/", $this->diet_name)) {
            $this->errors[] = "Diet name can only contain letters, hyphens, and apostrophes.";
        }

        return $this->errors;
    }
    
}
