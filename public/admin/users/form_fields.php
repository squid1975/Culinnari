<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($user)) {
  redirect_to(url_for('/admin/index.php'));
}
?>


  <div class="userFormInput">
    <label for="newUsername">Username:</label>
    <input type="text" id="newUsername" name="user[username]" value="<?php echo h($user->username); ?>">
  </div>

  <div class="userFormInput">
    <label for="userEmail">User Email Address:</label>
    <input type="email" id="userEmail" name="user[user_email_address]" value="<?php echo h($user->user_email_address); ?>">
  </div>

  <div class="userFormInput">
    <label for="userFirstName">User First Name:</label>
    <input type="text" id="userFirstName" name="user[user_first_name]" value="<?php echo h($user->user_first_name); ?>">
  </div>

  <div class="userFormInput">
    <label for="userLastName">User Last Name:</label>
    <input type="text" id="userLastName" name="user[user_last_name]" value="<?php echo h($user->user_last_name); ?>">
  </div>

  <div class="userFormInput">
    <label for="userPassword">Password:</label>
    <input type="password" id="userPassword" name="user[password]" value="">
  </div>

  <div class="userFormInput">
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="user[confirm_password]" value="">
  </div>

  <?php if($session->is_super_admin_logged_in()) { ?>
  <div class="userFormInput">
    <label>User role:</label>
    <div>
      <label for="adminRole">
        <input type="radio" id="adminRole" name="user[user_role]" value="a" <?php echo ($user->user_role == 'a');?>>
        Admin
      </label>
      <label for="userRole">
        <input type="radio" id="userRole" name="user[user_role]" value="m" <?php echo ($user->user_role == 'm'); ?>>
        User
      </label>
      <label for="superAdminRole">
        <input type="radio" id="superAdminRole" name="user[user_role]" value="s" <?php echo ($user->user_role == 's');?>>
        Super Admin
      </label>
    </div>
  </div>
<?php } ?>


