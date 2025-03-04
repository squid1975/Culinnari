<?php require_once('../../../private/initialize.php'); ?>
<?php $pageTitle = "Management - Edit User | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>

    <?php
require_admin_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);

if(is_post_request()) {

  // Save record using post parameters
  $args = $_POST['user'];
  $user->merge_attributes($args);
  $result = $user->save();

  if($result === true) {
    $_SESSION['message'] = 'User updated successfully.';
    redirect_to(url_for('/users/show.php?id=' . $id));
  } else {
    // show errors
    
  }

} else {

  // display the form

}

?>


<div id="content">

  <a class="back-link" href="<?php echo url_for('/users/users.php'); ?>">&laquo; Back to List</a>

  <div class="user edit">
    <h1>Edit user</h1>

    <?php echo display_errors($user->errors); ?>

    <form action="<?php echo url_for('/users/edit.php?id=' . h(u($id))); ?>" method="post">

      
      <?php 
      include('form_fields.php'); 
      ?>

      <div id="operations">
        <input type="submit" value="Edit user" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>