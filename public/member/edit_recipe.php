<?php 
require_once('../../private/initialize.php'); 
$title = 'Edit Recipe | Culinnari';
include(SHARED_PATH . '/public_header.php'); 
require_login();
$username = $session->username;
$user = User::find_by_username($username);
$recipe_id = $_GET['recipe_id'] ?? null; // Get the recipe ID from the URL
$recipe = Recipe::find_by_id($recipe_id);
if(!$recipe || $recipe->user_id != $user->id) {
    $_SESSION['message'] = "There was an error retrieving the recipe.";
    redirect_to(url_for('/member/profile.php?id=' . $user->id));
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

if (is_post_request()) {
    
    // Get and validate form data (same as creation)
    $steps = $_POST['step'] ?? [];
    if(empty($steps)){
        $errors['steps'] = "At least one step is required.";
    }
    $ingredients = $_POST['ingredient'] ?? [];
    if(empty($ingredients)){
        $errors['ingredients'] = "At least one ingredient is required.";
    }
    $selectedMealTypes = $_POST['meal_types'] ?? [];
    if(count($selectedMealTypes) > 3){
        $errors['meal_types'] = "You can select up to 3 meal types only.";
    }
    $selectedStyles = $_POST['styles'] ?? [];
    if(count($selectedStyles) > 3){
        $errors['styles'] = 'You can select up to 3 styles only.';
    }
    $selectedDiets = $_POST['diets']?? [];
    if(count($selectedDiets) > 3){
        $errors['diets'] = 'You can select up to 3 diets only.';
    }

    // Handle time conversion (same as creation)
    $prep_hours = (int)($_POST['prep_hours']) ?? 0;
    $prep_minutes = (int)($_POST['prep_minutes'])?? 0;
    $recipe_prep_time_seconds = (int) $prep_hours * 3600 + $prep_minutes * 60;    
    $cook_hours = isset($_POST['cook_hours']) ? (int)$_POST['cook_hours'] : 0;
    $cook_minutes = isset($_POST['cook_minutes']) ? (int)$_POST['cook_minutes'] : 0;
    $recipe_cook_time_seconds = timetoSeconds($cook_hours, $cook_minutes);

    // Validate time values
    if ($recipe_cook_time_seconds === 0 && $recipe_prep_time_seconds === 0) {
        $errors['time'] = "Please enter a value for the prep and/or cook time.";
    } else {
        $_POST['recipe_prep_time_seconds'] = $recipe_prep_time_seconds;
        $_POST['recipe_cook_time_seconds'] = $recipe_cook_time_seconds;
    }

    // // Image Upload (same as creation)
    // if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
    //     // Handle image upload and conversion (same as creation)
    //     // You can keep the same image upload logic but update the existing recipe image if uploaded
    // }

    // // Handle video URL if provided
    // if (isset($_POST['recipe_video_url']) && !empty($_POST['recipe_video_url'])) {
    //     $inputUrl = trim($_POST['recipe_video_url']);
    //     $videoID = extractYouTubeID($inputUrl);  
    //     $embeddableURL = convertToEmbedURL($videoID);
    // }

    // If no errors, proceed with updating the recipe and related tables
    if (empty($errors)) {
        $_POST['recipe_image'] = $imageURL;
        try {
            // Merge attributes and save the recipe
            $args = $_POST['recipe'];
            $args += ['recipe_prep_time_seconds' => $recipe_prep_time_seconds];
            $args += ['recipe_cook_time_seconds' => $recipe_cook_time_seconds];
            $args += ['user_id' => (int)$user->id];
            $recipe->merge_attributes($args);
            $result = $recipe->save();

            if (!$result) { // If recipe insertion fails
                throw new Exception("Unable to update recipe.");
                $recipe_errors = $recipe->errors;
            }

            // // Update Ingredients
            // foreach ($ingredients as $index => &$ingredientValues) {
            //     $ingredient = Ingredient::find_by_recipe_id_and_order($recipe_id, $index + 1);
            //     $ingredientValues['ingredient_recipe_order'] = $index + 1;
            //     if ($ingredientValues['ingredient_measurement_name'] == "") {
            //         $ingredientValues['ingredient_measurement_name'] = 'n/a';
            //     }
            //     $ingredientValues['ingredient_quantity'] = fractionToDecimal($ingredientValues['ingredient_quantity']);
            //     if ($ingredient) {
            //         $ingredient->merge_attributes($ingredientValues); // Merge attributes
            //         $ingredient->save(); // Save the updated ingredient
            //         if(!$result) {
            //             throw new Exception("Unable to update ingredient.");
            //         }
            //     } else {
            //         $ingredient = new Ingredient($ingredientValues);
            //         $ingredient->save(); // Create new if not found
            //         if(!$result) {
            //             throw new Exception("Unable to add new ingredient.");
            //         }
            //     }
            // }

            // // Update Steps
            // foreach($steps as $index => &$stepValue) {
            //     $step = Step::find_by_recipe_id_and_step_number($recipe_id, $index + 1);
            //     $stepValue['step_number'] = $index + 1;
            //     if ($step) {
            //         $step->merge_attributes($stepValue); // Merge attributes
            //         $step->save(); // Save the updated step
            //         if(!$result) {
            //             throw new Exception("Unable to update step.");
            //         }
            //     } else {
            //         $step = new Step($stepValue);
            //         $step->save(); // Create new if not found
            //         if(!$result) {
            //             throw new Exception("Unable to create new step.");
            //         }
            //     }
            // }

            // // Update Meal Types
            // if(!empty($selectedMealTypes)){
            //     foreach($selectedMealTypes as $mealTypeId){
            //         $recipeMealType = RecipeMealType::find_by_recipe_id_and_meal_type_id($recipe_id, $mealTypeId);
            //         if (!$recipeMealType) {
            //             $recipeMealType = new RecipeMealType(['meal_type_id' => $mealTypeId, 'recipe_id' => $recipe_id]);
            //         }
            //         $recipeMealType->save();
            //     }
            // }

            // // Update Diets
            // if(!empty($selectedDiets)){
            //     foreach($selectedDiets as $dietId){
            //         $recipeDietType = RecipeDiet::find_by_recipe_id_and_diet_id($recipe_id, $dietId);
            //         if (!$recipeDietType) {
            //             $recipeDietType = new RecipeDiet(['diet_id' => $dietId, 'recipe_id' => $recipe_id]);
            //         }
            //         $recipeDietType->save();
            //     }
            // }

            // // Update Styles
            // if(!empty($selectedStyles)){
            //     foreach($selectedStyles as $styleId){
            //         $recipeStyle = RecipeStyle::find_by_recipe_id_and_style_id($recipe_id, $styleId);
            //         if (!$recipeStyle) {
            //             $recipeStyle = new RecipeStyle(['style_id' => $styleId, 'recipe_id' => $recipe_id]);
            //         }
            //         $recipeStyle->save();
            //     }
            // }

            // // Update Recipe Image
            // if ($imageURL !== '/images/default_recipe_image.webp') {
            //     $recImg = ['recipe_image' => $imageURL, 'recipe_id' => $recipe_id];
            //     $recipeImage = RecipeImage::find_by_recipe_id($recipe_id);
            //     if ($recipeImage) {
            //         $recipeImage->merge_attributes($recImg); // Merge attributes
            //         $recipeImage->save(); // Save the updated image record
            //     } else {
            //         $recipeImage = new RecipeImage($recImg);
            //         $recipeImage->save(); // Create new if not found
            //     }
            // }

            // // Update Recipe Video URL (if exists)
            // if ($videoID) {
            //     $recVid = ['recipe_video_url' => $embeddableURL, 'recipe_id' => $recipe_id];
            //     $recipeVideo = RecipeVideo::find_by_recipe_id($recipe_id);
            //     if ($recipeVideo) {
            //         $recipeVideo->merge_attributes($recVid); // Merge attributes
            //         $recipeVideo->save(); // Save the updated video
            //     } else {
            //         $recipeVideo = new RecipeVideo($recVid);
            //         $recipeVideo->save(); // Create new if not found
            //     }
            // }

            // Commit changes
            $database->commit();
            $_SESSION['message'] = 'Recipe updated successfully.';
            redirect_to(url_for('/member/profile.php?id=' . $user->id));
        } catch (Exception $e) {
            $database->rollback(); // Rollback changes if anything fails
            $errors[] = $e->getMessage();
            $_SESSION['errors'] = [$e->getMessage()];
            redirect_to(url_for('/member/edit_recipe.php?id=' . $recipe_id));
        }
    }

} else {
    // Show the form with current recipe data populated
    
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
        <form action="<?php echo url_for('/member/edit_recipe.php?recipe_id=' . h(u($recipe_id)));?>" method="POST" enctype="multipart/form-data" class="recipeForm">
            <input type="hidden" name="recipe[id]" value="<?php echo h($recipe->id); ?>">

            <?php if (isset($recipe_errors['recipe_name'])): ?>
                    <div class="error-messages">
                    <?php foreach ($recipe_errors['recipe_name'] as $error): ?>
                        <p class="error"><?php echo h($error); ?></p>
                        <?php endforeach; ?>
                    </div>
            <?php endif; ?>
            <label for="recipeName" class="recipePartName">Recipe Name:*</label>
            <input type="text" id="recipeName" name="recipe[recipe_name]" maxlength="100" required value="<?php echo h($recipe->recipe_name); ?>">


            <label for="recipeDescription" class="recipePartName">Description:*</label>
            <span id="recipeDescriptionDirections">Limit 255 characters.</span>
            <?php if (isset($recipe_errors['recipe_description'])): ?>
                    <div class="error-messages">
                    <?php foreach ($recipe_errors['recipe_description'] as $error): ?>
                        <p class="error"><?php echo h($error); ?></p>
                        <?php endforeach; ?>
                    </div>
            <?php endif; ?>
            <textarea id="recipeDescription" name="recipe[recipe_description]" maxlength="255" rows="4" cols="50" required><?php echo $recipe->recipe_description; ?></textarea>

            <fieldset>
                <legend id="recipeDifficultyLabel">Difficulty</legend>
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
                        <span id="timeDirections">A value is required for either the prep or cook time.*</span>
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
                                <input type="number" id="cookTimeHours" name="cook_hours" min="0" max="99" step="1" placeholder="Hrs" value="<?php echo floor($recipe->recipe_cook_time_seconds / 3600); ?>">
                            </label>
                            <label for="cookTimeMinutes">Minutes:
                                <input type="number" id="cookTimeMinutes" name="cook_minutes" min="0" max="59" step="1" placeholder="Min" value="<?php echo ($recipe->recipe_cook_time_seconds % 3600) / 60; ?>">
                            </label>
                        </div>
                    </fieldset>    
            </div>

            <div id="totalServingsContainer">
                <?php if (isset($recipe_errors['recipe_total_servings'])): ?>
                        <div class="error-messages">
                        <?php foreach ($recipe_errors['recipe_total_servings'] as $error): ?>
                            <p class="error"><?php echo h($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                <?php endif; ?>
                <label for="totalServings" class="recipePartName">Total Servings:*</label>
                <input type="number" id="totalServings" name="recipe[recipe_total_servings]" min="1" max="99" step="1" required value="<?php echo ($recipe->recipe_total_servings); ?>">
            </div>

            <fieldset id="ingredients">
                <legend>Ingredients:*</legend>
                <span id="ingredientDirections">Type the measurement amount and select a unit if applicable. Type the ingredient name with any special instructions in parentheses. Click 'plus' to add.</span>
                <?php if (!empty($errors['ingredients'])): ?>
                <p class="error-message"><?php echo $errors['ingredients']; ?></p>
                <?php endif; ?>
                <?php if (isset($ingredient_errors['ingredient_name'])): ?>
                        <div class="error-messages">
                        <?php foreach ($ingredient_errors['ingredient_name'] as $error): ?>
                            <p class="error"><?php echo h($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                <?php endif; ?>
                <?php if (isset($ingredient_errors['ingredient_quantity'])): ?>
                        <div class="error-messages">
                        <?php foreach ($ingredient_errors['ingredient_quantity'] as $error): ?>
                            <p class="error"><?php echo h($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                <?php endif; ?>
                <?php if (isset($ingredient_errors['ingredient_measurement_name'])): ?>
                        <div class="error-messages">
                        <?php foreach ($ingredient_errors['ingredient_measurement_name'] as $error): ?>
                            <p class="error"><?php echo h($error); ?></p>
                            <?php endforeach; ?>
                        </div>
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
                <input type="submit" value="Update Recipe" id="createRecipeButton">
            </div>
        </form>
    </div>
</main>


<?php include(SHARED_PATH . '/public_footer.php'); ?>
