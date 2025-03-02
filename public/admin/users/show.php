<?php require_once('../../private/initialize.php'); ?>
<?php require_admin_login(); ?>

<?php

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$user = User::find_by_id($id);

?>

<?php $page_title = 'Show Bird: ' . h($bird->common_name); ?>
<?php include(SHARED_PATH . '/member_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/birds/birds.php'); ?>">&laquo; Back to List</a>

  <div class="bird show">

    <h1>Bird: <?php echo h($bird->common_name); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Common Name</dt>
        <dd><?php echo h($bird->common_name); ?></dd>
      </dl>
      <dl>
        <dt>Habitat</dt>
        <dd><?php echo h($bird->habitat); ?></dd>
      </dl>
      <dl>
        <dt>Food</dt>
        <dd><?php echo h($bird->food); ?></dd>
      </dl>
      <dl>
        <dt>Conservation</dt>
        <dd><?php echo h($bird->conservation()); ?></dd>
      </dl>
      <dl>
        <dt>Backyard Tips</dt>
        <dd><?php echo h($bird->backyard_tips); ?></dd>
      </dl>
    </div>

  </div>

</div>