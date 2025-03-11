<?php require_mgmt_login(); ?>
<div id="adminNav">
    <input type="checkbox" id="adminMenuToggle">
    <label for="adminMenuToggle">
            <img src="<?php echo url_for('/images/icon/adminIcon.svg'); ?>" width="30" height="30" alt="User Icon" title="User Profile">
            <?php echo h($session->username); ?>
    </label>

    <div id="adminMenu">         
        <a href="<?php echo url_for('/member/profile.php'); ?>">
            <img src="<?php echo url_for('/images/icon/profileIcon.svg'); ?>" width="20" height="20" alt="Profile Icon" title="View culinnari profile">
            My Profile
        </a>     
        <a href="<?php echo url_for('/admin/index.php'); ?>">
            <img src="<?php echo url_for('/images/icon/settings.svg'); ?>" width="20" height="20" alt="Admin Icon" title="Admin Management">
            Management
        </a>
        <a href="<?php echo url_for('/logout.php'); ?>">
            <img src="<?php echo url_for('/images/icon/logout.svg'); ?>" width="20" height="20" alt="Logout Icon" title="Logout">
            Logout
        </a>
    </div>
</div>