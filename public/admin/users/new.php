<title>Management: Create User | Culinnari</title>
<?php require_once('../../../private/initialize.php'); ?>

<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php
if(is_post_request()) {

// Create record using post parameters
$args = $_POST['user'];
$user = new User($args);
$user->set_hashed_password();
$result = $user->save();

if($result === true) {
  $new_id = $user->id;
  $_SESSION['message'] = 'The user was created successfully.';
  redirect_to(url_for('/users/show.php?id=' . $new_id));
} else {
  // show errors
}

} else {
// display the form
$user = new User;
}

?>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to User Management Area</a>

  <div class="users new">
    <h1>Create User</h1>

    <?php echo display_errors($user->errors); ?>

    <form action="<?php echo url_for('/users/new.php'); ?>" method="post">

      <?php 
        include('form_fields.php'); 
      ?>

      <div id="operations">
        <input type="submit" value="Create User">
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>