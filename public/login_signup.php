<?php require('../private/initialize.php'); 
$pageTitle = "Login / Signup | Culinnari"; 
include SHARED_PATH . '/public_header.php'; 
$signup_errors = [];
$login_errors = [];

if(!isset($user)){
  $user = new User;
}

$username = '';

if(is_post_request()) {

  if(isset($_POST['user'])){
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
      $signup_errors = $user->errors;
  }
  
  } else {
  // display the form
  $user = new user;
  }

  if(isset($_POST['username']) && isset($_POST['password'])){

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if (is_blank($username)) {
    $login_errors[] = "Username cannot be blank.";
  }
  if (is_blank($password)) {
    $login_errors[] = "Password cannot be blank.";
  }

  // If there were no errors, try to login
  if (empty($errors)) {
    $user = User::find_by_username($username);
    if (!$user) {
      $login_errors[] = "User not found.";
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
        $login_errors[] = "Log in was unsuccessful.";
      }
    }
  }
}
}
?>

<main role="main" tabindex="-1">
  <div class="loginSignupWrapper">
    <div id="wrapper">
      
      <div id="loginSignupPage">
        <div> 
          <h2>New User? Sign up here!</h2>
          <?php echo display_errors($signup_errors); ?>
            <form action="" method="post" id="newUserForm">
                
                <div class="formField">
                <label for="newUsername">Username:</label>
                <input type="text" id="newUsername" name="user[username]" value="<?php echo $user->username; ?>"required>
                </div>
                <div class="formField">
                <label for="userFirstName">First Name:</label>
                <input type="text" id="userFirstName" name="user[user_first_name]" value="<?php echo $user->user_first_name; ?>" required>
                </div>
                <div class="formField">
                <label for="userLastName">Last Name:</label>
                <input type="text" id="userLastName" name="user[user_last_name]" value="<?php echo $user->user_last_name; ?>" required>
                </div>
                <div class="formField">
                <label for="userEmailAddress">Email Address:</label>
                <input type="email" id="userEmailAddress" name="user[user_email_address]" value="<?php echo $user->user_email_address; ?>" required>
                </div>
                <div class="formField">
                <label for="newPassword">Password:</label>
                <input type="password" id="newPassword" name="user[password]" value="" required>
                </div>
                <div class="formField">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="user[confirm_password]" value="" required>
                </div>
                <input type="submit" value="Create Account" class="loginSignupButton">
            </form>
          </div> 
          <div>
          <h2>Returning user? Log in here!</h2>
          <?php echo display_errors($login_errors); ?>
          <form action="" method="POST">
          
                    <div class="formField">
                      <label for="username">Username:</label>
                      <input type="text" id="username" name="username" value="<?php echo h($username);?>" required>
                    </div>
                    <div class="formField">
                    <label for="password">Password:</label> 
                    <input type="password" id="password" name="password" value="" required>
                    </div>
                    <input type="submit" name="login" value="Log in" class="loginSignupButton">
                </form>
          </div>
      </div>
  </div>
</main>
<?php include SHARED_PATH . '/public_footer.php'; ?>
