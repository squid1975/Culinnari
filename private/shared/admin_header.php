<?php require_login(); ?> 
<div id="adminNav">
    <div>
    <a href="<?php echo url_for('/member/profile.php'); ?>" >
        <img src="<?php echo url_for('/images/icon/adminIcon.svg');
             ?>" width="30" height="30" alt="User Icon" title="User Profile">
             <?php echo h($session->username); ?> (Admin)</a>
    </div>
    <div>         
        <a href="<?php echo url_for('/member/create_recipe.php'); ?>">
            <img src="<?php echo url_for('/images/icon/addRecipe.svg'); ?>" width="20" height="20" alt="Add recipe icon" title="Add recipe">
            Post a recipe</a>     
        <a href="<?php echo url_for('/admin/index.php'); ?>">
            <img src="<?php echo url_for('/images/icon/settings.svg'); ?>" width="20" height="20" alt="Admin Icon" title="Admin Management">
            Management</a>
        <a href="<?php echo url_for('/public/logout.php'); ?> ">
            <img src="<?php echo url_for('/images/icon/logout.svg'); ?>" width="20" height="20" alt="Logout Icon" title="Logout">
            Logout</a>
    </div>
</div>
