<?php require_once('../../private/initialize.php'); 
$pageTitle = "Create Recipe | Culinnari"; 
include(SHARED_PATH . '/public_header.php'); ?>
<script src="<?php echo url_for('js/script.js'); ?>" defer></script>
<?php
require_login();
$mealTypes = MealType::find_all();
$styles = Style::find_all();
$diets = Diet::find_all(); 
$errors = [];

if (is_post_request()) {
    $rawIngredients = $_POST['ingredient'];
    $ingredients = [];

    for ($i = 0; $i < count(value: $rawIngredients); $i += 3) {
        $ingredients[] = [
            'ingredient_quantity' => $rawIngredients[$i]['ingredient_quantity'],
            'ingredient_measurement_name' => $rawIngredients[$i + 1]['ingredient_measurement_name'],
            'ingredient_name' => $rawIngredients[$i + 2]['ingredient_name']
    ];
}
    $steps = $_POST['step']; 
    var_dump($ingredients);
    var_dump($steps);

    // Handle time conversion
    $prep_hours = (int)($_POST['prep_hours']) ?? 0;
    $prep_minutes = (int)($_POST['prep_minutes'])?? 0;
    var_dump($prep_hours);
    var_dump($prep_minutes);
    $prep_time_seconds = (int)($prep_hours * 3600) + ($prep_minutes * 60);
    var_dump($prep_time_seconds);

    if ($prep_time_seconds === 0) {
        $errors[] = "Error: Prep time cannot be zero.";
    }

    $cook_hours = isset($_POST['cook_hours']) ? (int)$_POST['cook_hours'] : 0;
    $cook_minutes = isset($_POST['cook_minutes']) ? (int)$_POST['cook_minutes'] : 0;
    $cook_time_seconds = timetoSeconds($cook_hours, $cook_minutes);

    if ($cook_time_seconds === 0) {
        $errors[] = "Error: Cook time cannot be zero.";
    }

    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
        // Get file details
        $fileTmpPath = $_FILES['recipe_image']['tmp_name'];
        $fileName = $_FILES['recipe_image']['name'];
        $fileType = $_FILES['recipe_image']['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    
        if (in_array($fileType, $allowedTypes)) {
            // Generate a unique filename
            $newFileName = uniqid('recipe_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
    
            // Define the upload directory
            $uploadDir = __DIR__ . '/../images/uploads/recipe_image/';
    
            // Ensure the directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Full destination path
            $destPath = $uploadDir . $newFileName;
    
            // Move the uploaded file
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imageURL = '/images/uploads/recipe_image/' . $newFileName;
            } else {
                $errors[] = "Error moving the uploaded file.";
            }
        } else {
            $errors[] = "Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.";
        }
    } else {
        // Use default image if no file was uploaded
        $imageURL = '/images/default_recipe_image.webp';
    }
    

    if (empty($errors)) {
        $selectedMealTypes = $_POST['meal_types'] ?? [];
        $selectedStyles = $_POST['styles'] ?? [];
        $selectedDiets = $_POST['diets'] ?? [];
        
        $video = $_POST['recipe_video_url'] ?? '';
        $image = $imageURL;
        $args = $_POST['recipe'];
        $recipe = new Recipe($args);
        $result = $recipe->save();
    
        if ($result) {
            redirect_to(url_for('member/profile.php?id=' . $_SESSION['user_id']));
            exit();
        } else {
            $errors[] = "Unable to save recipe.";
        }
    }
} else {
    $recipe = new Recipe;
}

?>


<main role="main" tabindex="-1">

    <div class="recipeFormWrapper">
        <div class="recipeFormHeading">
            <h2>Recipe Information</h2>
            <p>Fill out the form below to create a new recipe.</p>
            <?php echo display_errors($errors); ?>
        </div>
        <form action="create_recipe.php" method="POST" enctype="multipart/form-data" id="createRecipeForm">
            <label for="recipeName" class="recipePartName">Recipe Name:</label>
            <input type="text" id="recipeName" name="recipe[recipe_name]" maxlength="100" required>

            <label for="recipeDescription" class="recipePartName">Description:</label>
            <span>Description must be no more than 255 characters.</span>
            <textarea id="recipeDescription" name="recipe[recipe_description]" maxlength="255" rows="4" cols="50"></textarea>

            <fieldset>
                <legend>Difficulty</legend>
                <div class="radio-group">
                    <input type="radio" id="beginner" name="recipe[recipe_difficulty]" value="beginner" checked>
                    <label for="beginner">Beginner</label>

                    <input type="radio" id="intermediate" name="recipe[recipe_difficulty]" value="intermediate">
                    <label for="intermediate">Intermediate</label>

                    <input type="radio" id="advanced" name="recipe[recipe_difficulty]" value="advanced">
                    <label for="advanced">Advanced</label>
                </div>
            </fieldset>
            
            <h3 class="recipePartName">Categories</h3>
            <span>Select up to 3 options for each category.</span>
            <div id="checkboxes">
                <fieldset>  
                    <div class="checkboxContainer">
                        <legend class="recipePartName">Meal Type</legend>
                        <?php foreach ($mealTypes as $mealType): ?>
                            <label>
                                <input type="checkbox" name="meal_type[meal_type_id][]" id="mealType" value="<?php echo $mealType->meal_type_name; ?>">
                                <?php echo ucfirst($mealType->meal_type_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="checkboxContainer">
                        <legend class="recipePartName">Style</legend>
                        <?php foreach ($styles as $style): ?>
                            <label>
                                <input type="checkbox" name="style[style_id][]" id="style" value="<?php echo $style->style_name; ?>">
                                <?php echo ucfirst($style->style_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <div class="checkboxContainer">
                        <legend class="recipePartName">Diet</legend>
                        <?php foreach ($diets as $diet): ?>
                            <label>
                                <input type="checkbox" name="diet[diet_id][]" id="diet" value="<?php echo $diet->diet_name; ?>">
                                <?php echo ucfirst($diet->diet_name); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                </fieldset>



            <div id="timeInput">
                <div id="prepTimeInput">
                    <fieldset>
                        <legend>Prep Time</legend>
                        <div class="prep-time-container">
                            <label for="prep_time_hours">Hours <input type="number" id="prep_time_minutes" name="prep_hours" min="0" max="59" step="1" placeholder="Min"></label>
                            
                            <label for="prep_time_minutes">Minutes <input type="number" id="prep_time_minutes" name="prep_minutes" min="0" max="59" step="1" placeholder="Min"></label>
                        </div>
                    </fieldset>
                </div>

                <div id="cookTimeInput">
                    <fieldset>
                        <legend>Cook Time</legend>
                        <div class="prep-time-container">
                            <label for="cook_time_hours">Hours</label>
                                <input type="number" id="cook_time_hours" name="cook_hours" min="0" step="1" placeholder="Hrs">
                            
                            <label for="cook_time_minutes">Minutes<input type="number" id="cook_time_minutes" name="cook_minutes" min="0" max="59" step="1" placeholder="Min"></label>
                        </div>
                    </fieldset>
                </div>
            </div>

            <label for="totalServings" class="recipePartName">Total Servings:
                <input type="number" id="totalServings" name="recipe[recipe_total_servings]" min="1" max="50" step="1"></label>

            <fieldset>
                <legend>Ingredients</legend>
                <span id="ingredientDirections">Type the measurement amount. Select a unit (if applicable). Then type the ingredient name, and any special instructions (packed, crushed, etc.) into the text box. Click the 'plus' to add your ingredient.</span>
                <div id="ingredientInputSet">
                    <label for="measurementAmount">Amount:
                        <input type="text"  pattern="^\d+(\s\d+/\d+)?$|^\d+\/\d+$" placeholder="1/2" id="measurementAmount" maxlength="4"></label>
                        <label for="ingredientUnit">Unit:
                            <select id="ingredientUnit">
                                <option value="n/a" selected></option>
                                <option value="teaspoons">teaspoon(s)</option>
                                <option value="tablespoon">tablespoon(s)</option>
                                <option value="fluid ounce">fluid ounce(s)</option>
                                <option value="cup">cup(s)</option>
                                <option value="pint">pint(s)</option>
                                <option value="quart">quart(s)</option>
                                <option value="gallon">gallon(s)</option>
                                <option value="milliliter">milliliter(s)</option>
                                <option value="liter">liter(s)</option>
                                <option value="ounce">ounce(s)</option>
                                <option value="pound">pound(s)</option>
                            </select></label>
                        <label for="ingredientName">Name:
                        <input type="text" placeholder="Cookies (crushed)" id="ingredientName"></label>
                        <button type="button" id="addIngredient">+ Add Ingredient</button>
                </div>
                <div id="enteredIngredients">

                </div>    
            </fieldset>

            

            <fieldset>
                <legend>Steps</legend>
                <span id="stepDirections">Enter a step to make your recipe. Click the 'plus' to add a step.</span>
                <label for="stepInput" class="visuallyHidden">Step:</label>
                <textarea  placeholder="Describe the step in one or two short sentences." id="stepInput" rows="2" cols="25" maxlength="255"></textarea>
                <button type="button" id="addStep">+ Add Step</button>
                <div id="enteredSteps">
                    
                </div>  
            </fieldset>

            <label for="recipe_image" class="recipePartName">Image Upload</label>
            <input type="file" id="recipe_image" name="recipe_image">
            <img id="imagePreview" src="#" alt="Image Preview" style="display:none; width: 300px; height: auto; margin-top: 10px;">

            <label for="youtube_link" class="recipePartName">YouTube Video Link:</label>
            <input type="url" id="youtube_link" name="recipe_video[recipe_video_url]" placeholder="https://www.youtube.com/watch?v=...">

                <input type="submit" value="Create Recipe" id="createRecipeButton">
                <input type="reset" value="Clear Form" id="clearRecipeFormButton">
            
        </form>
    </div>
</main>


<?php include(SHARED_PATH . '/public_footer.php'); ?>
