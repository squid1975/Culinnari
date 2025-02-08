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
    $this->username = $args[''] ?? '';
    $this->user_email_address = $args['username'] ?? '';
    $this->user_hash_password = $args['user_hash_password'] ?? '';
    $this->user_first_name = $args['user_first_name'] ?? '';
    $this->user_last_name = $args['user_last_name'] ?? '';
    $this->user_create_account_date = $args['user_create_account_date'] ?? '';
    $this->user_role = $args['user_role'] ?? 'member';
    $this->user_is_active = $args['user_is_active'] ?? '';
  }


  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->username)) {
      $this->errors[] = "Username cannot be blank.";
    }

    return $this->errors;
  }
}