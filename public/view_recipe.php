<title>View Recipe | Culinnari</title>

<?php require_once('../private/initialize.php'); 
include(SHARED_PATH . '/public_header.php'); 
$id = $_GET['recipe_id'] ?? '1';
$recipe = Recipe::find_by_id($id);
$diet_icons = Recipe::get_diet_icons($recipe->id);
$meal_types = Recipe::get_meal_type_names($recipe->id);
$styles =  Recipe::get_style_names($recipe->id);
$recipeUser = Recipe::get_recipe_username($recipe->id);
$recipeImage = RecipeImage::find_image_by_recipe_id($recipe->id); 
$ingredients = Ingredient::find_by_recipe_id(($id));
$steps = Step::find_by_recipe_id(($id));
$recipe_video = RecipeVideo::find_by_recipe_id($id);


if(is_post_request()){
    if (isset($_POST['rating'])) {
        $args = $_POST['rating'];
        $user_id = $args['user_id']; // Current user ID
        $recipe_id = $args['recipe_id']; // Recipe ID
    
        // Check if a rating already exists for the current user and recipe
        $existingRating = Rating::find_by_user_and_recipe($user_id, $recipe_id);
    
        if ($existingRating) {
            // If a rating already exists, update it
            $existingRating->rating_value = $args['rating_value'];
            $result = $existingRating->save();
            
            if (!$result) {
                throw new Exception("Unable to update rating.");
                $_SESSION['message'] = 'Rating update failed. Please try again later.';
            } else
            {
                $_SESSION['message'] = 'Rating updated.';
            }
            
        } else {
            // If no rating exists, create a new one
            $rating = new Rating($args);
            $result = $rating->save();
            
            if (!$result) {
                throw new Exception("Unable to save rating.");
                $_SESSION["message"] = "Rating failed. Please try again later.";
            }
            $_SESSION['message'] = 'Rating added successfully.';
        }
    
        $database->commit();
        redirect_to(url_for('/view_recipe.php?recipe_id=' . $recipe->id));
    }

    if(isset($_POST['cookbook_recipe'])) {
        $args = $_POST['cookbook_recipe'];
        $recipe_id = $args['recipe_id'];
        

    }
}
    

    

?>
<script src="<?php echo url_for('/js/viewRecipe.js'); ?>" defer></script>
<main role="main" tabindex="-1">
    <div id="recipePageDisplayWrapper">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
        <div id="recipeDisplayUsernameOptions">
    <div id="recipeDisplayUsername">
        <p><img src="<?php echo url_for('/images/icon/profileicon.svg'); ?>" alt="Profile icon"> <?php echo h($recipeUser); ?></p>
    </div>
    <div id="recipeDisplayOptions">
        <div id="recipeDisplayPrint">
            <a href="javascript:void(0)" onclick="printRecipe();">
                <img src="<?php echo url_for('/images/icon/print.svg'); ?>" width="20" height="20" alt="Printer icon" title="Print recipe">
                Print
            </a>
        </div>
        
        
    </div>
</div>
        
        
        <div id="recipeNameImageDesc">   
            <?php 
            
            if ($recipeImage):  // Ensure an image exists before displaying
            ?>
            <img class="recipeImage" src="<?php echo url_for($recipeImage->recipe_image); ?>" width="400" height="400" alt="A photo of <?php echo h($recipe->recipe_name); ?>" title="A photo of <?php echo h($recipe->recipe_name); ?>">
            <?php endif; ?>
            
            <h2><?php echo h($recipe->recipe_name); ?></h2>
            <p id="recipeDisplayrecipeDescription"><?php echo h($recipe->recipe_description); ?></p>

            <div class="star-rating">
                <?php 
                $average_rating = Rating::get_average_rating($recipe->id);
                if ($average_rating != 0): ?>
                    <div>
                        <?php 
                        $full_stars = floor($average_rating);
                        $partial_star = $average_rating - $full_stars;
                        ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <svg viewBox="0 0 24 24" class="star" width="24" height="24">
                            <defs>
                                <clipPath id="star-clip-<?php echo $recipe->id . '-' . $i; ?>">
                                    <rect width="<?php echo ($i <= $full_stars) ? '100%' : (($i == $full_stars + 1) ? ($partial_star * 100) . '%' : '0%'); ?>" height="100%"></rect>
                                </clipPath>
                            </defs>
                            <!-- Empty Star Outline -->
                            <path d="M12 2L14.9 8.6L22 9.3L16.5 14L18 21L12 17.5L6 21L7.5 14L2 9.3L9.1 8.6L12 2Z" 
                                fill="none" stroke="gold" stroke-width="2"></path>
                            <!-- Filled Star (clipped) -->
                            <path d="M12 2L14.9 8.6L22 9.3L16.5 14L18 21L12 17.5L6 21L7.5 14L2 9.3L9.1 8.6L12 2Z" 
                                fill="gold" clip-path="url(#star-clip-<?php echo $recipe->id . '-' . $i; ?>)"></path>
                        </svg>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <span>No ratings yet</span>
                <?php endif; ?>
            </div>


            <div id="iconsStars">
                <div id="recipeDisplayDietIcons">
                    <?php if($diet_icons):?>
                        <?php foreach ($diet_icons as $diet_icon): ?>
                            <img src="<?php echo $diet_icon; ?>" alt="Diet icon" width="25" height="25">
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div id="recipeDisplayCategories">
                    <?php if($meal_types): ?>
                        <?php foreach ($meal_types as $meal_type): ?>
                            <span id="recipeDisplayMealTypes"><?php echo h($meal_type); ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if($styles): ?>
                        <?php foreach ($styles as $style): ?>
                            <span id="recipeDisplayStyles"><?php echo h($style); ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div id="recipeDisplayDifficulty">
                    <?php if($recipe->recipe_difficulty === 'beginner'){ ?>
                        <p id="recipeDisplayBeginner"><?php echo h($recipe->recipe_difficulty); ?></p>
                    <?php } elseif($recipe->recipe_difficulty === 'intermediate'){ ?>
                        <p id="recipeDisplayIntermediate"><?php echo h($recipe->recipe_difficulty); ?></p>
                    <?php } else{ ?>
                        <p id="recipeDisplayAdvanced"><?php echo h($recipe->recipe_difficulty); ?></p>
                    <?php } ; ?>      
                </div>

                
            </div>
            <div id="recipeDisplayprepCook">
                    <?php
                    // Convert prep time from seconds to hours and minutes
                    $prep_hours = floor($recipe->recipe_prep_time_seconds / 3600); // Get whole hours
                    $prep_minutes = floor(($recipe->recipe_prep_time_seconds % 3600) / 60); // Get remaining minutes
    
                    // Convert cook time from seconds to hours and minutes
                    $cook_hours = floor($recipe->recipe_cook_time_seconds / 3600); // Get whole hours
                    $cook_minutes = floor(($recipe->recipe_cook_time_seconds % 3600) / 60); // Get remaining minutes
                    ?>
    
                    <?php if ($prep_hours > 0 || $prep_minutes > 0): ?>
                        <p>Prep Time: 
                            <?php if ($prep_hours > 0): ?>
                                <?php echo h($prep_hours) . " hours "; ?>
                            <?php endif; ?>
                            <?php if ($prep_minutes > 0): ?>
                                <?php echo h($prep_minutes) . " minutes"; ?>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
    
                    <?php if ($cook_hours > 0 || $cook_minutes > 0): ?>
                        <p>Cook Time: 
                            <?php if ($cook_hours > 0): ?>
                                <?php echo h($cook_hours) . " hours "; ?>
                            <?php endif; ?>
                            <?php if ($cook_minutes > 0): ?>
                                <?php echo h($cook_minutes) . " minutes"; ?>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>
        </div>
        
        

        <div id="recipeDisplayIngredientsSteps">
            <div id="recipeDisplayIngredients">
                <h3>Ingredients</h3>
                <div id="recipeDisplayTotalServings">
                    <h4>Total Servings: <span id="servingAmt"><?php echo $recipe->recipe_total_servings; ?></span></h4>
                    <div id="recipeDisplayChangeServingAmt">
                        <button id="halfButton">1/2</button>
                        <button id="1timeButton">1x</button>
                        <button id="2timeButton">2x</button>
                        <button id="3timeButton">3x</button>
                    </div>
                </div>
                <div id="recipeDisplayIngredientList">
                    <ul>
                        <?php if(!empty($ingredients)): ?>
                            <?php foreach ($ingredients as $ingredient): ?>
                                <li class="recipeIngredientListing">
                                    <span class="recipeDisplayMeasurementAmount"><?php echo  decimal_to_fraction($ingredient->ingredient_quantity); ?></span> 
                                    <?php if (!empty($ingredient->ingredient_measurement_name) && $ingredient->ingredient_measurement_name !== 'n/a'): ?>
                                        <span><?php echo h($ingredient->ingredient_measurement_name); ?></span>
                                    <?php endif; ?>
                                    <?php echo h($ingredient->ingredient_name); ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div id="recipeDisplaySteps">
                <h3>Steps</h3>
                <ol>
                    <?php if(!empty($steps)): ?>
                        <?php foreach ($steps as $step): ?>
                            <li><?php echo h($step->step_description); ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>        
            </div>
        </div>
        
        <?php if($recipe_video): ?>
        <div id="recipeDisplayVideo">
            <h3>YouTube Video</h3>
            <div id="videoContainer">
                <iframe width="560" height="315" 
                    src="<?php echo h($recipe_video->recipe_video_url); ?>"  
                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if($session->is_logged_in()): ?>
        <div id="recipeDisplayMembersOptions">
        <section id="recipeDisplayAddToCookbook">
            <h3>Add to Cookbook</h3>
            <div class="cookbook-widget">
                <?php $cookbooks = Cookbook::find_by_user_id($session->user_id);?>
                <?php if ($cookbooks) { ?>
                    <form action="" method="post">
                        <input type="hidden" name="cookbook_recipe[recipe_id]" value="<?php echo h($recipe->id); ?>">
                        <?php foreach ($cookbooks as $cookbook): ?>
                            <label>
                                <input type="checkbox" name="cookbooks[]" value="<?php echo ($cookbook->id); ?>">
                                <?php echo h($cookbook->cookbook_name); ?>
                            </label><br>
                            <?php endforeach; ?>
                            <input type="submit" value="Add to cookbook">
                    </form>
                    <?php } else { ?>
                        <a href="<?php echo url_for('/member/profile.php?id=' . h($user->id)); ?>">Create a cookbook.</a>
                <?php } ?>
            </div>
        </section>
        <?php if($recipe->user_id != $session->user_id): ?>
            <section id="recipeDisplayAddRating">
            <h3>Rate this Recipe</h3>
            <p>Tried this recipe? Add your rating!</p>
            <div class="star-widget">
            <form action="" method="post">
                <input type="hidden" name="rating[recipe_id]" value="<?php echo h($recipe->id); ?>">
                <input type="hidden" name="rating[user_id]" value="<?php echo h($session->user_id); ?>">
                <div id="stars">
                    <input type="radio" name="rating[rating_value]" id="rate-5" value="5">
                    <label for="rate-5" class="fas fa-star"></label>
                
                    <input type="radio" name="rating[rating_value]" id="rate-4" value="4">
                    <label for="rate-4" class="fas fa-star"></label>

                    <input type="radio" name="rating[rating_value]" id="rate-3" value="3">
                    <label for="rate-3" class="fas fa-star"></label>

                    <input type="radio" name="rating[rating_value]" id="rate-2" value="2">
                    <label for="rate-2" class="fas fa-star"></label>

                    <input type="radio" name="rating[rating_value]" id="rate-1" value="1" required>
                    <label for="rate-1" class="fas fa-star"></label>
                </div>
                <div class="submitRatingbutton">
                    <button type="submit">Add Rating</button>
                </div>
            </form>                        
        </div>
        </section>
        <?php endif; ?>
        <?php endif; ?>
        
                                            
    </div>
            

        
       
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>