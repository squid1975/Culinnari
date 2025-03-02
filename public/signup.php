<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Create Account | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); 


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

?>


<main role="main" tabindex="-1">

<h2 id="loginSignupHeading">Join the Culinnari Community.</h2>

  
    <div id="loginSignup">
        <div id="createAccountForm">
            <h3>Create an Account</h3>
            <p>Already a user? <a href=<?php echo url_for('login.php'); ?>>Log In Here!</a></p>
            <?php echo display_errors($user->errors); ?>
            <form action="<?php echo url_for('/signup.php'); ?>" method="post">
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="user[username]" required>

                <label for="userFirstName">First Name:</label>
                <input type="text" id="userFirstName" name="user[user_first_name]" required>

                <label for="userLastName">Last Name:</label>
                <input type="text" id="userLastName" name="user[user_last_name]" required>

                <label for="userEmailAddress">Email Address:</label>
                <input type="email" id="userEmailAddress" name="user[user_email_address]" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="user[password]" required>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="user[confirm_password]" required>

                <input type="submit" value="Create Account">
            </form>
        </div>
</main>
        <?php include(SHARED_PATH . '/public_footer.php'); ?>