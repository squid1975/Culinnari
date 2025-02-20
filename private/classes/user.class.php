<?php

class User extends DatabaseObject
{

  static protected $table_name = 'user';
  static protected $db_columns = ['id', 'username', 'user_email_address', 'user_hash_password', 'user_first_name', 'user_last_name', 'user_create_account_date', 'user_role', 'user_is_active'];

  public $id;
  public $username;
  public $user_email_address;
  public $user_hash_password;
  public $user_first_name;
  public $user_last_name;
  public $user_create_account_date;
  public $user_role;
  public $user_is_active;


  public function __construct($args = [])
  {
    $this->username = $args['username'] ?? '';
    $this->user_email_address = $args['user_email_address'] ?? '';
    $this->user_hash_password = $args['user_hash_password'] ?? '';
    $this->user_first_name = $args['user_first_name'] ?? '';
    $this->user_last_name = $args['user_last_name'] ?? '';
    $this->user_create_account_date = $args['user_create_account_date'] ?? '';
    $this->user_role = $args['user_role'] ?? 'member';
    $this->user_is_active = $args['user_is_active'] ?? 1;
  }


  public function full_name() {
    return $this->user_first_name . " " . $this->user_last_name;
}

public function set_hashed_password() {
    $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
}

public function verify_password($password) {
    return password_verify($password, $this->hashed_password);
}

protected function create() {
    $this->set_hashed_password();
    return parent::create();
}

protected function update() {
    if($this->password != '') {
        $this->set_hashed_password();
        // validate password
    } else {
        // password not being updated, skip hashing and validation
        $this->password_required = false;
    }
    return parent::update();
}

protected function validate() {
    $this->errors = [];

    if(is_blank($this->first_name)) {
        $this->errors[] = "First name cannot be blank.";
    } elseif (!has_length($this->first_name, array('min' => 2, 'max'=> 255))) {
        $this->errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($this->last_name)) {
        $this->errors[] = "Last name cannot be blank.";
    } elseif (!has_length($this->last_name, array('min' => 2, 'max'=> 255))) {
        $this->errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($this->email)) {
        $this->errors[] = "Email cannot be blank.";
    } elseif (!has_length($this->email, array('min' => 2, 'max'=> 255))) {
        $this->errors[] = "Email must be between 2 and 255 characters.";
    } elseif (!has_valid_email_format($this->email)) {
        $this->errors[] = "Email must be a valid format.";
    }

    if(is_blank($this->username)) {
        $this->errors[] = "Username cannot be blank.";
    } elseif (!has_length($this->username, array('min' => 8, 'max'=> 255))) {
        $this->errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($this->username, $this->id ?? 00)) {
        $this->errors[] = "Username not allowed. Try another.";
    }

    if($this->password_required) {
        if(is_blank($this->password)) {
            $this->errors[] = "Password cannot be blank.";
        } elseif (!has_length($this->password, array('min' => 12))) {
            $this->errors[] = "Password must contain 12 or more characters";
        } elseif (!preg_match('/[A-Z]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 uppercase letter";
        } elseif (!preg_match('/[a-z]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 lowercase letter";
        } elseif (!preg_match('/[0-9]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 number";
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
            $this->errors[] = "Password must contain at least 1 symbol";
        }

        if(is_blank($this->confirm_password)) {
            $this->errors[] = "Confirm password cannot be blank.";
        } elseif ($this->password !== $this->confirm_password) {
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

}

?>
}