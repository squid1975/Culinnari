<?php require_once('../../private/initialize.php'); 
$title = 'My Profile | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_login();
 
 $username = $session->username;
 $user = User::find_by_username($username);
 $current_user_id = $session->user_id;
 $cookbook = Cookbook::find_by_user_id($session->user_id);
 $userRecipes = Recipe::get_user_recipes($session->user_id); 
 
 if(is_post_request()){

    if(isset($_POST['cookbook'])){
    $args = $_POST['cookbook'];
    $args += ["user_id" => $current_user_id];
    $cookbook = new Cookbook($args);
    $result = $cookbook->save();
    if($result){
        redirect_to(url_for('/member/profile.php?id=' . h($user->id)));
    }
    }
 }
 ?> 

<script src="<?php echo url_for('js/profile.js'); ?>" defer></script>
<main id="userProfile" role="main" tabindex="-1">
    <div id="profileWrapper">
        <h2 id="profileHeading">My Culinnari Profile</h2>
        <h3>Hello, <?php echo h($user->username);  ?>!</h3>
        <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
            <div class="profileInfo">
                <h3>My Account</h3>
                     <p>Full Name :  <?php  echo h($user->full_name()); ?> </p>
                     <p>Email Address :  <?php  echo h($user->user_email_address); ?></p>
                     <p>Joined :  <?php  echo formatDate(h($user->user_create_account_date)); ?> </p>
            </div>        
            <div class="profileSectionHead">
                <h3>My Recipes (<?php echo count($userRecipes); ?>)</h3>
                <a href="create_recipe.php" class="createLink">
                    Create recipe</a>
            </div>
            <div class="profileCards">
                <?php  
                if (empty($userRecipes)) { ?>
                    <p>It's pretty empty here..Let's write some recipes!</p>
                    <?php } else { ?>
                        <?php foreach ($userRecipes as $recipe): ?>
                            <div class="profileRecipeCard">
                            <?php include(SHARED_PATH . '/recipe_card.php'); ?>

                            <div class="userProfileRecipeActions">
                                <div class="profileEditRecipe">
                                    <a href="<?php echo url_for('/member/edit_recipe.php?recipe_id=' . $recipe->id); ?>">Edit</a>
                                </div>
                                <div class="profileDeleteRecipe">
                                    <button class="deleteRecipeButton">Delete</button>
                                        <div class="modal" id="deleteRecipeModal<?php echo $recipe->id; ?>">
                                            <div class="modal-content">
                                                <span class="close">&times;</span>
                                                <h2>Delete Recipe</h2>
                                                <p>Are you sure you want to delete <?php echo h($recipe->recipe_name);?>?</p>
                                                <strong>Note: This action cannot be undone.</strong>
                                                <form action="<?php echo url_for('/member/delete_recipe.php?recipe_id=' . $recipe->id); ?>" method="POST">
                                                    <input type="hidden" name="recipe['id']" value="<?php echo $recipe->id; ?>">
                                                    <input type="submit" name="delete" value="Delete Recipe" class="deleteButton">
                                                </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>
            </div>
            <div class="profileSectionHead">
                <?php if(empty($cookbook)){ ?>
                    <h3>Create your first cookbook!</h3>
                    <button id="createCookbookButton">Create Cookbook</button>
                    <div class="modal" id="createCookbookModal">
                        <div class="modal-content">
                            <h4>Create a new cookbook</h4>
                            <span class="close">&times;</span>
                                <form action="<?php echo url_for('/member/profile.php?id=' . $user->id);?>" method="post" id="createCookbookForm">
                                    <div class="formField">
                                <input type="hidden" name="cookbook[user_id]" value="<?php echo ($session->user_id); ?>">
                                <label for="cookbookName">Cookbook Name:
                                    <input type="text" id="cookbookName" name="cookbook[cookbook_name]" pattern="^[A-Za-z \-']+$" required>
                                </label>
                                </div>
                                <input type="submit" value="Create cookbook" class="createUpdateButton">
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <img src="<?php echo url_for('/images/icon/cookbook.svg'); ?>" alt="Cookbook Icon" width="30" height="30">
                    <h3><?php echo $cookbook[0]->cookbook_name; ?></h3>
            </div>
            <div class="profileCards">
                <?php  $cookbookRecipes = CookbookRecipe::get_cookbook_recipes_by_cookbook_id($cookbook[0]->id);
                        foreach ($cookbookRecipes as $recipe): ?>
                           <?php $recipe = Recipe::find_by_id($recipe->recipe_id); ?>
                           <div class="profileRecipeCard">
                               <?php include(SHARED_PATH . '/recipe_card.php'); ?>
                            </div>
                        <?php endforeach; ?>
                        <?php } ?>
                </div>

    </div>    
            
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
