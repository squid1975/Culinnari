<?php require_once('../private/initialize.php'); ?>
<?php $pageTitle = "Login/Signup | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<main role="main" tabindex="-1">
    <h2 id="loginSignupHeading">Join the Culinnari Community.</h2>
    <div id="loginSignup">
        <section id="createAccount">
            <h3>Create an Account</h3>
            <form action="login_signup.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="userFirstName">First Name:</label>
                <input type="text" id="userFirstName" name="userFirstName" required>

                <label for="userLastName">Last Name:</label>
                <input type="text" id="userLastName" name="userLastName" required>

                <label for="userEmailAddress">Email Address:</label>
                <input type="email" id="userEmailAddress" name="userEmailAddress" required>

                <label for="password">Password:</label>
                <input type="password" id="userPassword" name="userPassword" required>

                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>

                <input type="submit" name="signUp" value="Create account">
                
            </form>
        </section>
        <section id="login">
            <h3>Already a member? Log in Here!</h3>
            <form action="login_signup.php" method="GET">
                <label for="username">Username:</label>
                <input type="text" name="username" value=" ">

                <label for="password">Password:</label>
                <input type="password" name="password" value="">

                <input type="submit" name="login" value="Log In">
            </form>
        </section>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>