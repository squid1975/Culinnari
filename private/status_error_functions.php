<?php
function require_login (){
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to(url_for('/login_signup.php'));
  }
}

function require_mgmt_login() {
  global $session;
  if(!$session->is_mgmt_logged_in()) {
    redirect_to(url_for('/404.php'));
  } else {
    // Do nothing, allow access
  }
}

function require_super_admin_login() {
  global $session;
  if(!$session->is_super_admin_logged_in()){
    redirect_to(url_for('/login_signup.php'));
  } else {
    // Do nothing, allow access
  }
}

function display_errors($errors = array(), $field = '') {
  $output = '';
  
  // Check if there are errors for a specific field
  if (!empty($errors)) {
    // If no specific field is passed, display the general errors
    if ($field === '') {
      $output .= "<div class=\"errors\">";
      $output .= "Error:";
      $output .= "<ul>";
      foreach ($errors as $error) {
        $output .= "<li>" . h($error) . "</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    } 
    // If a specific field is passed, only display errors for that field
    elseif (isset($errors[$field]) && !empty($errors[$field])) {
      $output .= "<div class=\"error-messages\">";
      foreach ($errors[$field] as $error) {
        $output .= "<p class=\"error\">" . h($error) . "</p>";
      }
      $output .= "</div>";
    }
  }
  
  return $output;
}

