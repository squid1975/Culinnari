<?php
require_once('../../private/initialize.php');
$title = 'Create Recipe | Culinnari';
include(SHARED_PATH . '/public_header.php');
require_login();
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all();
$errors = [];
$username = $session->username;
$user = User::find_by_username($username);
$current_user_id = $user->id;

if (is_post_request()) {
    // Get arrays of values 
    
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
    // Handle time conversion
    $prep_hours = (int)($_POST['prep_hours']) ?? 0;
    $prep_minutes = (int)($_POST['prep_minutes'])?? 0;
    $recipe_prep_time_seconds = (int) $prep_hours * 3600 + $prep_minutes * 60;    
    // Validate prep and cook time values
    $cook_hours = isset($_POST['cook_hours']) ? (int)$_POST['cook_hours'] : 0;
    $cook_minutes = isset($_POST['cook_minutes']) ? (int)$_POST['cook_minutes'] : 0;
    $recipe_cook_time_seconds = timetoSeconds($cook_hours, $cook_minutes);

    if ($recipe_cook_time_seconds === 0 && $recipe_prep_time_seconds === 0) {
        $errors['time'] = "Please enter a value for the prep and/or cook time.";
    } else {
        $_POST['recipe_prep_time_seconds'] = $recipe_prep_time_seconds;
        $_POST['recipe_cook_time_seconds'] = $recipe_cook_time_seconds;
    }

    // Image Upload
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
        // Get file details
        $fileTmpPath = $_FILES['recipe_image']['tmp_name'];
        $fileName = $_FILES['recipe_image']['name'];
        $fileType = $_FILES['recipe_image']['type'];
        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
    
        if (in_array($fileType, $allowedTypes)) {
            // Define upload directory
            $uploadDir = __DIR__ . '/../images/uploads/recipe_image/';
    
            // Ensure directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Remove dangerous characters and whitespace from the original filename
            $safeFileName = preg_replace("/[^A-Za-z0-9_\-]/", '', pathinfo($fileName, PATHINFO_FILENAME));
            $newfileName = strtolower($safeFileName); // optional: normalize case      
    
            // Generate a unique filename
            $uniqueName = uniqid() . '_' . $newfileName;
            $webpFileName = $uniqueName . '.webp';
            $webpPath = $uploadDir . $webpFileName;
    
            // Process image based on file type
            $image = false;
            // Check if the file is a JPEG, PNG, or WEBP 
            switch ($fileType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($fileTmpPath);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($fileTmpPath);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    break;
                case 'image/webp':
                    if (move_uploaded_file($fileTmpPath, $webpPath)) {
                        $imageURL = '/images/uploads/recipe_image/' . $webpFileName;
                        return;
                    } else {
                        $errors['image'] = "Error moving the uploaded WebP file.";
                    }
                    break;
                default:
                    $errors['image'] = "Unsupported file type.";
            }
    
            // Convert and save as WebP
            if ($image !== false) {
                if (imagewebp($image, $webpPath, 80)) {
                    imagedestroy($image);
                    $imageURL = '/images/uploads/recipe_image/' . $webpFileName;
                    unlink($fileTmpPath); // Optional: delete original file
                } else {
                    $errors['image'] = "Failed to convert image to WebP.";
                }
            } else {
                $errors['image'] = "Image processing failed.";
            }
        } else {
            $errors['image'] = "Invalid file type. Only JPEG, PNG, and WEBP are allowed.";
        }
    } else {
        // Default image if no file uploaded
        $imageURL = '/images/default_recipe_image.webp';
    }

    if (isset($_POST['recipe_video_url']) && !empty($_POST['recipe_video_url'])) {
        $inputUrl = trim($_POST['recipe_video_url']);
        $videoID = extractYouTubeID($inputUrl);  
        $embeddableURL = convertToEmbedURL($videoID);
    }
    

    if (empty($errors)) {
        $_POST['recipe_image'] = $imageURL;
            try {
                $args = $_POST['recipe'];
                $args += ['recipe_prep_time_seconds' => $recipe_prep_time_seconds];
                $args += ['recipe_cook_time_seconds' => $recipe_cook_time_seconds];
                $args += ['user_id' => (int)$current_user_id];
                $recipe = new Recipe($args);
                $result = $recipe->save();

                if (!$result) { // If recipe insertion fails
                    throw new Exception("Unable to insert recipe.");
                    $recipe_errors = $recipe->errors;
                }

                $recipe_id = $recipe->id;

                foreach ($ingredients as $index => &$ingredientValues) {
                    $ingredientValues['recipe_id'] = $recipe_id;
                    $ingredientValues['ingredient_recipe_order'] = $index + 1;
                    if ($ingredientValues['ingredient_measurement_name'] == "") {
                        $ingredientValues['ingredient_measurement_name'] = 'n/a';
                    }
                    $ingredientValues['ingredient_quantity'] = fractionToDecimal($ingredientValues['ingredient_quantity']);
                    $ingredient = new Ingredient($ingredientValues);
                    $result = $ingredient->save();

                    if (!$result) { // If any ingredient insertion fails
                        $ingredient_errors = $ingredient->errors;
                        throw new Exception("Unable to insert ingredient at index $index.");
                    }
                }

                foreach($steps as $index => &$stepValue) {
                    $stepValue['recipe_id'] = $recipe_id;
                    $stepValue['step_number'] = $index + 1;
                    
                    // Use the step description already in $stepValue
                    $step = new Step($stepValue);
                    $result = $step->save();
                
                    if(!$result) {
                        $step_errors = $step->errors;
                        throw new Exception("Unable to save step at index {$index}.");
                    }
                }

                if(!empty($selectedMealTypes)){
                    foreach($selectedMealTypes as $mealTypeId){
                        $recipeMealType = [
                            'meal_type_id' => $mealTypeId,
                            'recipe_id' =>$recipe_id
                        ];
                        $recMealType = new RecipeMealType($recipeMealType);
                        $result = $recMealType->save();
                    } if(!$result){
                        throw new Exception(message: "Unable to insert recipe meal type.");
                    }
                }

                if(!empty($selectedDiets)){
                    foreach($selectedDiets as $dietId){
                        $recipeDietType = [
                            'diet_id' => $dietId,
                            'recipe_id' => $recipe_id
                        ];
                        
                        $recDiet = new RecipeDiet($recipeDietType);
                        $result = $recDiet->save();
                
                        if(!$result) {
                            throw new Exception("Unable to insert recipe diet types.");
                        }
                    }
                }
                
                // Style processing
                if(!empty($selectedStyles)){
                    foreach($selectedStyles as $styleId){
                        $recipeStyle = [
                            'style_id' => $styleId,
                            'recipe_id' => $recipe_id
                        ];
                        
                        $recStyle = new RecipeStyle($recipeStyle);
                        $result = $recStyle->save();
                
                        if(!$result) {
                            throw new Exception("Unable to insert recipe styles.");
                        }
                    }
                }

                $recImg = [
                    'recipe_image' => $_POST['recipe_image'],
                    'recipe_id' =>$recipe->id
                ];

                $recipeImage = new RecipeImage($recImg);
                $result = $recipeImage->save();
                if(!$result){
                    throw new Exception(message: "Unable to insert recipe image.");
                }

                if($videoID){
                    $recVid = [
                        'recipe_video_url' => $embeddableURL,
                        'recipe_id' => $recipe->id
                    ];
                    $recipeVideo = new RecipeVideo(args:$recVid);
                    $result = $recipeVideo->save();
                    if(!$result){
                        $recipe_video_errors = $recipeVideo->errors;
                        throw new Exception(message: "Unable to insert recipe video link.");
                    }
                }
                // If all insertions succeed, commit the transaction
                $database->commit();
                redirect_to(url_for('/member/profile.php?id=' . $current_user_id));
                $_SESSION['message'] = 'Recipe created successfully.';
            } catch (Exception $e) {
                $database->rollback(); // Undo changes if anything fails
                $errors[] = $e->getMessage();
                $_SESSION['errors'] = [$e->getMessage()];
                redirect_to(url_for('/member/create_recipe.php'));
            }
    } 
    
}
else {
    $recipe = new Recipe;
}


?>
<main role="main" tabindex="-1">
    <div class="recipeFormWrapper">
        <div class="recipeFormHeading">
            <h2>Create Recipe</h2>
            <p>Fill out the form below to create a new recipe.</p>
            <p>Fields marked with * required.</p>
            <?php echo display_errors($errors); ?>
         
            <?php if (isset($_SESSION['errors'])): ?>
                <p class="error-message"><?php echo $_SESSION['errors'][0]; ?></p>
                <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>
        </div>
        <form action="create_recipe.php" method="POST" enctype="multipart/form-data" class="recipeForm">
             <input type="hidden" name="recipe[user_id]" value="<?php echo h($current_user_id); ?>">
             <?php if (isset($recipe_errors['recipe_name'])): ?>
                    <div class="error-messages">
                    <?php foreach ($recipe_errors['recipe_name'] as $error): ?>
                        <p class="error"><?php echo h($error); ?></p>
                        <?php endforeach; ?>
                    </div>
            <?php endif; ?>
            <label for="recipeName" class="recipePartName">Recipe Name:*</label>
            <input type="text" id="recipeName" name="recipe[recipe_name]" maxlength="40" pattern="^[A-Za-z \-']+$"required value="<?php echo h($_POST['recipe']['recipe_name'] ?? ''); ?>">

            <label for="recipeDescription" class="recipePartName">Description:*</label>
            <span id="recipeDescriptionDirections">Limit 255 characters.</span>
            <?php if (isset($recipe_errors['recipe_description'])): ?>
                    <div class="error-messages">
                    <?php foreach ($recipe_errors['recipe_description'] as $error): ?>
                        <p class="error"><?php echo h($error); ?></p>
                        <?php endforeach; ?>
                    </div>
            <?php endif; ?>
            <textarea id="recipeDescription" name="recipe[recipe_description]" maxlength="255" rows="4" cols="50" required><?php echo h($_POST['recipe']['recipe_description'] ?? ''); ?></textarea>

            

            <fieldset>
                <legend id="recipeDifficultyLabel">Difficulty</legend>
                <?php if (isset($recipe_errors['recipe_difficulty'])): ?>
                    <div class="error-messages">
                    <?php foreach ($recipe_errors['recipe_difficulty'] as $error): ?>
                        <p class="error"><?php echo h($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="radio-group">
                    <div class="formField">
                        <input type="radio" id="beginner" name="recipe[recipe_difficulty]" value="beginner" checked
                            <?php if (isset($_POST['recipe']['recipe_difficulty'])) {
                                echo $_POST['recipe']['recipe_difficulty'] === 'beginner' ? 'checked' : '';
                            } ?>>
                        <label for="beginner">Beginner</label>
                    </div>

                    <div class="formField">
                        <input type="radio" id="intermediate" name="recipe[recipe_difficulty]" value="intermediate"
                            <?php if (isset($_POST['recipe']['recipe_difficulty'])) {
                                echo $_POST['recipe']['recipe_difficulty'] === 'intermediate' ? 'checked' : '';
                            } ?>>
                        <label for="intermediate">Intermediate</label>
                    </div>

                    <div class="formField">
                        <input type="radio" id="advanced" name="recipe[recipe_difficulty]" value="advanced" <?php if (isset($_POST['recipe']['recipe_difficulty'])) {
                            echo $_POST['recipe']['recipe_difficulty'] === 'advanced' ? 'checked' : '';
                        } ?>>
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
                            <input type="number" id="prepTimeHours" name="prep_hours" min="0" max="99" step="1" placeholder="Hrs" value="<?php echo h($_POST['prep_hours'] ?? ''); ?>"></label>
                        <label for="prepTimeMinutes">Minutes:
                            <input type="number" id="prepTimeMinutes" name="prep_minutes" min="0" max="59" step="1" placeholder="Min" value="<?php echo h($_POST['prep_minutes'] ?? ''); ?>"></label>
                    </div>
                </fieldset>


                <fieldset>
                    <legend>Cook Time</legend>
                    <div class="timeContainer">
                        <label for="cookTimeHours">Hours:
                            <input type="number" id="cookTimeHours" name="cook_hours" min="0" max="99" step="1"
                                placeholder="Hrs" value="<?php echo h($_POST['cook_hours'] ?? ''); ?>">
                        </label>

                        <label for="cookTimeMinutes">Minutes:
                            <input type="number" id="cookTimeMinutes" name="cook_minutes" min="0" max="59" step="1"
                                placeholder="Min" value="<?php echo h($_POST['cook_minutes'] ?? ''); ?>">
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
                <input type="number" id="totalServings" name="recipe[recipe_total_servings]" min="1" max="99" step="1"
                    value="<?php echo h($_POST['recipe']['recipe_total_servings'] ?? ''); ?>" required>
            </div>

            <fieldset id="ingredients">
                <legend>Ingredients:*</legend>
                <span id="ingredientDirections">Type the ingredient quantity and select a unit if applicable. Type the
                    ingredient name and any special instructions. Example: ingredient name, instructions.</span>
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
                
                <?php if (!empty($errors['ingredients'])): ?>
                    <p class="error-message"><?php echo $errors['ingredients']; ?></p>
                <?php endif; ?>
                <div id="ingredientInputs">
                    <label for="measurementAmount">Amount:*
                        <input type="text" id="measurementAmount" placeholder="1,1/2,1 1/2"
                            pattern="^\d{1,2}(\s\d{1,2}\/\d{1,2})?$|^\d{1,2}\/\d{1,2}$" maxlength="6"></label>
                    <label for="ingredientUnit">Unit:
                        <select id="ingredientUnit">
                            <option value="n/a" selected>N/A</option>
                            <option value="teaspoon">teaspoon</option>
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
                        <input type="text" placeholder="Cookies,crushed" id="ingredientName">
                    </label>
                    <button type="button" id="addIngredient">+ Add Ingredient</button>
                </div>
                <div id="enteredIngredients">

                </div>
            </fieldset>

            <fieldset id="steps">
                <legend>Steps:*</legend>
                <span id="stepDirections">Enter a step to make your recipe. Click the 'plus' to add a step.</span>
                <?php if (isset($step_errors['step_description'])): ?>
                        <div class="error-messages">
                        <?php foreach ($step_errors['step_description'] as $error): ?>
                            <p class="error"><?php echo h($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                <?php endif; ?>
                <?php if (!empty($errors['steps'])): ?>
                    <p class="error-message"><?php echo $errors['steps']; ?></p>
                <?php endif; ?>
                <label for="stepInput" class="visuallyHidden">Step:</label>
                <div id="stepInputAndButton">
                    <textarea placeholder="Describe the step in one or two short sentences." id="stepInput" rows="2"
                        cols="25" maxlength="255"></textarea>
                    <button type="button" id="addStep">+ Add Step</button>
                </div>
                <div id="enteredSteps">

                </div>
            </fieldset>

            <h3 class="recipePartName">Categories</h3>
            <span>Select up to 3 options for each category.</span>
            <div id="checkboxes">
                <fieldset>
                    <legend class="recipePartName">Meal Type</legend>
                    <div class="checkboxContainer">
                        <?php if (!empty($errors['meal_types'])): ?>
                            <p class="error-message"><?php echo $errors['meal_types']; ?></p>
                        <?php endif; ?>
                        <?php foreach ($mealTypes as $mealType): ?>
                            <label>
                                <input type="checkbox" name="meal_types[]"
                                    id="mealType-<?php echo str_replace(' ', '',$mealType->meal_type_name); ?>" value="<?php echo $mealType->id; ?>">
                                <?php echo ucfirst($mealType->meal_type_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="recipePartName">Style</legend>
                    <div class="checkboxContainer">
                        <?php if (!empty($errors['styles'])): ?>
                            <p class="error-message"><?php echo $errors['styles']; ?></p>
                        <?php endif; ?>
                        <?php foreach ($styles as $style): ?>
                            <label>
                                <input type="checkbox" name="styles[]" id="style-<?php echo str_replace(' ', '',$style->style_name); ?>"
                                    value="<?php echo $style->id; ?>">
                                <?php echo ucfirst($style->style_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="recipePartName">Diet</legend>
                    <div class="checkboxContainer">
                        <?php if (!empty($errors['diets'])): ?>
                            <p class="error-message"><?php echo $errors['diets']; ?></p>
                        <?php endif; ?>
                        <?php foreach ($diets as $diet): ?>
                            <label>
                                <input type="checkbox" name="diets[]" id="diet-<?php echo str_replace(' ', '', $diet->diet_name); ?>"
                                    value="<?php echo $diet->id; ?>">
                                <?php echo ucfirst($diet->diet_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            </div>
            
            <?php if (!empty($errors['image'])): ?>
                    <p class="error-message"><?php echo $errors['image']; ?></p>
                <?php endif; ?>
            <label for="recipe_image" class="recipePartName">Image Upload</label>
            <span id="recipeAcceptedFileTypes">Accepted file types: JPG, PNG, WEBP</span>
            <input type="file" id="recipe_image" name="recipe_image">
            <img id="imagePreview" src="#" alt="Image Preview">

            <label for="youtube_link" class="recipePartName">YouTube Video Link:</label>
            <input type="url" id="youtube_link" name="recipe_video_url" placeholder="https://www.youtube.com/watch?v=...">

            <div class="recipeSubmitReset">
                <input type="submit" value="Create Recipe" id="createRecipeButton" class="createRecipeButton">
                <button type="reset" id="clearRecipeFormButton">Clear form</button>
                <div class="modal" id="clearRecipeFormModal">
                    <div class="modal-content">
                        <h2>Reset recipe form</h2>
                        <p>Are you sure you want to clear the form?</p>
                        <button id="confirmFormReset" class="deleteButton">Reset form</button>
                        <button id="cancelReset">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
<script src="<?php echo url_for('/js/createRecipe.js'); ?>" defer></script>

<?php include(SHARED_PATH . '/public_footer.php'); ?>