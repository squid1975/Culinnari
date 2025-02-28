<?php 
 require_login();
 $username = $session->username;
 $user = User::find_by_username($username);
 ?> 

<div id="memberNav">
    <div>
    <a href="<?php echo url_for('/member/profile.php'); ?>" >
        <img src="<?php echo url_for('/images/icon/memberIcon.svg');
             ?>" width="30" height="30" alt="User Icon" title="User Profile"> <?php echo $user->username; ?>
    </a>
    </div>
    <div>         
        <a href="<?php echo url_for('/member/create_recipe.php'); ?>">
            <img src="<?php echo url_for('/images/icon/addRecipe.svg'); ?>" width="20" height="20" alt="Add recipe icon" title="Add recipe">
            Post a recipe</a>
        <a href="<?php echo url_for('/logout.php'); ?> ">
            <img src="<?php echo url_for('/images/icon/logout.svg'); ?>" width="20" height="20" alt="Logout Icon" title="Logout">
            Logout</a>
    </div>        
</div>