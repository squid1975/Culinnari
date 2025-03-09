<?php require_once('../private/initialize.php'); 
$id = $_GET['recipe_id'] ?? '1';
$recipe = Recipe::find_by_id($id);
$pageTitle = "Recipe: " . h($recipe->recipe_name) . " | Culinnari"; 

$ingredients = Ingredient::find_by_recipe_id(($id));
$steps = Step::find_by_recipe_id(($id));


$video = RecipeVideo::find_by_recipe_id($id);
include(SHARED_PATH . '/public_header.php'); 


?>


<main role="main" tabindex="-1">
    <div id="recipePageDisplayWrapper">
        <div id="recipeNameImageDesc">
            
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <img src="<?php echo $image->recipe_image_url; ?>" width="300" height="300" 
                        alt="<?php echo 'Photo for ' . h($recipe->recipe_name); ?>">
                <?php endforeach; ?>
            <?php else: ?>
                <img src="<?php echo url_for('/images/default_recipe_image.webp'); ?>" width="300" height="300" 
                    alt="Default recipe image">
            <?php endif; ?>
            
            <h2><?php echo h($recipe->recipe_name); ?></h2>
            <p id="recipeDisplayrecipeDescription"><?php echo h($recipe->recipe_description); ?></p>
            
            <div id="iconsStars">
                <div id="recipeDisplayDietIcons">
                    <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">
                    <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">  
                    <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">  
                    <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">  
                    <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">  
                    <img src="<?php echo url_for('/images/icon/dietIcons/vegetarian.svg'); ?>" width="20" height="20" alt="diet icon">   
                </div>
                
                <div id="recipeDisplayRatingStars">
                <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
                <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
                <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
                <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
                <svg width="20" height="20" viewBox="0 0 24 24" stroke="black" fill="yellow"><polygon points="12,2 15,9 22,9 17,14 18,21 12,17 6,21 7,14 2,9 9,9" /></svg>
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
                <div>
                        <img src="<?php echo url_for('/images/icon/addToCookbook.svg'); ?>" width="24" height="24" alt="Cookbook icon" title="Add to cookbook">
                        Add to Cookbook
                </div>
                <div>
                    <img src="<?php echo url_for('/images/icon/star.svg'); ?>" width="24" height="24" alt="Star icon" title="Add rating">
                    Add Rating
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