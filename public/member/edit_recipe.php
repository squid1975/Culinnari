<?php 
require_once('../../private/initialize.php'); 
$title = 'Edit Recipe | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_login();
$recipe_id = $_GET['recipe_id'] ?? null; // Get the recipe ID from the URL
$recipe = Recipe::find_by_id($recipe_id);
if(!$recipe || $recipe->user_id != $_SESSION['user_id']) {
    redirect_to(url_for('/member/profile.php?id=' . $_SESSION['user_id']));
    $_SESSION['message'] = "You do not have permission to access this resource.";
    exit;
}
$errors = [];   
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all();
$selectedMealTypes = RecipeMealType::find_by_recipe_id($recipe_id);
$selectedMealTypeIds = array_map(function($item) {
    return (int)$item->meal_type_id; // Cast to integer for consistency
}, $selectedMealTypes);
$selectedStyles = RecipeStyle::find_by_recipe_id($recipe_id);
$selectedStyleIds = array_map(function($item) {
    return (int)$item->style_id; // Cast to integer for consistency
}, $selectedStyles);
$selectedDiets = RecipeDiet::find_by_recipe_id($recipe_id);
$selectedDietIds = array_map(function($item) {
    return (int)$item->diet_id; // Cast to integer for consistency
}, $selectedDiets);
$ingredients = Ingredient::find_by_recipe_id($recipe_id);
$steps = Step::find_by_recipe_id($recipe_id);
$recipe_images = RecipeImage::find_by_recipe_id($recipe_id);
$existingImage = !empty($recipe_images) ? $recipe_images[0]->recipe_image : null;
$defaultImage = url_for('/images/default_recipe_image.webp'); 
$recipe_video = RecipeVideo::find_by_recipe_id($recipe_id);

if(is_post_request()) {
    $_SESSION['message'] = "Recipe update functionality is not available yet.";
    redirect_to(url_for('/member/profile.php?id=' . $_SESSION['user_id']));
}
?>

<script src="<?php echo url_for('/js/createRecipe.js'); ?>" defer></script>
<main role="main" tabindex="-1">

    <div class="recipeFormWrapper">
    
        <div class="recipeFormHeading">
            <h2>Edit Recipe</h2>
            <p>Fields marked with * required.</p>
            <?php echo display_errors($errors); ?>
        </div>
        <form action="<?php echo url_for('/member/edit_recipe.php?recipe_id =' . $recipe_id);?>" method="POST" enctype="multipart/form-data" class="recipeForm">
            <input type="hidden" name="recipe[id]" value="<?php echo h($recipe->id); ?>">

            <label for="recipeName" class="recipePartName">Recipe Name:*</label>
            <input type="text" id="recipeName" name="recipe[recipe_name]" maxlength="100" required value="<?php echo h($recipe->recipe_name); ?>">

            <label for="recipeDescription" class="recipePartName">Description:*</label>
            <span>Description must be no more than 255 characters.</span>
            <textarea id="recipeDescription" name="recipe[recipe_description]" maxlength="255" rows="4" cols="50" required><?php echo $recipe->recipe_description; ?></textarea>

            <fieldset>
                <legend>Difficulty</legend>
                <div class="radio-group">
                    <div class="formField">
                        <input type="radio" id="beginner" name="recipe[recipe_difficulty]" value="beginner" <?php if($recipe->recipe_difficulty == 'beginner') echo 'checked'; ?>>
                        <label for="beginner">Beginner</label>
                    </div>

                    <div class="formField">
                        <input type="radio" id="intermediate" name="recipe[recipe_difficulty]" value="intermediate" <?php if($recipe->recipe_difficulty == 'intermediate') echo 'checked'; ?>>
                        <label for="intermediate">Intermediate</label>
                    </div>

                    <div class="formField">
                        <input type="radio" id="advanced" name="recipe[recipe_difficulty]" value="advanced" <?php if($recipe->recipe_difficulty == 'advanced') echo 'checked'; ?>>
                        <label for="advanced">Advanced</label>
                    </div>
                </div>
            </fieldset>
            <div id="timeInput">
            <?php if (!empty($errors['time'])): ?>
                <p class="error-message"><?php echo $errors['time']; ?></p>
                <?php endif; ?>
                    <fieldset>
                        <legend>Prep Time</legend>
                        <div class="timeContainer">
                            <label for="prepTimeHours">Hours:
                                <input type="number" id="prepTimeHours" name="prep_hours" min="0" max="99" step="1" placeholder="Hrs" value="<?php echo floor($recipe->recipe_prep_time_seconds / 3600); ?>"></label>
                            <label for="prepTimeMinutes">Minutes:
                                <input type="number" id="prepTimeMinutes" name="prep_minutes" min="0" max="59" step="1" placeholder="Min" value="<?php echo ($recipe->recipe_prep_time_seconds % 3600) / 60; ?>"></label>
                        </div>
                    </fieldset>

                
                    <fieldset>
                        <legend>Cook Time</legend>
                        <div class="timeContainer">
                            <label for="cookTimeHours">Hours:
                                <input type="number" id="cookTimeHours" name="cook_hours" min="0" max="99" step="1" placeholder="Hrs" value="<?php echo floor($recipe->recipe_cook_time_seconds / 3600); ?>"></label>
                            
                            <label for="cookTimeMinutes">Minutes:<input type="number" id="cookTimeMinutes" name="cook_minutes" min="0" max="59" step="1" placeholder="Min" value="<?php echo ($recipe->recipe_cook_time_seconds % 3600) / 60; ?>"></label>
                        </div>
                    </fieldset>    
            </div>

            <div id="totalServingsContainer">
                <label for="totalServings" class="recipePartName">Total Servings:*</label>
                <input type="number" id="totalServings" name="recipe[recipe_total_servings]" min="1" max="99" step="1" required value="<?php echo ($recipe->recipe_total_servings); ?>">
            </div>

            <fieldset id="ingredients">
                <legend>Ingredients:*</legend>
                <span id="ingredientDirections">Type the measurement amount and select a unit if applicable. Type the ingredient name with any special instructions in parentheses. Click 'plus' to add.</span>
                <?php if (!empty($errors['ingredients'])): ?>
                <p class="error-message"><?php echo $errors['ingredients']; ?></p>
                <?php endif; ?>
                <div id="ingredientInputs">
                    <label for="measurementAmount">Amount:*
                        <input type="text" id="measurementAmount" placeholder="1,1/2,1 1/2" pattern="^\d{1,2}(\s\d{1,2}\/\d{1,2})?$|^\d{1,2}\/\d{1,2}$" maxlength="6"></label>
                        <label for="ingredientUnit">Unit:
                            <select id="ingredientUnit">
                                <option value="n/a" selected></option>
                                <option value="teaspoons">teaspoon</option>
                                <option value="tablespoon">tablespoon</option>
                                <option value="fluid ounce">fluid ounce</option>
                                <option value="cup">cup</option>
                                <option value="pint">pint</option>
                                <option value="quart">quart</option>
                                <option value="gallon">gallon</option>
                                <option value="milliliter">milliliter</option>
                                <option value="liter">liter</option>
                                <option value="ounce">ounce</option>
                                <option value="pound">pound</option>
                            </select></label>
                        <label for="ingredientName">Name:*
                        <input type="text" placeholder="Cookies (crushed)" id="ingredientName"></label>
                        <button type="button" id="addIngredient">+ Add Ingredient</button>
                </div>
                <div id="enteredIngredients">
                    <?php foreach($ingredients as $index => $ingredient): ?>
                        <div class="addedIngredients">
                            <div class="ingredientInputSet">
                                <label for="measurementAmount-<?php echo $index . $ingredient->ingredient_quantity; ?>">Amount:
                                    <input type="text" 
                                    name="ingredient[ingredient_quantity]" 
                                    pattern="^\d{1,2}(\s\d{1,2}\/\d{1,2})?$|^\d{1,2}\/\d{1,2}$"
                                    placeholder="1, 1/2, 1 1/2" 
                                    maxlength="6" 
                                    id="measurementAmount-<?php echo $index . $ingredient->ingredient_quantity; ?>"
                                    value="<?php echo decimal_to_fraction($ingredient->ingredient_quantity); ?>">
                                </label>
                                <label for="ingredientUnit-<?php echo $index. $ingredient->ingredient_measurement_name;?>">Unit:
                                    <select name="ingredient[ingredient_measurement_name]" id="ingredientUnit-<?php echo $index. $ingredient->ingredient_measurement_name;?>">
                                        <option value="n/a" <?php echo $ingredient->ingredient_measurement_name === "n/a" ? "selected" : ""; ?>></option>
                                        <option value="teaspoon" <?php echo $ingredient->ingredient_measurement_name === "teaspoon" ? "selected" : ""; ?>>teaspoon</option>
                                        <option value="tablespoon" <?php echo $ingredient->ingredient_measurement_name === "tablespoon" ? "selected" : ""; ?>>tablespoon</option>
                                        <option value="fluid ounce" <?php echo $ingredient->ingredient_measurement_name === "fluid ounce" ? "selected" : ""; ?>>fluid ounce</option>
                                        <option value="cup" <?php echo $ingredient->ingredient_measurement_name === "cup" ? "selected" : ""; ?>>cup</option>                           
                                        <option value="pint" <?php echo $ingredient->ingredient_measurement_name === "pint" ? "selected" : ""; ?>>pint</option>
                                        <option value="quart" <?php echo $ingredient->ingredient_measurement_name === "quart" ? "selected" : ""; ?>>quart</option>
                                        <option value="gallon" <?php echo $ingredient->ingredient_measurement_name === "gallon" ? "selected" : ""; ?>>gallon</option>
                                        <option value="milliliter" <?php echo $ingredient->ingredient_measurement_name === "milliliter" ? "selected" : ""; ?>>milliliter</option>                                    
                                        <option value="liter" <?php echo $ingredient->ingredient_measurement_name === "liter" ? "selected" : ""; ?>>liter</option>
                                        <option value="ounce" <?php echo $ingredient->ingredient_measurement_name === "ounce" ? "selected" : ""; ?>>ounce</option>
                                        <option value="pound" <?php echo $ingredient->ingredient_measurement_name === "pound" ? "selected" : ""; ?>>pound</option>
                                    </select>
                                </label>
                                <label for="ingredientName-<?php echo h($ingredient->ingredient_name);?>">Name:
                                    <input type="text" name="ingredient[ingredient_name]" placeholder="Cookies (crushed)" id="ingredientName-<?php echo h($ingredient->ingredient_name);?>" value="<?php echo h($ingredient->ingredient_name); ?>">
                                </label>
                                <button type="button" class="removeIngredient">X</button>
                            </div>
                        </div>
                        <?php endforeach; ?>

                </div>    
            </fieldset>

            

            <fieldset id="steps">
                <legend>Steps:*</legend>
                <span id="stepDirections">Enter a step to make your recipe. Click the 'plus' to add a step.</span>
                <?php if (!empty($errors['steps'])): ?>
                <p class="error-message"><?php echo $errors['steps']; ?></p>
                <?php endif; ?>
                <label for="stepInput" class="visuallyHidden">Step:</label>
                <div id="stepInputAndButton">
                    <textarea  placeholder="Describe the step in one or two short sentences." id="stepInput" rows="2" cols="25" maxlength="255"></textarea>
                    <button type="button" id="addStep" >+ Add Step</button>
                </div>
                <div id="enteredSteps">
                    <?php foreach ($steps as $index => $step): ?>
                        <div class="addedSteps">
                            <label for="stepInput_<?php echo $index; ?>" class="visuallyHidden">Step:</label>
                           
                            <textarea name="step[<?php echo $index; ?>][step_description]" id="stepInput_<?php echo $index; ?>"
                            rows="2" cols="25" maxlength="255"><?php echo h($step->step_description); ?>
                            </textarea>
                            <button type="button" class="removeStep">X</button>  
                        </div>
                    <?php endforeach; ?>
                </div>  
            </fieldset>

            <h3 class="recipePartName">Categories</h3>
            <span>Select up to 3 options for each category.</span>
            <div id="checkboxes">
                <fieldset>  
                    <div class="checkboxContainer">
                        <legend class="recipePartName">Meal Type</legend>
                        <?php if (!empty($errors['meal_types'])): ?>
                            <p class="error-message"><?php echo $errors['meal_types']; ?></p>
                        <?php endif; ?>
                        <?php foreach ($mealTypes as $mealType): ?>
                            <label>
                                <input type="checkbox" name="meal_types[]" 
                                    id="mealType-<?php echo $mealType->meal_type_name; ?>" 
                                    value="<?php echo $mealType->id; ?>"
                                    <?php echo in_array((int)$mealType->id, $selectedMealTypeIds) ? 'checked' : ''; ?>>
                                <?php echo ucfirst($mealType->meal_type_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="checkboxContainer">
                        <legend class="recipePartName">Style</legend>
                        <?php if (!empty($errors['styles'])): ?>
                            <p class="error-message"><?php echo $errors['styles']; ?></p>
                        <?php endif; ?>
                        <?php foreach ($styles as $style): ?>
                            <label>
                                <input type="checkbox" name="styles[]" 
                                    id="<?php echo $style->style_name; ?>" 
                                    value=<?php echo $style->id; ?>
                                    <?php echo in_array($style->id, $selectedStyleIds) ? 'checked' : ''; ?>>
                                <?php echo ucfirst($style->style_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="checkboxContainer">
                        <legend class="recipePartName">Diet</legend>
                        <?php if (!empty($errors['diets'])): ?>
                            <p class="error-message"><?php echo $errors['diets']; ?></p>
                        <?php endif; ?>
                        <?php foreach ($diets as $diet): ?>
                            
                            <label>
                                <input type="checkbox" name="diets[]" 
                                    id="diet-<?php echo $diet->diet_name; ?>" 
                                    value="<?php echo $diet->id; ?>"
                                    <?php echo in_array($diet->id, $selectedDietIds) ? 'checked' : ''; ?>>
                                <?php echo ucfirst($diet->diet_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            </div>

            <label for="recipe_image" class="recipePartName">Image Upload</label>
            <span id="recipeAcceptedFileTypes">Accepted file types: JPG, PNG, WEBP</span>
            <?php foreach ($recipe_images as $recipe_image): ?>
            <?php   $imagePath = $recipe_image->recipe_image  ;?>
            <input type="file" id="recipe_image" name="recipe_image">
                
            <img id="imagePreview" src="<?php echo url_for($imagePath); ?>" alt="Image Preview" style="display: block;">
            <?php endforeach; ?>

            <label for="youtube_link" class="recipePartName">YouTube Video Link:</label>
            <input type="url" id="youtube_link" name="recipe_video_url" placeholder="https://www.youtube.com/watch?v=..." value="<?php if($recipe_video): echo h(($recipe_video->recipe_video_url)); endif;?>">
            
            <div class="recipeSubmitReset">
                <span>Edit recipe feature not available yet.</span>
            </div>
        </form>
    </div>
</main>


<?php include(SHARED_PATH . '/public_footer.php'); ?>
