<title>View Recipe | Culinnari</title>
<?php require_once('../private/initialize.php'); 
$id = $_GET['recipe_id'] ?? '1';
$recipe = Recipe::find_by_id($id);
$diet_icons = Recipe::get_diet_icons($recipe->id);
$ingredients = Ingredient::find_by_recipe_id(($id));
$steps = Step::find_by_recipe_id(($id));
$video = RecipeVideo::find_by_recipe_id($id);
include(SHARED_PATH . '/public_header.php'); 

if(is_post_request()){
    if(isset($_POST['rating'])){
        $ratingUserId = $_POST['rating_user_id'] ?? $session->user_id;
        $ratingRecipeId = $_POST['rating_recipe_id'] ?? $id;
        $ratingValue = $_POST['rating_value'] ?? 1;

        
        if(empty($errors)) {
                $args = $_POST['rating'];
                $args += ["user_id" => $ratingUserId];
                $args += ['recipe_id' => $ratingRecipeId];
                $args += ['rating_value' => $ratingValue];
                $rating = new Rating($args);
                $result = $rating->save();

                if(!result) {
                    throw new Exception(message: "Unable to save rating.");
                }
                $database->commit();

            }
        }
    }

    if(isset($_POST['cookbook_recipe'])){
        
    }


?>


<main role="main" tabindex="-1">
    <div id="recipePageDisplayWrapper">
        <div id="recipeNameImageDesc">   
        <?php 
            $recipeImage = RecipeImage::find_image_by_recipe_id($recipe->id); 
            if ($recipeImage):  // Ensure an image exists before displaying
        ?>
            <img class="recipeImage" src="<?php echo url_for($recipeImage->recipe_image); ?>" width="300" height="300" alt="recipe" title="recipe">
        <?php endif; ?>
            
            <h2><?php echo h($recipe->recipe_name); ?></h2>
            <p id="recipeDisplayrecipeDescription"><?php echo h($recipe->recipe_description); ?></p>
            
            <div id="iconsStars">
                <div id="recipeDisplayDietIcons">
                    <?php if($diet_icons):?>
                        <?php foreach ($diet_icons as $diet_icon): ?>
                            <img src="<?php echo $diet_icon; ?>" alt="Diet Icon">
                        <?php endforeach; ?>
                    <?php endif; ?>
            </div>
                
                <div id="recipeDisplayRatingStars">
                    <span>Unrated</span>

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
            <div id="recipeDisplayOptions">
                <div>
                    <a href="about:blank" onclick="window.print(); return false;">
                        <img src="<?php echo url_for('/images/icon/print.svg'); ?>" width="24" height="24" alt="Printer icon" title="Print recipe">
                        Print Recipe
                    </a>
                </div>
                <?php if($session->is_logged_in()): ?>
                    <div id="cookbook-icon">
                        <form action="" method="post">
                            <input type="hidden" name="cookbookrecipe[recipe_id]" value="<?php echo h($recipe->id); ?>">
                            <button type="submit">
                                <img src="<?php echo url_for('/images/icon/addToCookbook.svg'); ?>" width="24" height="24" alt="Cookbook icon" title="Add to cookbook">
                                Add to Cookbook
                            </button>
                        </form>
                    </div>

                    <div class="rating-container">
                        
                            <img src="<?php echo url_for('/images/icon/star.svg'); ?>" width="24" height="24" alt="Star icon" title="Add rating">
                            Rate this recipe
                        </label>
                        <div class="container">
                            <form action="" method="post">
                            <div class="star-widget">
                                <input type="radio" name="rating[rating_value]" id="rate-5" value="5">
                                <label for="rate-5"></label>
                                <input type="radio" name="rating[rating_value]" id="rate-4" value="4">
                                <label for="rate-4"></label>
                                <input type="radio" name="rating[rating_value]" id="rate-3" value="3">
                                <label for="rate-3"></label>
                                <input type="radio" name="rating[rating_value]" id="rate-2" value="2">
                                <label for="rate-2"></label>
                                <input type="radio" name="rating[rating_value]" id="rate-1" value="1">
                                <label for="rate-1"></label>
                            </div>
                        </div>
                        <input type="submit" value="Add rating">
                        </form>
                        </div>
                    </div>
                <?php endif; ?>
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
                    <h4>Total Servings: <span id="servingAmt"><?php echo h($recipe->recipe_total_servings); ?></span></h4>
                    <div id="recipeDisplayChangeServingAmt">
                        <button id="halfButton">1/2</button>
                        <button id="1time">1x</button>
                        <button id="2time">2x</button>
                        <button id="3time">3x</button>
                    </div>
                </div>
                <div id="recipeDisplayIngredientList">
                    <ul>
                        <?php if(!empty($ingredients)): ?>
                            <?php foreach ($ingredients as $ingredient): ?>
                                <li class="recipeIngredientListing">
                                    <span id="recipeDisplayMeasurementAmount"><?php echo h(decimal_to_fraction($ingredient->ingredient_quantity)); ?></span> 
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

        <?php if(!empty($video)): ?>
        <div id="recipeDisplayYouTubeVideo">
            <h3>Watch YouTube Video</h3>
            <iframe width="420" height="315"
                src="https://www.youtube.com/embed/<?php echo h($video->video_url); ?>">
            </iframe>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include(SHARED_PATH . '/public_footer.php'); ?>