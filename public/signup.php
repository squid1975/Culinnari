<?php
require('../private/initialize.php');
if(is_post_request()) {

// Create record using post parameters
$args = $_POST['user'];
$user = new user($args);
$result = $user->save();

if($result === true) {
  $new_id = $user->id;
  $session->login($user);
  $_SESSION['message'] = 'You have been signed up successfully.';
  redirect_to(url_for('/member/profile.php'));
} else {
    $errors = [];
}

} else {
// display the form
$user = new user;
}



