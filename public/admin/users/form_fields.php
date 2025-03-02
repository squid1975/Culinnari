<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($user)) {
  redirect_to(url_for('/admin/index.php'));
}
?>

<dl>
  <dt>Username</dt>
  <dd><input type="text" name="user[username]" value="<?php echo h($user->username); ?>" ></dd>
</dl>

<dl>
  <dt>User Email Address</dt>
  <dd><input type="text" name="user[user_email_address]" value="<?php echo h($user->user_email_address); ?>" ></dd>
</dl>

<dl>
  <dt>User First Name</dt>
  <dd><input type="text" name="user[user_first_name]" value="<?php echo h($user->username); ?>" ></dd>
</dl>

<dl>
  <dt>User Last Name</dt>
  <dd><input type="text" name="user[user_last_name]" value="<?php echo h($user->username); ?>" ></dd>
</dl>

<dl>
  <dt>Account Creation Date</dt>
  <dd><input type="text" name="user[username]" value="<?php echo h($user->username); ?>" ></dd>
</dl>

<dl>
  <dt>Role</dt>
  <dd><input type="text" name="user[username]" value="<?php echo h($user->username); ?>" ></dd>
</dl>

<dl>
  <dt>Password</dt>
  <dd><input type="password" name="user[password]" value="" ></dd>
</dl>

<dl>
  <dt>Confirm password</dt>
  <dd><input type="password" name="user[confirm_password]" value="" ></dd>
</dl>

<?php if($session->is_super_admin_logged_in()) { ?>
<dl>
  <dt>User level (Enter 'a' for Admin or 'm' for user)</dt>
  <dd><input type="text" name="user[user_level]" value="<?php echo h($user->user_level); ?>" ></dd>
</dl>
<?php } ?>