<?php require('../private/initialize.php');
$title = 'Login | Culinnari';
include SHARED_PATH . '/public_header.php';
if($session->is_logged_in()) {
  redirect_to(url_for('/member/profile.php?id=' . $session->user_id));
}
$signup_errors = [];
$login_errors = [];

$username = '';

if (is_post_request()) {

  if (isset($_POST['user'])) {
    // Create record using post parameters
    $args = $_POST['user'];
    $user = new user($args);
    $result = $user->save();

    if ($result === true) {
      $new_id = $user->id;
      $session->login($user);
      $_SESSION['message'] = 'You have been signed up successfully.';
      redirect_to(url_for('/member/profile.php?id=' . $new_id));
    } else {
      $signup_errors = $user->errors;
      
    }

  } else {
    // display the form
    $user = new user;
  }

  if (isset($_POST['username']) && isset($_POST['password'])) {

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
      } elseif ($user->user_is_active == 0) {
        $login_errors[] = "Your account is inactive. Please contact support.";
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
          $login_errors[] = "Log in was unsuccessful. If issues persist, please contact support at hello@culinnari.com.";
        }
      }
    }
  }
}
?>
<script src="<?php echo url_for('/js/loginSignup.js'); ?>" defer></script>
<main role="main" tabindex="-1">
    <div class="wrapper">

      <div class="container">
        <input type="checkbox" id="check" <?php echo is_signup_error_present() ? 'checked' : ''; ?>>

        <div class="login form">
          <h2>Log In</h2>

          <?php echo display_errors($login_errors); ?>
          <form action="login_signup.php" method="POST">
            <div class="formField">
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" value="<?php echo h($username); ?>" required>
            </div>
            <div class="formField">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" value="" required>
            </div>
            <input type="submit" name="login" value="Log in" class="loginSignupButton">
          </form>
          <div class="signup">
            <span class="signup">New to Culinnari?
              <label for="check">Create an Account</label>
            </span>
          </div>
        </div>

        <div class="registration form">
          <h2 id="signupHeading">Signup</h2>
          <form action="login_signup.php" method="post" id="newUserForm">

            <!-- Username Field -->
            <div class="signupFormField">
              <div class="signupInput">
                <label for="newUsername">Username:</label>
                <div id="username-requirements" class="requirements"></div>
                <input type="text" id="newUsername" name="user[username]"
                  value="<?php echo h($user->username ?? ''); ?>" maxlength="25" pattern="^[A-Za-z][A-Za-z0-9_]{4,24}$" required>
              </div>
              <?php if (isset($signup_errors['username'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['username'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- First Name Field -->
            <div class="signupFormField">
              <div class="signupInput">
                <label for="userFirstName">First Name:</label>
                <div id="firstname-requirements" class="requirements"></div>
                <input type="text" id="userFirstName" name="user[user_first_name]"
                  value="<?php echo h($user->user_first_name ?? ''); ?>" maxlength="25" pattern="[A-Za-z\s\-']+" required>
              </div>
              <?php if (isset($signup_errors['user_first_name'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['user_first_name'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Last Name Field -->
            <div class="signupFormField">
              <div class="signupInput">
                <label for="userLastName">Last Name:</label>
                <div id="lastname-requirements" class="requirements"></div>
                <input type="text" id="userLastName" name="user[user_last_name]"
                  value="<?php echo h($user->user_last_name ?? ''); ?>" maxlength="25" pattern="[A-Za-z\s\-']+" required>
              </div>
              <?php if (isset($signup_errors['user_last_name'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['user_last_name'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Email Address Field -->
            <div class="signupFormField">
              <div class="signupInput">
                <label for="userEmailAddress">Email Address:</label>

                <input type="email" id="userEmailAddress" name="user[user_email_address]"
                  value="<?php echo h($user->user_email_address ?? ''); ?>" maxlength="50" required>
              </div>
              <?php if (isset($signup_errors['user_email_address'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['user_email_address'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="signupFormField">
              <div class="signupInput">
                <label for="newPassword">Password:</label>
                <div id="password-requirements" class="requirements"></div>
                <input type="password" id="newPassword" name="user[password]" value="" maxlength="255" required>
              </div>
              <?php if (isset($signup_errors['password'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['password'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Confirm Password Field -->
            <div class="signupFormField">
              <div class="signupInput">
                <label for="confirmPassword">Confirm Password:</label>
                <div id="confirmPassword-requirements" class="requirements"></div>
                <input type="password" id="confirmPassword" name="user[confirm_password]" value="" maxlength="255" required>
              </div>
              <?php if (isset($signup_errors['confirm_password'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['confirm_password'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>

            <input type="submit" value="Create Account" class="loginSignupButton">
          </form>
          <div class="signup">
            <span class="signup">Already have an account?
              <label for="check" aria-labelledby="check">Log In</label>
            </span>
          </div>
        </div>
      </div>
    </div>
</main>
<?php include SHARED_PATH . '/public_footer.php'; ?>