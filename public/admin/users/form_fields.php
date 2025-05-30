<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($user)) {
  redirect_to(url_for('/admin/index.php'));
}
?>


  <div class="userFormInput">
    <label for="newUsername">Username:</label>
    <input type="text" id="newUsername" name="user[username]" value="<?php echo h($user->username); ?>" required>
  </div>
  <div id="username-requirements" class="requirements"></div>
  <?php if (isset($signup_errors['username'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['username'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

  <div class="userFormInput">
    <label for="userEmail">User Email Address:</label>
    <input type="email" id="userEmail" name="user[user_email_address]" value="<?php echo h($user->user_email_address); ?>" required>
  </div>
  <div id="email-requirements" class="requirements"></div>
  <?php if (isset($signup_errors['user_email_address'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['user_email_address'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>


  <div class="userFormInput">
    <label for="userFirstName">User First Name:</label>
    <input type="text" id="userFirstName" name="user[user_first_name]" value="<?php echo h($user->user_first_name); ?>" required>
  </div>
  <div id="firstname-requirements" class="requirements"></div>
  <?php if (isset($signup_errors['user_first_name'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['user_first_name'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

  <div class="userFormInput">
    <label for="userLastName">User Last Name:</label>
    <input type="text" id="userLastName" name="user[user_last_name]" value="<?php echo h($user->user_last_name); ?>" required>
  </div>
  <div id="lastname-requirements" class="requirements"></div>
  <?php if (isset($signup_errors['user_last_name'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['user_last_name'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
  

  <div class="userFormInput">
    <label for="newPassword">Password:</label>
    <input type="password" id="newPassword" name="user[password]" value="">
  </div>
  <div id="password-requirements" class="requirements"></div>
  <?php if (isset($signup_errors['password'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['password'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
          

  <div class="userFormInput">
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="user[confirm_password]" value="">
  </div>
  <?php if (isset($signup_errors['confirm_password'])): ?>
                <div class="error-messages">
                  <?php foreach ($signup_errors['confirm_password'] as $error): ?>
                    <p class="error"><?php echo h($error); ?></p>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
  

  <?php if($session->is_super_admin_logged_in()) { ?>
  <div class="userFormInput">
    <fieldset>
      <legend>User Role:</legend>
      <div>
        <label for="userRole">
          <input type="radio" id="userRole" name="user[user_role]" value="m" <?php if ($user->user_role == 'm') echo 'checked'; ?>>
          Member
        </label>
        <label for="adminRole">
          <input type="radio" id="adminRole" name="user[user_role]" value="a" <?php if ($user->user_role == 'a') echo 'checked'; ?>>
          Admin
        </label>
        <label for="superAdminRole">
          <input type="radio" id="superAdminRole" name="user[user_role]" value="s" <?php if ($user->user_role == 's') echo 'checked'; ?>>
          Super Admin
        </label>
      </div>
    </fieldset>
  </div>
<?php } ?>

  <div class="userFormInput">
    <fieldset>
      <legend>Active Level:</legend>
    
    <label for="userIsActiveTrue">
      <input type="radio" id="userIsActiveTrue" name="user[user_is_active]" value="1" checked>Active
    </label>
    <label for="userIsActiveFalse">
      <input type="radio" id="userIsActiveFalse" name="user[user_is_active]" value="0">Inactive
    </label>
    </fieldset>
  </div>


