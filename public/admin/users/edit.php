<?php require_once('../../../private/initialize.php'); 
$title = 'Management: Edit User | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/users/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);
if($user == false) {
  $_SESSION['message'] = 'User not found.';
  redirect_to(url_for('/admin/users/index.php'));
}

if(is_post_request()) {

  // Save record using post parameters
  $args = $_POST['user'];
  $user->merge_attributes($args);
  $result = $user->save();

  if($result === true) {
    $_SESSION['message'] = 'User updated successfully.';
    redirect_to(url_for('/admin/users/show.php?id=' . $user->id));
  } else {
    // show errors
    $signup_errors = $user->errors;
    
  }

} else {

  // display the form

}
?>
<script src="<?php echo url_for('/js/script.js'); ?>" defer></script>
<main role="main" tabindex="-1">
    <div class="adminHero">
        <h2>Management Area - Edit User</h2>
    </div>
    <div class="wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to User Index</a>
      <div class="manageUserWrapper">
        <h2>Edit user</h2>
        <form action="<?php echo url_for('/admin/users/edit.php?id=' . h(u($user->id))); ?>" method="post">
          <?php include('form_fields.php'); ?>
          <input type="submit" value="Update User" class="createUpdateButton">
        </form>
      </div>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>