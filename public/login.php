<?php

require('../private/initialize.php');
$errors = [];
$username = '';
$password = '';

if (is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if (is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if (is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // If there were no errors, try to login
  if (empty($errors)) {
    $user = User::find_by_username($username);
    if (!$user) {
      $errors[] = "User not found.";
    } else {
      // Test if user found and password is correct
      if ($user->verify_password($password)) {
        // Mark user as logged in
        $session->login($user);

        if ($session->is_mgmt_logged_in()) {
          redirect_to(url_for('/admin/index.php')); // Admin page
        } else {
          redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
        }
      } else {
        // Username not found or password does not match
        $errors[] = "Log in was unsuccessful.";
      }
    }
  }
}

?>