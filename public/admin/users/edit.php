<title>Management: Edit User | Culinnari</title>
<?php require_once('../../../private/initialize.php'); 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/admin/users/index.php'));
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
    redirect_to(url_for('/admin/users/show.php?id=' . $user->id));
  } else {
    // show errors
    
  }

} else {

  // display the form

}
?>
<script src="<?php echo url_for('/js/script.js'); ?>" defer></script>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>
    <div class="wrapper">
      <a class="back-link" href="<?php echo url_for('/admin/users/index.php'); ?>">&laquo; Back to User Index</a>
      <div class="manageUserCard">
        <h2>Edit user</h2>
        <?php echo display_errors($user->errors); ?>
        <form action="<?php echo url_for('/admin/users/edit.php?id=' . h(u($id))); ?>" method="post">
          <?php include('form_fields.php'); ?>
          <input type="submit" value="Update User">
        </form>
      </div>
    </div>
</main>
<?php include(SHARED_PATH . '/public_footer.php'); ?>