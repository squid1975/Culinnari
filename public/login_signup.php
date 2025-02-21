<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Login/Signup | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php if($session->is_logged_in()) {
    $session->logout();
} ?>


<?php
if(is_post_request()) {
  $errors = [];

  if ($_POST['action'] === 'signup') {
    // Signup Logic
    $args = $_POST['user'];
    $user = new User($args);
    $user->set_hashed_password();
    $result = $user->save();

    if ($result === true) {
        $new_id = $user->id;
        $session = new Session();
        $session->login($user); // Ensure user is logged in after signup
        redirect_to(url_for('/member/profile.php'));
    } else {
        // Handle errors
    }
} elseif ($_POST['action'] === 'login') {
    // Login Logic
    $username = $_POST['username'] ?? '';
    $password = $_POST['user_password'] ?? '';
    $session = new Session();
    $user = User::find_by_username($username);
    if ($user && $user->verify_password($password)) {
        $session->login($user);
        redirect_to(url_for('/member/profile.php'));
    } else {
        $errors[] = "Login failed. Please try again.";
    }
}
}
?>

<main role="main" tabindex="-1">
    <h2 id="loginSignupHeading">Join the Culinnari Community.</h2>
    
    <div id="loginSignup">
        <section id="createAccount">
            <h3>Create an Account</h3>
            <form action="<?php echo url_for('/login_signup.php'); ?>" method="POST" class="login-signup-form">
                <input type="hidden" name="action" value="signup">
                <label for="username">Username:</label>
                <input type="text" id="username" name="user[username]" required>

                <label for="userFirstName">First Name:</label>
                <input type="text" id="userFirstName" name="user[user_first_name]" required>

                <label for="userLastName">Last Name:</label>
                <input type="text" id="userLastName" name="user[user_last_name]" required>

                <label for="userEmailAddress">Email Address:</label>
                <input type="email" id="userEmailAddress" name="user[user_email_address]" required>

                <label for="userPassword">Password:</label>
                <input type="password" id="userPassword" name="user[user_password]" required>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="user[confirm_password]" required>

                <input type="submit" value="Create Account">
            </form>
        </section>
        <section id="login">
            <h3>Already a member? Log in Here!</h3>
            
            <form action="login_signup.php" method="POST" class="login-signup-form">
                <input type="hidden" name="action" value="login">
                <label for="username">Username:</label>
                <input type="text" name="user[username]" required>

                <label for="password">Password:</label>
                <input type="password" id=password name="user[user_password]" required>

                <input type="submit" value="Log In">
            </form>
        </section>
    </div>
</main>



<?php include(SHARED_PATH . '/public_footer.php'); ?>