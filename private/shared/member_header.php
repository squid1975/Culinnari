<?php 
 require_login();
 $username = $session->username;
 $user = User::find_by_username($username);
 ?> 

<div id="memberNav">
    <input type="checkbox" id="userMenuToggle">
    <label for="userMenuToggle">
        <img src="<?php echo url_for(script_path: '/images/icon/memberIcon.svg');?>" width="30" height="30" alt="User Icon" title="User Profile"> </a>
    </label>
    <div id="userMenu"> 
        <a href="<?php echo url_for('/member/profile.php'); ?>">
            <img src="<?php echo url_for('/images/icon/profileIcon.svg'); ?>" width="20" height="20" alt="Profile icon" title="My Culinnari Profile Icon">My Profile</a>        
        <a href="<?php echo url_for('/member/create_recipe.php'); ?>">
            <img src="<?php echo url_for('/images/icon/addRecipe.svg'); ?>" width="20" height="20" alt="Add recipe icon" title="Add recipe">
            Create recipe</a>
        <a href="<?php echo url_for('/logout.php'); ?> ">
            <img src="<?php echo url_for('/images/icon/logout.svg'); ?>" width="20" height="20" alt="Logout Icon" title="Logout">
            Logout <?php echo $user->username; ?> </a>
    </div>        
</div>