<?php require_once('../../../private/initialize.php'); 
$title = 'Management: Create User | Culinnari';
include(SHARED_PATH . '/public_header.php'); 

if(is_post_request()) {

  // Create record using post parameters
  $args = $_POST['user'];
  $user = new User($args);
  $user->set_hashed_password();
  $result = $user->save();

  if($result === true) {
    $new_id = $user->id;
    $_SESSION['message'] = 'The user was created successfully.';
    redirect_to(url_for('/admin/users/show.php?id=' . $new_id));
  } else {
    redirect_to(url_for('/admin/users/new.php'));
    // Display errors if save failed
    $_SESSION['message'] = 'Unable to create user. Please try again later.';
  }

} else {
  // Display the blank form
  $user = new User;
}

?>
<script src="<?php echo url_for('/js/loginSignup.js'); ?>" defer></script>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area: New User</h2>
    </div>
    <div class="wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to User Index</a>
      <div class="manageUserCard">
        <h2>Create User</h2>
        <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>

        <?php echo display_errors($user->errors); ?>

        <form action="<?php echo url_for('/admin/users/new.php'); ?>" method="post">

            <?php include('form_fields.php'); ?>

            <input type="submit" value="Create User">
        </form>
        </div>
</div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>