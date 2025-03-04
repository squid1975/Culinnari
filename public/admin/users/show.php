<?php require_once('../../../private/initialize.php'); ?>
<?php $pageTitle = "Management - Create User | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php require_admin_login(); ?>

<?php

$id = $_GET['user_id'] ?? '1'; // PHP > 7.0

$user = User::find_by_id($id);

?>

<?php $pageTitle = 'Management - User ' . h($user->username); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/admin/index.php'); ?>">&laquo; Back to List</a>

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
        <dt>Food</dt>
        <dd><?php echo h($user->food); ?></dd>
      </dl>
      <dl>
        <dt>Conservation</dt>
        <dd><?php echo h($user->user_email_address); ?></dd>
      </dl>
      <dl>
        <dt>Backyard Tips</dt>
        <dd><?php echo h($user->backyard_tips); ?></dd>
      </dl>
    </div>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>