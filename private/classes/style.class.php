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
            $this->errors['style_name'][] = "Style name cannot be blank.";
        } elseif (!has_length($this->style_name, ['min' => 2, 'max' => 50])) {
            $this->errors['style_name'][] = "Style name must be between 2 and 50 characters.";
        } elseif (!preg_match("/^[A-Za-z\-']+( [A-Za-z\-']+)*$/", $this->style_name)) {
            $this->errors['style_name'][] = "Style name can only contain letters, single spaces, hyphens, and apostrophes.";
        } elseif(!has_unique_name($this->style_name, 'Style', $this->id ?? 0,)) {
            $this->errors['style_name'][] = "Style name already exists. Please choose another.";
        }

        return $this->errors;
    }

    /**
     * Validates the style name (checking for uniqueness)
     *  * @return array Array of records where the name already exists
     */
    public static function find_by_name($style_name)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE style_name = '" . self::$database->escape_string($style_name) . "'";
        $result_array = static::find_by_sql($sql);
        if (!empty($result_array)) {
            return array_shift($result_array);
        } else {
            return false;
        }
    }

}