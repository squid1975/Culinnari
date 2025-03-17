<title>Management: Show User | Culinnari</title>
<?php require_once('../../../private/initialize.php'); 
include(SHARED_PATH . '/public_header.php'); 
require_mgmt_login(); 
$id = $_GET['user_id'] ?? '1'; // PHP > 7.0
$user = User::find_by_id($id);
?>

<?php $pageTitle = 'Management - User ' . h($user->username); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to Management Area</a>

    <h1>User: <?php echo h($user->username); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Username</dt>
        <dd><?php echo h($user->username); ?></dd>
      </dl>
      <dl>
        <dt>First Name</dt>
        <dd><?php echo h($user->user_first_name); ?></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><?php echo h($user->user_last_name); ?></dd>
      </dl>
      <dl>
        <dt>Email Address</dt>
        <dd><?php echo h($user->user_email_address); ?></dd>
      </dl>
      <dl>
        <dt>Create Account Date</dt>
        <dd><?php echo h($user->user_create_account_date); ?></dd>
      </dl>
      <dl>
        <dt>User Role</dt>
        <dd><?php echo h($user->user_role); ?></dd>
      </dl>
    </div>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>