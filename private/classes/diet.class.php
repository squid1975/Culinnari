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
            $this->errors['diet_name'][] = "Diet name cannot be blank.";
        } elseif (!has_length($this->diet_name, ['min' => 2, 'max' => 50])) {
            $this->errors['diet_name'][] = "Diet name must be between 2 and 50 characters.";
        } elseif (!preg_match("/^[A-Za-z\-']+( [A-Za-z\-']+)*$/", $this->diet_name)) {
            $this->errors['diet_name'][] = "Diet name can only contain letters, single spaces, hyphens, and apostrophes.";
        } elseif(!has_unique_name($this->diet_name, 'Diet', $this->id ?? 0,)) {
            $this->errors['diet_name'][] = "Diet name already exists. Please choose another.";
        }

        return $this->errors;
    }

     /**
     * Validates the diet name (checking for uniqueness)
     *  * @return array Array of records where the name already exists
     */
    public static function find_by_name($diet_name)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE diet_name = '" . self::$database->escape_string($diet_name) . "'";
        $result_array = static::find_by_sql($sql);
        if (!empty($result_array)) {
            return array_shift($result_array);
        } else {
            return false;
        }
    }
    
}
