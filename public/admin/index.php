<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "Management Area | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php require_mgmt_login(); ?>

<main role="main" tabindex="-1">
    <div id="adminHero">
        <h2>Management Area</h2>
    </div>
    <section>
        <h3>Categories</h3>
        <a href="<?php echo url_for('/admin/manage_categories.php'); ?>" class="secondaryButton">Manage Categories</a>
    </section>
    <section>
        <h3>Users</h3>
        <a href="<?php echo url_for('/admin/manage_users.php'); ?>" class="secondaryButton">Manage Users</a>
    </section>
</main>
    <?php include(SHARED_PATH . '/public_footer.php'); ?>