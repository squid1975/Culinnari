<title>My Profile | Culinnari</title>
<?php require_once('../../private/initialize.php'); ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<script src="<?php echo url_for('js/script.js'); ?>" defer></script>

<?php 
 require_login();
 $username = $session->username;
 $user = User::find_by_username($username);
 $current_user_id = $session->user_id;
 $cookbook = Cookbook::find_by_id($session->user_id);
 
 if(is_post_request()){

    if(isset($_POST['cookbook'])){
    $args = $_POST['cookbook'];
    $args += ["user_id" => $current_user_id];
    $cookbook = new Cookbook($args);
    $result = $cookbook->save();
    if($result){
        redirect_to(url_for('/member/profile.php'));
    }
    }
 }
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
                <?php  $userRecipes = Recipe::getUserRecipes($session->user_id); 
                if (empty($userRecipes)) { ?>
                    <p>It's pretty empty here..Let's write some recipes!</p>
                    <?php } else { ?>
                        <?php foreach ($userRecipes as $recipe): ?>
                            <div class="profileRecipeCard">
                        <?php include(SHARED_PATH . '/recipe_card.php'); ?>

                        <div id="userProfileRecipeActions">
                        <div id="profileEditRecipe">
                            <a href="<?php echo url_for('/member/edit_recipe.php?recipe_id=' . $recipe->id); ?>">Edit</a>
                        </div>
                           <div id="profileDeleteRecipe" onclick="showDeleteForm()">Delete
                                <div id="deleteRecipeForm">
                                    <p>Are you sure you want to delete this recipe?<strong>This cannot be undone.</strong></p>
                                    <form action="<?php echo url_for('/delete_recipe.php'); ?>" method="POST">
                                        <input type="hidden" name="recipe['id']" value="<?php echo $recipe->id; ?>">
                                        <button type="submit" name="delete" value="Delete Recipe">Delete Recipe</button>
                                    </form>
                                    <button type="button" onclick="hideDeleteForm()">x Cancel</button>
                                </div>
                           </div>
                           
                        </div>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>
                
            </div>  
            <div class="profileSectionHead">
                <?php if(empty($cookbook)){ ?>
                    <div id="profileCreateCookbook">
                        <h3>Create your first cookbook!</h3>
                        <p>Enter a name for your cookbook. Click 'create' and start saving recipes!</p>
                        <form action="profile.php" method="POST">
                            <div id="cookbookNameFormField">
                                <label>Cookbook Name:</label>
                                <input type="text" id="cookbookName" name="cookbook['cookbook_name']" required>
                                <input type="submit" class="primarybtn" value="Create">
                        </form>
                            </div>
                    </div>
                    <?php } else { ?>
                        <img src="<?php echo url_for('/images/icon/cookbook.svg'); ?>" width="22" height="22" alt="A cookbook notebook icon" title="Culinnari Cookbook">
                        <h3><?php echo $cookbook->cookbook_name ;?></h3>
                        <?php $cookbookRecipes = CookbookRecipe::find_by_id($cookbook->id); ?>
                        <?php if(!empty($cookbookRecipes)) { ?>
                            <?php foreach ($cookbookRecipes as $recipe): ?>
                                <div class="profileRecipeCard">
                                <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                            <?php endforeach; ?>
                    <?php } else { ?>
                        <p>Ready to add some recipes? <a href="<?php echo url_for('/recipes.php'); ?>">Search for recipes</a></p>
                    <?php } ?>
                    <?php } ?>
            </div>
        
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
