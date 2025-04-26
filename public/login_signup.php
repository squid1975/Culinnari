<?php require('../private/initialize.php');
$title = 'Login | Culinnari';
include SHARED_PATH . '/public_header.php';
if($session->is_logged_in()) {
  redirect_to(url_for('/member/profile.php?id=' . $session->user_id));
}
$signup_errors = [];
$login_errors = [];

$username = '';
$recaptcha_secret = RECAPTCHA_SECRET_KEY;

if (is_post_request()) {

      // If the form was submitted for user registration
    if (isset($_POST['user'])) {

      // Check if reCAPTCHA response exists in the POST data
      $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

      if ($recaptcha_response) {
        // Prepare the URL for reCAPTCHA verification
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

        // Send a POST request to verify reCAPTCHA
        $verify_response = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        
        // Decode the JSON response from Google
        $response_data = json_decode($verify_response);

        // If CAPTCHA validation fails, add an error message
        if (!$response_data->success) {
          $signup_errors[] = 'CAPTCHA validation failed. Please try again.';
          
        } else {
          // If CAPTCHA is validated successfully, proceed with user registration

          // Create record using post parameters
          $args = $_POST['user'];
          $user = new user($args);
          $result = $user->save();

          if ($result === true) {
            // If user is saved successfully, log them in and redirect
            $new_id = $user->id;
            $session->login($user);
            $_SESSION['message'] = 'You have been signed up successfully.';
            redirect_to(url_for('/member/profile.php?id=' . $new_id));
          } else {
            // If there were errors saving the user, show them
            $signup_errors = $user->errors;
          }
        }
      } else {
        // If no CAPTCHA response is provided, show an error
        $signup_errors[] = 'Please complete the CAPTCHA.';
        
      }
    } else {
      // Display the form if no post data was received
      $user = new user;
    }


  // Handle login process
if (isset($_POST['username']) && isset($_POST['password'])) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  
  // Check if reCAPTCHA response exists in the POST data
  $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

  if ($recaptcha_response) {
    // Prepare the URL for reCAPTCHA verification
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';

    // Send a POST request to verify reCAPTCHA
    $verify_response = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

    // Decode the JSON response from Google
    $response_data = json_decode($verify_response);

    // If CAPTCHA validation fails, add an error message
    if (!$response_data->success) {
      $login_errors[] = 'CAPTCHA validation failed. Please try again.';
    }
  } else {
    // If no CAPTCHA response is provided, show an error
    $login_errors[] = 'Please complete the CAPTCHA.';
  }

  // Validations for username and password
  if (is_blank($username)) {
    $login_errors[] = "Username cannot be blank.";
  }
  if (is_blank($password)) {
    $login_errors[] = "Password cannot be blank.";
  }

  // If there are no errors, attempt login
  if (empty($login_errors)) {
    $user = User::find_by_username($username);
    if (!$user) {
      $login_errors[] = "User not found.";
    } elseif ($user->user_is_active == 0) {
      $login_errors[] = "Your account is inactive. Please contact support.";
    } else {
      // Check if password is correct
      if ($user->verify_password($password)) {
        // Mark user as logged in
        $session->login($user);

        // Redirect based on user role
        if ($session->is_mgmt_logged_in()) {
          redirect_to(url_for('/admin/index.php')); // Admin page
        } else {
          redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
        }
      } else {
        // Password doesn't match
        $login_errors[] = "Log in was unsuccessful. If issues persist, please contact support at hello@culinnari.com.";
      }
    }
  }
}

}
?>
<script src="<?php echo url_for('/js/loginSignup.js'); ?>" defer></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
            <div class="formField">
              <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>" data-action="LOGIN"></div>
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

            <div class="signupFormField">
              <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>" data-action="signup"></div>
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