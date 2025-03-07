<div id="headerLoginSignup">
    <img src="<?php echo url_for('/images/icon/loginSignupIcon.svg');?>">
    <!-- Login Toggle -->
    <input type="checkbox" id="loginToggle" class="toggleCheckbox">
    <label for="loginToggle" class="toggleLabel">Login</label>

    <!-- Login Form -->
    <div id="loginForm">
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label> 
            <input type="password" id="password" name="password" required>
            
            <input type="submit" name="login" value="Log in" class="loginSignupButton">
        </form>
    </div>

    <!-- Signup Toggle -->
    <input type="checkbox" id="signupToggle" class="toggleCheckbox">
    <label for="signupToggle" class="toggleLabel">Sign Up</label>

    <!-- Signup Form -->
    <div id="signupForm">
        <form action="<?php echo url_for('/signup.php'); ?>" method="post">
            <label for="newUsername">Username:</label>
            <input type="text" id="newUsername" name="user[username]" required>

            <label for="userFirstName">First Name:</label>
            <input type="text" id="userFirstName" name="user[user_first_name]" required>

            <label for="userLastName">Last Name:</label>
            <input type="text" id="userLastName" name="user[user_last_name]" required>

            <label for="userEmailAddress">Email Address:</label>
            <input type="email" id="userEmailAddress" name="user[user_email_address]" required>

            <label for="newPassword">Password:</label>
            <input type="password" id="newPassword" name="user[password]" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="user[confirm_password]" required>

            <input type="submit" value="Create Account" class="loginSignupButton">
        </form>
    </div>
</div>