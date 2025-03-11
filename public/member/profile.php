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
                     <p>Joined :  <?php  echo formatDate(h($user->user_create_account_date)); ?> </p>
            </div>        
                   
        
            
            <div class="profileSectionHead">
                <h3>My Recipes</h3>
                <a href="create_recipe.php" class="createLink">
                    Create recipe</a>
            </div>
            <div class="profileCards">
                <?php 
                $userRecipes = Recipe::getUserRecipes($session->user_id);
                
                if (empty($userRecipes)) { ?>
                    <p>It's pretty empty here..Let's write some recipes!</p>
                    <?php } else { ?>
                        <?php foreach ($userRecipes as $recipe): ?>
                            <div class="profileRecipeCard">
                        <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                        <div id="userProfileRecipeActions">
                           
                        </div>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>
                
            </div>
        

        
            <div class="profileSectionHead">
                <img src="<?php echo url_for('/images/icon/cookbook.svg'); ?>" width="22" height="22" alt="A cookbook notebook icon" title="Culinnari Cookbook">
                <h3>My Cookbook</h3>
                
                
            </div>
        
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
