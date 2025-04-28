<?php require_once('../private/initialize.php');
$id = $_GET['recipe_id'] ?? '1';
if(!isset($id)){
    error_404();
}
$recipe = Recipe::find_by_id($id);
if ($recipe == false) {
    error_404();
}
$title = 'View Recipe  | Culinnari';
include(SHARED_PATH . '/public_header.php');
$id = $_GET['recipe_id'] ?? '1';
$recipe = Recipe::find_by_id($id);
$meal_types = Recipe::get_meal_type_names($recipe->id);
$styles = Recipe::get_style_names($recipe->id);
$recipeUser = Recipe::get_recipe_username($recipe->id);
$recipeImage = RecipeImage::find_image_by_recipe_id($recipe->id);
$ingredients = Ingredient::find_by_recipe_id(($id));
$steps = Step::find_by_recipe_id(($id));
$recipe_video = RecipeVideo::find_by_recipe_id($id);

if($session->is_logged_in()) {
    $username = $session->username;
    $user = User::find_by_username($username);
    $current_user_id = $user->id;
    $cookbooks = Cookbook::find_by_user_id($user->id);
    $recipe_id = $recipe->id;
    
    // Check if recipe is in each cookbook
    foreach ($cookbooks as $cookbook) {
        $cookbook->already_contains_recipe = CookbookRecipe::recipe_exists_in_cookbook($cookbook->id, $recipe_id);
    }
}
if (is_post_request()) {
    if (isset($_POST['rating'])) {
        $args = $_POST['rating'];
        $user_id = $args['user_id']; // Current user ID
        $recipe_id = $args['recipe_id']; // Recipe ID
        $existingRating = Rating::find_by_user_and_recipe($user_id, $recipe_id);
        // Check if a rating already exists for the current user and recipe
        if ($existingRating) {
            // If a rating already exists, update it
            $existingRating->rating_value = $args['rating_value'];
            $result = $existingRating->save();

            if (!$result) {
                $_SESSION['message'] = 'Rating update failed. Please try again later.';
                throw new Exception("Unable to update rating.");
            } else {
                $_SESSION['message'] = 'Rating updated.';
            }

        } else {
            // If no rating exists, create a new one
            $rating = new Rating($args);
            $result = $rating->save();

            if (!$result) {
                $_SESSION["message"] = "Rating failed. Please try again later.";
                throw new Exception("Unable to save rating.");
            }
            $_SESSION['message'] = 'Rating added successfully.';
        }
        redirect_to(url_for('/view_recipe.php?recipe_id=' . $recipe->id));
    }

    if (isset($_POST['cookbook_recipe'])) {
        $args = $_POST['cookbook_recipe'];
        $recipe_id = $args['recipe_id'];
        $cookbook_ids = $_POST['cookbooks'] ?? [];
        foreach ($cookbook_ids as $cookbook_id) {
            $cookbook_recipe = new CookbookRecipe([
                'cookbook_id' => $cookbook_id,
                'recipe_id' => $recipe_id
            ]);
            $result = $cookbook_recipe->save();
            if (!$result) {
                $_SESSION['message'] = 'Recipe save failed. Please try again later.';

            } else {
                $_SESSION['message'] = 'Recipe added to cookbook.';
            }

        }
        redirect_to(url_for('/view_recipe.php?recipe_id=' . $recipe->id));
    }
}

?>

<main role="main" tabindex="-1">
    <div id="recipePageDisplayWrapper">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="session-message">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); // Clear message after displaying ?>
        <?php endif; ?>
        <div id="recipeDisplayUsernameOptions">
            <div id="recipeDisplayUsername">
                <p><img src="<?php echo url_for('/images/icon/profileicon.svg'); ?>" alt="Profile icon">
                    <?php echo h($recipeUser); ?></p>
            </div>

        </div>

        <section>
            <div id="recipeNameImageDesc">
                <?php if ($recipeImage) {  // If the recipe image exists, display it, else fallback to default image ?>
                <img class="recipeImage" src="<?php echo url_for($recipeImage->recipe_image); ?>" width="400" height="400" alt="A photo of <?php echo h($recipe->recipe_name); ?>">
                <?php } else { ?>
                <img class="recipeImage" src="<?php echo url_for('/images/default_recipe_image.webp'); ?>" width="400" height="400" alt="Recipe image not found, displaying default recipe image">
                <?php } ?>
                <h2><?php echo h($recipe->recipe_name); ?></h2>
                <p id="recipeDisplayrecipeDescription"><?php echo h($recipe->recipe_description); ?></p>

                <div class="starRating">
                    <?php
                    // Fetch the average rating for the recipe
                    $average_rating = Rating::get_average_rating($recipe->id);
                    if ($average_rating != 0): ?>
                        <div class="starsRatingValue">
                            <?php
                            $full_stars = floor($average_rating);
                            $partial_star = $average_rating - $full_stars;
                            $totalRatings = Rating::count_ratings($recipe->id);
                            ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <svg viewBox="0 0 24 24" class="star" width="24" height="24">
                                    <defs>
                                        <clipPath id="star-clip-<?php echo $recipe->id . '-' . $i; ?>">
                                            <rect
                                                width="<?php echo ($i <= $full_stars) ? '100%' : (($i == $full_stars + 1) ? ($partial_star * 100) . '%' : '0%'); ?>"
                                                height="100%"></rect>
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
                            <span id="totalRatings">(<?php echo h($totalRatings); ?>)</span>
                        </div>
                    <?php else: ?>
                        <span>No ratings yet</span>
                    <?php endif; ?>
                </div>


                <div id="recipeDisplayDietIconsCategoriesDifficulty">
                    <div id="recipeDisplayDietIcons">
                        <?php $diet_icons = Recipe::get_diet_icons($recipe->id); ?>
                        <?php $diet_icon_names = Recipe::get_diet_names($recipe->id); // Get diet icon names ?>
                        <?php if($diet_icons && $diet_icon_names): ?>
                            <?php foreach ($diet_icons as $index => $diet_icon): ?>
                                <img src="<?php echo url_for($diet_icon); ?>" 
                                    alt="<?php echo h($diet_icon_names[$index]) . ' diet icon for ' . $recipe->recipe_name; ?>" 
                
                                    width="20" height="20">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div id="recipeDisplayCategories">
                        <?php if ($meal_types): ?>
                            <?php foreach ($meal_types as $meal_type): ?>
                                <span class="recipeDisplayMealTypes"><?php echo h($meal_type); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($styles): ?>
                            <?php foreach ($styles as $style): ?>
                                <span class="recipeDisplayStyles"><?php echo h($style); ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div id="recipeDisplayDifficulty">
                        <?php if ($recipe->recipe_difficulty === 'beginner') { ?>
                            <p id="recipeDisplayBeginner"><?php echo h($recipe->recipe_difficulty); ?></p>
                        <?php } elseif ($recipe->recipe_difficulty === 'intermediate') { ?>
                            <p id="recipeDisplayIntermediate"><?php echo h($recipe->recipe_difficulty); ?></p>
                        <?php } else { ?>
                            <p id="recipeDisplayAdvanced"><?php echo h($recipe->recipe_difficulty); ?></p>
                        <?php }
                        ; ?>
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

                <div id="recipeDisplayOptions">
                    <div id="recipeDisplayPrint">
                        <a href="javascript:void(0)" onclick="printRecipe();">
                            <img src="<?php echo url_for('/images/icon/print.svg'); ?>" width="20" height="20"
                                alt="Printer icon" title="Print recipe">
                            Print
                        </a>
                    </div>
                    <?php if ($session->is_logged_in()): ?>
                        <div id="recipeDisplayAddToCookbook">
                            <button id="addToCookbookButton">
                                <img src=<?php echo url_for('/images/icon/addToCookbook.svg'); ?> width="20" height="20"
                                    alt="Add to cookbook plus icon">Save
                            </button>
                            <div class="modal" id="addToCookbookModal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h3>Save to Cookbook</h3>
                                    <?php if ($cookbooks){ ?>
                                    <form action="<?php echo url_for('view_recipe.php?recipe_id=' . h(u($recipe->id))); ?>" method="post">
                                        <input type="hidden" name="cookbook_recipe[recipe_id]" value="<?php echo h($recipe->id); ?>">
                                        <?php foreach ($cookbooks as $cookbook): ?>
                                        <label for="cookbook_<?php echo h($cookbook->id); ?>">
                                            <?php if ($cookbook->already_contains_recipe): ?>
                                                <input type="checkbox" name="cookbooks[]" id="cookbook_<?php echo h($cookbook->id); ?>" value="<?php echo ($cookbook->id); ?>" disabled> 
                                                <?php echo h($cookbook->cookbook_name); ?> <span class="recipe-saved">(Already saved)</span>
                                            <?php else: ?>
                                                <input type="checkbox" name="cookbooks[]" id="cookbook_<?php echo h($cookbook->id); ?>" value="<?php echo ($cookbook->id); ?>"> 
                                                <?php echo h($cookbook->cookbook_name); ?>
                                            <?php endif; ?>
                                        </label>
                                        <?php endforeach; ?>
                                        <input type="submit" value="Save to Cookbook" class="createUpdateButton">
                                    </form>
                                <?php } else { ?>
                                    <p>You don't have any cookbooks yet! Create one to save this recipe.</p>
                                    <a href="<?php echo url_for('/member/profile.php?id=' . $user->id); ?>" class="createUpdateButton">Create a Cookbook</a>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($recipe->user_id != $user->id): ?>
                            <div id="recipeDisplayRateStar">
                                <a href="#recipeDisplayAddRating">
                                    <img src="<?php echo url_for('/images/icon/star.svg'); ?>" width="20" height="20"
                                        alt="Star rating icon">
                                    Rate
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div id="recipeDisplayIngredientsSteps">
            <section>
                <div id="recipeDisplayIngredients">
                    <h3>Ingredients</h3>
                    <div id="recipeDisplayTotalServings">
                        <h4>Total Servings: <span id="servingAmt"><?php echo $recipe->recipe_total_servings; ?></span>
                        </h4>
                        <div id="recipeDisplayChangeServingAmt">
                            <button id="halfButton">1/2</button>
                            <button id="1timeButton">1x</button>
                            <button id="2timeButton">2x</button>
                            <button id="3timeButton">3x</button>
                        </div>
                    </div>
                    <div id="recipeDisplayIngredientList">
                        <ul>
                        <?php if (!empty($ingredients)): ?>
                            <?php foreach ($ingredients as $ingredient): ?>
                                <li class="recipeIngredientListing">
                                <span class="recipeDisplayMeasurementAmount"><?php echo decimal_to_fraction($ingredient->ingredient_quantity); ?></span>
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
            </section>
                        
            <section>
            <div id="recipeDisplaySteps">
                <h3>Steps</h3>
                <ol>
                    <?php if (!empty($steps)): ?>
                    <?php foreach ($steps as $step): ?>
                    <li><?php echo h($step->step_description); ?></li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            </div>
            </section>
        </div>
                
        <?php if ($recipe_video): ?>
            <section>
            <div id="recipeDisplayVideo">
            <h3>YouTube Video</h3>
                    <div id="videoContainer">
                        <iframe width="560" height="315" src="<?php echo h($recipe_video->recipe_video_url); ?>"
                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($session->is_logged_in() && ($recipe->user_id != $user->id)): ?>
            <section id="recipeDisplayAddRating">
                <h3>Add Rating</h3>
                <?php $ratingExists = Rating::find_by_user_and_recipe($user->id, $recipe->id); ?>
                <?php if ($ratingExists){ ?>
                    <p>You rated this recipe <?php echo h(number_format($ratingExists->rating_value, 0)); ?> stars on <?php echo formatDate($ratingExists->rating_date); ?>.</p>
                <?php } else { ?>
                <p>Tried this recipe? Add your rating!</p>
                <?php } ?>
                <div class="starWidget">
                    <form action="<?php echo url_for('view_recipe.php?recipe_id=' . h(u($recipe->id))); ?>" method="post">
                        <input type="hidden" name="rating[recipe_id]" value="<?php echo h($recipe->id); ?>">
                        <input type="hidden" name="rating[user_id]" value="<?php echo h($session->user_id); ?>">
                        <fieldset>
                            <legend class="visuallyHidden">Rate This Recipe</legend>
                            <div id="stars">
                                <input type="radio" name="rating[rating_value]" id="rate-5" value="5">
                                <label for="rate-5" class="fas fa-star"><span class="visuallyHidden">5</span></label>

                                <input type="radio" name="rating[rating_value]" id="rate-4" value="4">
                                <label for="rate-4" class="fas fa-star"><span class="visuallyHidden">4</span></label>

                                <input type="radio" name="rating[rating_value]" id="rate-3" value="3">
                                <label for="rate-3" class="fas fa-star"><span class="visuallyHidden">3</span></label>

                                <input type="radio" name="rating[rating_value]" id="rate-2" value="2">
                                <label for="rate-2" class="fas fa-star"><span class="visuallyHidden">2</span></label>

                                <input type="radio" name="rating[rating_value]" id="rate-1" value="1" required>
                                <label for="rate-1" class="fas fa-star"><span class="visuallyHidden">1</span></label>
                            </div>
                        </fieldset>

                        <div class="submitRatingbutton">
                            <?php if ($ratingExists): ?>
                                <button type="submit" class="submitRatingButton">Update Rating</button>
                            <?php else: ?>
                            <button type="submit" class="submitRatingButton">Add Rating</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    </div>
</main>
<script src="<?php echo url_for('/js/viewRecipe.js'); ?>" defer></script>
<?php include(SHARED_PATH . '/public_footer.php'); ?>