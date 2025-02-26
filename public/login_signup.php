<?php 
require_once('../private/initialize.php'); 
$pageTitle = "Login/Signup | Culinnari"; 
include(SHARED_PATH . '/public_header.php'); 



$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

    if(isset($_POST['signup'])) {
        // Sign-up form submission
        $args = $_POST['user'];
        $user = new User($args);

        // Password confirmation check
        if($args['user_password'] !== $args['confirm_password']) {
            $errors[] = "Passwords do not match.";
        } else {
            $user->set_hashed_password();
            $result = $user->save();

            if($result === true) {
                $new_id = $user->user_id;
                redirect_to(url_for('/member/profile.php'));
            } else {
                $errors[] =''; 
            }
        }
    }

    if(isset($_POST['login'])) {
        // Login form submission
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validations
        if(is_blank($username)) {
            $errors[] = "Username cannot be blank.";
        }
        if(is_blank($password)) {
            $errors[] = "Password cannot be blank.";
        }

        if(empty($errors)) {
            $user = User::find_by_username($username);
            if($user != false && $user->verify_password($password)) {
                // Mark user as logged in
                $session->login($user);
                if($session->is_logged_in()){
                    redirect_to(url_for('/member/profile.php'));
                }
            } else {
                $errors[] = "Log in was unsuccessful.";
            }
        }
    }
}
?>

<noscript>
    <meta http-equiv="refresh" content="0; url=no_js_version.php">
</noscript>
<main role="main" tabindex="-1">
    <h2 id="loginSignupHeading">Join the Culinnari Community.</h2>

    <div id="loginSignup">
    <?php echo display_errors($errors); ?>
        <div id="createAccountForm">
            <h3>Create an Account</h3>
            <form action="<?php echo url_for('/login_signup.php'); ?>" method="POST" >
                
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

                <input type="submit" name="signup" value="Create Account" class="submit">
            </form>
        </div>

        <div id="loginForm">
            <h3>Already a user? Log in Here!</h3>
            <form action="<?php echo url_for('/login_signup.php'); ?>" method="POST">
                
                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" name="login" value="Log In" class="submit">
            </form>
        </div>
    </div>

</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>  
