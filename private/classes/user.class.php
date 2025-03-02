<?php

class User extends DatabaseObject
{
    static protected $table_name = 'user';
    static protected $db_columns = [
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
        $this->user_hash_password = password_hash($this->password, PASSWORD_BCRYPT);
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

        if (is_blank($this->user_first_name)) {
            $this->errors[] = "First name cannot be blank.";
        } elseif (!has_length($this->user_first_name, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "First name must be between 2 and 255 characters.";
        }

        if (is_blank($this->user_last_name)) {
            $this->errors[] = "Last name cannot be blank.";
        } elseif (!has_length($this->user_last_name, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "Last name must be between 2 and 255 characters.";
        }

        if (is_blank($this->user_email_address)) {
            $this->errors[] = "Email cannot be blank.";
        } elseif (!has_valid_email_format($this->user_email_address)) {
            $this->errors[] = "Email must be a valid format.";
        }

        if (is_blank($this->username)) {
            $this->errors[] = "Username cannot be blank.";
        } elseif (!has_length($this->username, ['min' => 8, 'max' => 255])) {
            $this->errors[] = "Username must be between 8 and 255 characters.";
        } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
            $this->errors[] = "Username not allowed. Try another.";
        }

        if ($this->password_required) {
            if (is_blank($this->password)) {
                $this->errors[] = "Password cannot be blank.";
            } elseif (!has_length($this->password, ['min' => 12])) {
                $this->errors[] = "Password must contain 12 or more characters.";
            } elseif (!preg_match('/[A-Z]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 uppercase letter.";
            } elseif (!preg_match('/[a-z]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 lowercase letter.";
            } elseif (!preg_match('/[0-9]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 number.";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
                $this->errors[] = "Password must contain at least 1 symbol.";
            }

            if (is_blank($this->confirm_password)) {
                $this->errors[] = "Confirm password cannot be blank.";
            } if ($this->password !== $this->confirm_password) {
                $this->errors[] = "Password and confirm password must match.";
            }
        }

        return $this->errors;
    }

    static public function find_by_username($username) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }   
    }

    public static function getUserRecipes($user_id){
        $sql = "SELECT * FROM recipe WHERE user_id ='" . self::$database->escape_string($user_id) . "'";
        return self::find_by_sql($sql);
      }

    

}
?>
