<?php

class User extends DatabaseObject
{
    protected static $table_name = 'user';
    protected static $db_columns = [ 
        'username', 'user_email_address', 'user_hash_password',
        'user_first_name', 'user_last_name', 'user_create_account_date',
        'user_role', 'user_is_active'
    ];

    public $id;
    public $username;
    public $user_email_address;
    public $user_hash_password;
    public $user_first_name;
    public $user_last_name;
    public $user_create_account_date;
    public $user_role;
    public $user_is_active;
    public $password;
    public $confirm_password;
    protected $password_required = true;

    public function __construct($args = [])
    {
        $this->username = $args['username'] ?? '';
        $this->user_email_address = $args['user_email_address'] ?? '';
        $this->user_hash_password = $args['user_hash_password'] ?? '';
        $this->password = $args['password'] ?? ''; 
        $this->confirm_password = $args['confirm_password'] ?? '';
        $this->user_first_name = $args['user_first_name'] ?? '';
        $this->user_last_name = $args['user_last_name'] ?? '';
        $this->user_create_account_date = $args['user_create_account_date'] ?? date('Y-m-d');
        $this->user_role = $args['user_role'] ?? 'm';
        $this->user_is_active = $args['user_is_active'] ?? 1;
    }

    public function full_name()
    {
        return $this->user_first_name . " " . $this->user_last_name;
    }

    public function set_hashed_password() {
        $hashed_pass = password_hash($this->password, PASSWORD_BCRYPT);
        return $this->user_hash_password = $hashed_pass;
    }

   public function verify_password($password) {
    return password_verify($password, $this->user_hash_password ?? '');
   }

    protected function create()
    {
        $this->set_hashed_password();
        return parent::create();
    }

    protected function update()
    {
        if ($this->password != '') {
            $this->set_hashed_password();
        } else {
            $this->password_required = false;
        }
        return parent::update();
    }

    public function validate()
    {
        $this->errors = [];
    
        // Validate first name
        if (is_blank($this->user_first_name)) {
            $this->errors['user_first_name'][] = "First name cannot be blank.";
        }
        if (!has_length($this->user_first_name, ['min' => 2, 'max' => 100])) {
            $this->errors['user_first_name'][] = "First name must be between 2 and 100 characters.";
        }
    
        // Validate last name
        if (is_blank($this->user_last_name)) {
            $this->errors['user_last_name'][] = "Last name cannot be blank.";
        }
        if (!has_length($this->user_last_name, ['min' => 2, 'max' => 100])) {
            $this->errors['user_last_name'][] = "Last name must be between 2 and 100 characters.";
        }
    
        // Validate email address
        if (is_blank($this->user_email_address)) {
            $this->errors['user_email_address'][] = "Email cannot be blank.";
        }
        if (!has_valid_email_format($this->user_email_address)) {
            $this->errors['user_email_address'][] = "Email must be a valid format.";
        }
    
        // Validate username
        if (is_blank($this->username)) {
            $this->errors['username'][] = "Username cannot be blank.";
        }
        if (!has_length($this->username, ['min' => 8, 'max' => 32])) {
            $this->errors['username'][] = "Username must be between 8 and 32 characters.";
        }
        if (!has_unique_username($this->username, $this->id ?? 0)) {
            $this->errors['username'][] = "Username not allowed. Try another.";
        }
    
        // Validate password (if required)
        if ($this->password_required) {
            if (is_blank($this->password)) {
                $this->errors['password'][] = "Password cannot be blank.";
            }
            if (!has_length($this->password, ['min' => 12])) {
                $this->errors['password'][] = "Password must contain 12 or more characters.";
            }
            if (!preg_match('/[A-Z]/', $this->password)) {
                $this->errors['password'][] = "Password must contain at least 1 uppercase letter.";
            }
            if (!preg_match('/[a-z]/', $this->password)) {
                $this->errors['password'][] = "Password must contain at least 1 lowercase letter.";
            }
            if (!preg_match('/[0-9]/', $this->password)) {
                $this->errors['password'][] = "Password must contain at least 1 number.";
            }
            if (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
                $this->errors['password'][] = "Password must contain at least 1 symbol.";
            }
    
            // Validate confirm password only if password is required
            if (is_blank($this->confirm_password)) {
                $this->errors['confirm_password'][] = "Confirm password cannot be blank.";
            }
            if ($this->password !== $this->confirm_password) {
                $this->errors['confirm_password'][] = "Password and confirm password must match.";
            }
        }
    
        return $this->errors;
    }
    

    public static function find_by_username($username) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }   
    }

    

}
?>
