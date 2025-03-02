<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Login | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); 

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
          redirect_to(url_for('/member/profile.php')); // Regular user page
        }
      } else {
        // Username not found or password does not match
        $errors[] = "Log in was unsuccessful.";
      }
    }
  }
}

?>

<main role="main">
  <div id="loginSignup">
    <div id="login">
      <h2>Welcome back! Please log in to continue.</h2>
      <p>New user? <a href="<?php echo url_for('signup.php'); ?>">Create your account here!</a></p>
      <?php echo display_errors($errors); ?>

      <form action="<?php echo url_for('/login.php'); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username"name="username" value="<?php echo h($username); ?>">
        
        <label for="password">Password:</label> 
        <input type="password" id="password" name="password" >
        
        <input type="submit" name="login" value="Log in">
      </form>
    </div>
  </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
