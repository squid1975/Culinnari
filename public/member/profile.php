<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "My Profile | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

 <?php 
 require_login();
 $username = $session->username;
 $user = User::find_by_username($username);
 $role = $session->user_role;
 
 ?> 


<main id="userProfile" role="main" tabindex="-1">
    <div id="profileWrapper">
        <h2 id="profileHeading">My Culinnari Profile</h2>
        <h3>Hello, <?php echo h($user->username);  ?>!</h3>
        
            <div class="profileInfo">
                <h3>My Account</h3>
                     <p>Full Name :  <?php  echo h($user->full_name()); ?> </p>
                     <p>Email Address :  <?php  echo h($user->user_email_address); ?></p>
                     <p>Joined :  <?php  echo h($user->user_create_account_date); ?> </p>
                     <p> <?php echo h($user->user_role); ?> </p>
            </div>
            
                    
           
                 <?php if ($session->is_mgmt_logged_in()) {
                    ?>
                <h3>Management</h3>
                <div id="profileMgmt">
                    <div class="profileMgmtButton">
                        <a href="<?php echo url_for('/admin/manage_categories.php'); ?>">
                            <img src="<?php echo url_for('/images/icon/categories.svg'); ?>">
                            Manage Categories
                        </a>
                    </div>
                    <div class="profileMgmtButton">
                        <a href="<?php echo url_for('/admin/manage_users.php'); ?>">
                            <img src="<?php echo url_for('/images/icon/users.svg'); ?>">
                            Manage Users
                        </a>
                    </div>    
                     <?php  }  ?>
                </div>
            </div>     
        
            
            <div class="profileSectionHead">
                <h3>My Recipes</h3>
                <a href="create_recipe.php" class="createLink">
                    Create recipe</a>
            </div>
            <div class="profileCards">
                <?php 
                $userRecipes = User::getUserRecipes($session->user_id);

                if (empty($userRecipes)) {
                    echo "It's pretty empty here... Let's write some recipes!";
                } else { ?>
                    <?php foreach ($userRecipes as $userRecipe): ?>
                        <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                        <a href="<?php echo url_for('/member/edit_recipe.php?id=' . h(u($userRecipe->id))); ?>">Edit</a>
                        <a href="<?php echo url_for('/member/delete_recipe.php?id=' . h(u($userRecipe->id))); ?>">Delete</a>
                    <?php endforeach; ?>
                <?php } ?>

            </div>
        

        
            <div class="profileSectionHead">
                <h3>My Cookbook</h3>
                <a href="edit_cookbook.php" class="createLink" >Edit cookbook</a>
                <div class="profileCards"></div>
            </div>
        
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
