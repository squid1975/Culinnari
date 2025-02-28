<?php require_once('../../private/initialize.php'); ?>
<?php $pageTitle = "My Profile | Culinnari"; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

 <?php 
 require_login();
 $username = $session->username;
 $user = User::find_by_username($username);
 ?> 


<main id="userProfile" role="main" tabindex="-1">
    <div id="profileWrapper">
        <h2 id="profileHeading">My Culinnari Profile</h2>
        <h3>Hello, <?php echo h($user->username); ?>!</h3>
        <section>
            <div class="profileInfo">
                <h3>My Account</h3>
                     <p>Username : <?php  echo h($user->username); ?></p> 
                     <p>Full Name :  <?php  echo h($user->full_name()); ?> </p>
                     <p>Email Address :  <?php  echo h($user->user_email_address); ?></p>
                     <p>Joined :  <?php  echo h($user->user_create_account_date); ?> </p>
                     <p>User role: <?php echo h($user->user_role); ?></p>
            </div>
            <a href="<?php echo url_for('/logout.php'); ?>">Logout</a>
                    
            <div>
                 <?php if ($session->is_admin_logged_in() || $session->is_super_admin_logged_in()) {
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
        </section>
            
            <div class="profileSectionHead">
                <h3>My Recipes</h3>
                <a href="create_recipe.php" class="createLink">
                    Create recipe</a>
            </div>
            <div class="profileCards">
                
            </div>
        </section>

        <section>
            <div class="profileSectionHead">
                <h3>My Cookbook</h3>
                <a href="create_cookbook.php" class="createLink" >Create cookbook</a>
                <div class="profileCards">
                </div>
        </section>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
